<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Village;
use App\Models\Website;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RegisterVillagesAsWebsites extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'villages:register-as-websites {--force : Force registration even if website exists}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mendaftarkan semua Village yang ada sebagai Website aktif di direktori platform';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Memulai pendaftaran Village sebagai Website...');
        $this->newLine();

        $villages = Village::whereNull('website_id')->get();

        if ($villages->isEmpty()) {
            $this->info('✓ Semua Village sudah terdaftar sebagai Website.');
            return 0;
        }

        $this->info("Ditemukan {$villages->count()} Village yang belum terdaftar.");
        $this->newLine();

        $bar = $this->output->createProgressBar($villages->count());
        $bar->start();

        $registered = 0;
        $skipped = 0;

        foreach ($villages as $village) {
            try {
                // Check if website already exists for this village
                $existingWebsite = Website::where('type', 'desa')
                    ->where('name', $village->name)
                    ->first();

                if ($existingWebsite && !$this->option('force')) {
                    // Link village to existing website
                    $village->update(['website_id' => $existingWebsite->id]);
                    $skipped++;
                    $bar->advance();
                    continue;
                }

                // Generate subdomain from village name
                $subdomain = Str::slug($village->name);
                
                // Ensure subdomain is unique
                $counter = 1;
                $originalSubdomain = $subdomain;
                while (Website::where('url', $subdomain)->exists()) {
                    $subdomain = $originalSubdomain . '-' . $counter;
                    $counter++;
                }

                // Get or create admin desa user for this village
                $adminUser = $this->getOrCreateAdminUser($village);

                // Create website
                $website = Website::updateOrCreate(
                    [
                        'type' => 'desa',
                        'name' => $village->name,
                    ],
                    [
                        'url' => $subdomain,
                        'status' => 'active',
                        'user_id' => $adminUser->id,
                        'template_id' => 'desa-template',
                    ]
                );

                // Link village to website
                $village->update(['website_id' => $website->id]);

                $registered++;
            } catch (\Exception $e) {
                $this->newLine();
                $this->error("Error untuk Village '{$village->name}': " . $e->getMessage());
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);

        $this->info("✓ Selesai!");
        $this->info("  - {$registered} Village berhasil didaftarkan");
        if ($skipped > 0) {
            $this->info("  - {$skipped} Village sudah memiliki Website (dilink)");
        }

        return 0;
    }

    /**
     * Get or create admin user for village
     */
    protected function getOrCreateAdminUser(Village $village): User
    {
        // Try to find existing admin desa user for this village
        $adminUser = User::where('role', User::ROLE_ADMIN_DESA)
            ->where('village_id', $village->id)
            ->first();

        if ($adminUser) {
            return $adminUser;
        }

        // Try to find any admin desa user without village
        $adminUser = User::where('role', User::ROLE_ADMIN_DESA)
            ->whereNull('village_id')
            ->first();

        if ($adminUser) {
            $adminUser->update(['village_id' => $village->id]);
            return $adminUser;
        }

        // Create new admin desa user
        $email = Str::slug($village->name, '') . '@desa.begawi.id';
        
        // Ensure email is unique
        $counter = 1;
        $originalEmail = $email;
        while (User::where('email', $email)->exists()) {
            $email = str_replace('@desa.begawi.id', $counter . '@desa.begawi.id', $originalEmail);
            $counter++;
        }

        return User::create([
            'name' => 'Admin ' . $village->name,
            'email' => $email,
            'password' => Hash::make('password'), // Default password, should be changed
            'role' => User::ROLE_ADMIN_DESA,
            'status' => 'active',
            'village_id' => $village->id,
            'email_verified_at' => now(),
        ]);
    }
}
