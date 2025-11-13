<?php

namespace Database\Seeders;

use App\Models\PaymentGatewayConfig;
use App\Models\SubscriptionPackage;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class FinanceDummyDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create Subscription Packages
        $packages = [
            [
                'name' => 'Gratis',
                'slug' => 'gratis',
                'description' => 'Paket gratis untuk memulai website desa atau UMKM dengan fitur dasar',
                'price' => 0,
                'duration_days' => 365, // 1 tahun
                'benefits' => [
                    'Template dasar',
                    '5 halaman website',
                    '10 produk UMKM',
                    'Support email',
                    'Subdomain gratis',
                ],
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Premium',
                'slug' => 'premium',
                'description' => 'Paket premium dengan fitur lengkap untuk website profesional',
                'price' => 299000,
                'duration_days' => 365, // 1 tahun
                'benefits' => [
                    'Template premium',
                    'Halaman unlimited',
                    'Produk UMKM unlimited',
                    'Support prioritas',
                    'Custom domain',
                    'SSL certificate',
                    'Backup otomatis',
                    'Analytics dashboard',
                ],
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Bisnis',
                'slug' => 'bisnis',
                'description' => 'Paket bisnis dengan fitur enterprise untuk kebutuhan bisnis besar',
                'price' => 599000,
                'duration_days' => 365, // 1 tahun
                'benefits' => [
                    'Template premium + custom',
                    'Halaman unlimited',
                    'Produk UMKM unlimited',
                    'Support 24/7',
                    'Custom domain + subdomain',
                    'SSL certificate',
                    'Backup otomatis harian',
                    'Analytics dashboard',
                    'E-commerce integration',
                    'API access',
                    'White label',
                ],
                'is_active' => true,
                'sort_order' => 3,
            ],
        ];

        foreach ($packages as $package) {
            SubscriptionPackage::updateOrCreate(
                ['slug' => $package['slug']],
                $package
            );
        }

        // 2. Create Payment Gateway Configs
        $gateways = [
            [
                'gateway' => 'midtrans',
                'environment' => 'sandbox',
                'server_key' => 'SB-Mid-server-dummy-key-123456789',
                'client_key' => 'SB-Mid-client-dummy-key-123456789',
                'is_active' => true,
            ],
            [
                'gateway' => 'xendit',
                'environment' => 'sandbox',
                'api_key' => 'xnd_development_dummy_key_123456789',
                'secret_key' => 'xnd_development_dummy_secret_123456789',
                'is_active' => false,
            ],
        ];

        foreach ($gateways as $gateway) {
            PaymentGatewayConfig::updateOrCreate(
                ['gateway' => $gateway['gateway']],
                $gateway
            );
        }

        // 3. Create Additional Dummy Users for Transactions
        $dummyUsers = [
            ['name' => 'Budi Santoso', 'email' => 'budi.santoso@example.com', 'role' => User::ROLE_ADMIN_DESA],
            ['name' => 'Siti Nurhaliza', 'email' => 'siti.nurhaliza@example.com', 'role' => User::ROLE_ADMIN_DESA],
            ['name' => 'Ahmad Fauzi', 'email' => 'ahmad.fauzi@example.com', 'role' => User::ROLE_ADMIN_DESA],
            ['name' => 'Rina Wati', 'email' => 'rina.wati@example.com', 'role' => User::ROLE_ADMIN_UMKM],
            ['name' => 'Joko Widodo', 'email' => 'joko.widodo@example.com', 'role' => User::ROLE_ADMIN_UMKM],
            ['name' => 'Maya Sari', 'email' => 'maya.sari@example.com', 'role' => User::ROLE_ADMIN_UMKM],
            ['name' => 'Dedi Kurniawan', 'email' => 'dedi.kurniawan@example.com', 'role' => User::ROLE_ADMIN_DESA],
            ['name' => 'Lina Marlina', 'email' => 'lina.marlina@example.com', 'role' => User::ROLE_ADMIN_UMKM],
        ];

        foreach ($dummyUsers as $userData) {
            User::updateOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['name'],
                    'role' => $userData['role'],
                    'password' => \Hash::make('password'),
                    'status' => 'active',
                    'email_verified_at' => now(),
                ]
            );
        }

        // 4. Create Dummy Transactions
        $users = User::where('role', '!=', User::ROLE_SUPER_ADMIN)->get();
        $packageIds = SubscriptionPackage::pluck('id')->toArray();
        
        if ($users->isEmpty()) {
            $this->command->warn('No users found. Please run UserSeeder first.');
            return;
        }

        if (empty($packageIds)) {
            $this->command->warn('No packages found. Creating packages first...');
            return;
        }

        $statuses = ['success', 'pending', 'failed', 'cancelled'];
        $paymentMethods = ['midtrans', 'xendit', 'manual'];
        
        // Create transactions for the last 3 months
        for ($i = 0; $i < 50; $i++) {
            $user = $users->random();
            $packageId = $packageIds[array_rand($packageIds)];
            $package = SubscriptionPackage::find($packageId);
            
            $status = $statuses[array_rand($statuses)];
            $paymentMethod = $paymentMethods[array_rand($paymentMethods)];
            
            // Generate transaction code
            $transactionCode = 'TXN-' . strtoupper(Str::random(8)) . '-' . date('Ymd');
            
            // Random date within last 3 months
            $randomDays = rand(0, 90);
            $createdAt = now()->subDays($randomDays);
            
            // If success, set paid_at
            $paidAt = null;
            if ($status === 'success') {
                $paidAt = $createdAt->copy()->addHours(rand(1, 24));
            }
            
            Transaction::create([
                'transaction_code' => $transactionCode,
                'user_id' => $user->id,
                'subscription_package_id' => $packageId,
                'amount' => $package->price,
                'status' => $status,
                'payment_method' => $paymentMethod,
                'payment_gateway_transaction_id' => $status === 'success' ? 'GW-' . strtoupper(Str::random(12)) : null,
                'payment_gateway_response' => $status === 'success' ? [
                    'transaction_status' => 'settlement',
                    'order_id' => $transactionCode,
                    'gross_amount' => (string) $package->price,
                    'payment_type' => $paymentMethod,
                ] : null,
                'paid_at' => $paidAt,
                'notes' => $status === 'failed' ? 'Pembayaran gagal karena timeout' : null,
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ]);
        }

        $this->command->info('Finance dummy data seeded successfully!');
        $this->command->info('- ' . SubscriptionPackage::count() . ' subscription packages created');
        $this->command->info('- ' . PaymentGatewayConfig::count() . ' payment gateway configs created');
        $this->command->info('- ' . count($dummyUsers) . ' additional dummy users created');
        $this->command->info('- ' . Transaction::count() . ' transactions created');
    }
}
