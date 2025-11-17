<?php
// app/Http/Controllers/Desa/LayananController.php

namespace App\Http\Controllers\Desa;

use App\Http\Controllers\Controller;
use App\Models\LetterSubmission;
use App\Models\CitizenComplaint;
use App\Models\Village;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class LayananController extends Controller
{
    protected ?Village $villageModel = null;

    public function index()
    {
        $village = $this->village();
        
        // Get recent submissions for this village
        $recentSubmissions = LetterSubmission::where('village_id', $village->id)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get()
            ->map(function ($submission) {
                return [
                    'id' => $submission->tracking_code,
                    'jenis' => $submission->letter_type_name,
                    'pemohon' => $submission->nama,
                    'tanggal' => $submission->created_at->toDateString(),
                    'status' => $this->mapStatusToArsip($submission->status),
                    'file_url' => $submission->completed_file_path ? Storage::url($submission->completed_file_path) : null,
                ];
            })
            ->toArray();

        $data = [
            'jenisSurat' => $this->getJenisSurat(),
            'arsipSurat' => $recentSubmissions,
            'kategoriPengaduan' => $this->getKategoriPengaduan(),
            'statistikPengaduan' => $this->getStatistikPengaduan(),
            'statistikLayanan' => $this->getStatistikLayanan()
        ];
        
        return view('pages.desa.layanan.index', $data);
    }
    
    public function submitSurat(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'jenis_surat' => 'required|in:ktp,domisili,usaha,tidak-mampu,belum-menikah,kelahiran',
            'nama' => 'required|string|max:255',
            'nik' => 'required|string|max:20',
            'telepon' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'alamat' => 'required|string',
            'keperluan' => 'required|string',
            'persyaratan' => 'nullable|array',
            'persyaratan.*' => 'file|mimes:pdf,jpg,jpeg,png|max:5120', // 5MB max
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $village = $this->village();
        
        // Handle file uploads
        $requirementsFiles = [];
        if ($request->hasFile('persyaratan')) {
            foreach ($request->file('persyaratan') as $index => $file) {
                if ($file->isValid()) {
                    $path = $file->store('letter-submissions/requirements', 'public');
                    $requirementsFiles[] = $path;
                }
            }
        }

        // Create submission
        $submission = LetterSubmission::create([
            'village_id' => $village->id,
            'letter_type' => $request->jenis_surat,
            'nama' => $request->nama,
            'nik' => $request->nik,
            'telepon' => $request->telepon,
            'email' => $request->email,
            'alamat' => $request->alamat,
            'keperluan' => $request->keperluan,
            'requirements_files' => $requirementsFiles,
            'status' => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Permohonan surat berhasil dikirim',
            'tracking_id' => $submission->tracking_code
        ]);
    }

    protected function village(): Village
    {
        if ($this->villageModel) {
            return $this->villageModel;
        }

        return $this->villageModel = Village::query()->firstOrCreate(
            ['slug' => 'desa-sejahtera'],
            ['name' => 'Desa Sejahtera']
        );
    }

    private function mapStatusToArsip(string $status): string
    {
        return match($status) {
            'completed' => 'selesai',
            'processed', 'verified' => 'proses',
            'rejected' => 'ditolak',
            default => 'proses',
        };
    }
    
    public function submitPengaduan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'telepon' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'kategori' => 'required|in:pelayanan-umum,infrastruktur,sosial,keamanan',
            'lokasi' => 'nullable|string|max:255',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string|min:50',
            'bukti' => 'nullable|array',
            'bukti.*' => 'file|mimes:pdf,jpg,jpeg,png|max:5120', // 5MB max
            'is_anonymous' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $village = $this->village();
        
        // Handle file uploads
        $buktiFiles = [];
        if ($request->hasFile('bukti')) {
            foreach ($request->file('bukti') as $file) {
                if ($file->isValid()) {
                    $path = $file->store('citizen-complaints/evidence', 'public');
                    $buktiFiles[] = $path;
                }
            }
        }

        // Create complaint
        $complaint = CitizenComplaint::create([
            'village_id' => $village->id,
            'nama' => $request->nama,
            'telepon' => $request->telepon,
            'email' => $request->email,
            'kategori' => $request->kategori,
            'lokasi' => $request->lokasi,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'bukti_files' => $buktiFiles,
            'is_anonymous' => $request->has('is_anonymous') ? (bool)$request->is_anonymous : false,
            'status' => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pengaduan Anda telah diterima dan akan segera ditindaklanjuti',
            'tracking_id' => $complaint->tracking_code
        ]);
    }
    
    public function trackStatus(Request $request)
    {
        $code = $request->get('code');
        // Logic untuk tracking status
        return response()->json([
            'success' => true,
            'data' => $this->getDummyTrackingData($code)
        ]);
    }
    
    public function downloadArsip($id)
    {
        // Logic untuk download arsip
        // Untuk demo, redirect ke file dummy
        return redirect('#');
    }
    
    // Private methods untuk dummy data
    private function getJenisSurat()
    {
        return [
            [
                'id' => 'ktp',
                'nama' => 'Surat Pengantar KTP',
                'deskripsi' => 'Surat pengantar untuk pembuatan atau perpanjangan KTP',
                'icon' => 'identification',
                'persyaratan' => ['Fotocopy KK', 'Pas foto 3x4', 'Surat RT/RW'],
                'estimasi' => '1-2 hari kerja'
            ],
            [
                'id' => 'domisili',
                'nama' => 'Surat Keterangan Domisili',
                'deskripsi' => 'Surat keterangan tempat tinggal untuk keperluan administrasi',
                'icon' => 'home',
                'persyaratan' => ['Fotocopy KTP', 'Fotocopy KK', 'Surat RT/RW'],
                'estimasi' => '1 hari kerja'
            ],
            [
                'id' => 'usaha',
                'nama' => 'Surat Keterangan Usaha',
                'deskripsi' => 'Surat keterangan untuk keperluan izin usaha atau UMKM',
                'icon' => 'briefcase',
                'persyaratan' => ['Fotocopy KTP', 'Foto tempat usaha', 'Surat RT/RW'],
                'estimasi' => '2-3 hari kerja'
            ],
            [
                'id' => 'tidak-mampu',
                'nama' => 'Surat Keterangan Tidak Mampu',
                'deskripsi' => 'Surat keterangan untuk bantuan sosial atau pendidikan',
                'icon' => 'heart',
                'persyaratan' => ['Fotocopy KTP', 'Fotocopy KK', 'Surat RT/RW', 'Foto rumah'],
                'estimasi' => '1-2 hari kerja'
            ],
            [
                'id' => 'belum-menikah',
                'nama' => 'Surat Keterangan Belum Menikah',
                'deskripsi' => 'Surat keterangan status belum menikah',
                'icon' => 'user',
                'persyaratan' => ['Fotocopy KTP', 'Fotocopy KK', 'Pas foto 3x4'],
                'estimasi' => '1 hari kerja'
            ],
            [
                'id' => 'kelahiran',
                'nama' => 'Surat Keterangan Kelahiran',
                'deskripsi' => 'Surat keterangan untuk pengurusan akta kelahiran',
                'icon' => 'cake',
                'persyaratan' => ['Fotocopy KTP orang tua', 'Fotocopy KK', 'Surat keterangan lahir dari bidan/dokter'],
                'estimasi' => '1 hari kerja'
            ]
        ];
    }
    
    private function getRecentArsip()
    {
        return [
            [
                'id' => 'SRT-20241201-001',
                'jenis' => 'Surat Pengantar KTP',
                'pemohon' => 'Ahmad Wijaya',
                'tanggal' => '2024-12-01',
                'status' => 'selesai',
                'file_url' => '#'
            ],
            [
                'id' => 'SRT-20241130-002',
                'jenis' => 'Surat Keterangan Domisili',
                'pemohon' => 'Siti Nurhaliza',
                'tanggal' => '2024-11-30',
                'status' => 'proses',
                'file_url' => null
            ],
            [
                'id' => 'SRT-20241129-003',
                'jenis' => 'Surat Keterangan Usaha',
                'pemohon' => 'Budi Santoso',
                'tanggal' => '2024-11-29',
                'status' => 'selesai',
                'file_url' => '#'
            ],
            [
                'id' => 'SRT-20241128-004',
                'jenis' => 'Surat Keterangan Tidak Mampu',
                'pemohon' => 'Indah Permatasari',
                'tanggal' => '2024-11-28',
                'status' => 'ditolak',
                'file_url' => null
            ],
            [
                'id' => 'SRT-20241127-005',
                'jenis' => 'Surat Keterangan Belum Menikah',
                'pemohon' => 'Rudi Hermawan',
                'tanggal' => '2024-11-27',
                'status' => 'selesai',
                'file_url' => '#'
            ]
        ];
    }
    
    private function getKategoriPengaduan()
    {
        $village = $this->village();
        
        $kategoriData = [
            [
                'id' => 'pelayanan-umum',
                'nama' => 'Pelayanan Umum',
                'deskripsi' => 'Keluhan terkait pelayanan administrasi dan birokrasi',
                'icon' => 'clipboard-document-list',
                'color' => 'sky',
            ],
            [
                'id' => 'infrastruktur',
                'nama' => 'Infrastruktur',
                'deskripsi' => 'Laporan kerusakan jalan, jembatan, dan fasilitas umum',
                'icon' => 'wrench-screwdriver',
                'color' => 'amber',
            ],
            [
                'id' => 'sosial',
                'nama' => 'Sosial Kemasyarakatan',
                'deskripsi' => 'Masalah sosial, bantuan masyarakat, dan program desa',
                'icon' => 'users',
                'color' => 'pink',
            ],
            [
                'id' => 'keamanan',
                'nama' => 'Keamanan & Ketertiban',
                'deskripsi' => 'Laporan gangguan keamanan dan ketertiban lingkungan',
                'icon' => 'shield-check',
                'color' => 'indigo',
            ]
        ];
        
        // Add jumlah for each category
        foreach ($kategoriData as &$kategori) {
            $kategori['jumlah'] = CitizenComplaint::where('village_id', $village->id)
                ->where('kategori', $kategori['id'])
                ->count();
        }
        
        return $kategoriData;
    }
    
    private function getStatistikPengaduan()
{
    $village = $this->village();

    $selesai = CitizenComplaint::where('village_id', $village->id)
        ->where('status', 'resolved')
        ->count();

    $proses = CitizenComplaint::where('village_id', $village->id)
        ->whereIn('status', ['reviewed', 'in_progress'])
        ->count();

    $bulanIni = CitizenComplaint::where('village_id', $village->id)
        ->whereMonth('created_at', now()->month)
        ->whereYear('created_at', now()->year)
        ->count();

    // Total dihitung dari selesai + proses (paling akurat)
    $total = $selesai + $proses;

    // Jika total 0, gunakan dummy saja untuk tampilan awal
    if ($total === 0) {
        $total = 28;
        $selesai = 20;
        $proses = 8;
        $bulanIni = 12;
    }

    return [
        'total' => $total,
        'bulan_ini' => $bulanIni,
        'selesai' => $selesai,
        'proses' => $proses
    ];
    }
    
    private function getStatistikLayanan()
    {
        return [
            'surat_diproses' => 156,
            'surat_selesai' => 89,
            'pengaduan_masuk' => 23,
            'pengaduan_selesai' => 18
        ];
    }
    
    private function getDummyTrackingData($code)
    {
        return [
            'id' => $code,
            'jenis' => 'Surat Pengantar KTP',
            'pemohon' => 'Ahmad Wijaya',
            'tanggal' => '2024-12-01',
            'status' => 'selesai',
            'file_url' => '#',
            'timeline' => [
                ['status' => 'Diajukan', 'tanggal' => '2024-12-01 09:00', 'completed' => true],
                ['status' => 'Diverifikasi', 'tanggal' => '2024-12-01 14:30', 'completed' => true],
                ['status' => 'Diproses', 'tanggal' => '2024-12-02 10:00', 'completed' => true],
                ['status' => 'Selesai', 'tanggal' => '2024-12-02 16:00', 'completed' => true]
            ]
        ];
    }
}