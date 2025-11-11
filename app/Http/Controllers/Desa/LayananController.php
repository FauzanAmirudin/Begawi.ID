<?php
// app/Http/Controllers/Desa/LayananController.php

namespace App\Http\Controllers\Desa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LayananController extends Controller
{
    public function index()
    {
        $data = [
            'jenisSurat' => $this->getJenisSurat(),
            'arsipSurat' => $this->getRecentArsip(),
            'kategoriPengaduan' => $this->getKategoriPengaduan(),
            'statistikPengaduan' => $this->getStatistikPengaduan(),
            'statistikLayanan' => $this->getStatistikLayanan()
        ];
        
        return view('pages.desa.layanan.index', $data);
    }
    
    public function submitSurat(Request $request)
    {
        // Logic untuk submit surat online
        return response()->json([
            'success' => true,
            'message' => 'Permohonan surat berhasil dikirim',
            'tracking_id' => 'SRT-' . date('Ymd') . '-' . rand(1000, 9999)
        ]);
    }
    
    public function submitPengaduan(Request $request)
    {
        // Logic untuk submit pengaduan
        return response()->json([
            'success' => true,
            'message' => 'Pengaduan Anda telah diterima dan akan segera ditindaklanjuti',
            'ticket_id' => 'ADU-' . date('Ymd') . '-' . rand(1000, 9999)
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
        return [
            [
                'id' => 'pelayanan-umum',
                'nama' => 'Pelayanan Umum',
                'deskripsi' => 'Keluhan terkait pelayanan administrasi dan birokrasi',
                'icon' => 'clipboard-document-list',
                'color' => 'sky',
                'jumlah' => 12
            ],
            [
                'id' => 'infrastruktur',
                'nama' => 'Infrastruktur',
                'deskripsi' => 'Laporan kerusakan jalan, jembatan, dan fasilitas umum',
                'icon' => 'wrench-screwdriver',
                'color' => 'amber',
                'jumlah' => 8
            ],
            [
                'id' => 'sosial',
                'nama' => 'Sosial Kemasyarakatan',
                'deskripsi' => 'Masalah sosial, bantuan masyarakat, dan program desa',
                'icon' => 'users',
                'color' => 'pink',
                'jumlah' => 5
            ],
            [
                'id' => 'keamanan',
                'nama' => 'Keamanan & Ketertiban',
                'deskripsi' => 'Laporan gangguan keamanan dan ketertiban lingkungan',
                'icon' => 'shield-check',
                'color' => 'indigo',
                'jumlah' => 3
            ]
        ];
    }
    
    private function getStatistikPengaduan()
    {
        return [
            'total' => 28,
            'bulan_ini' => 12,
            'selesai' => 20,
            'proses' => 8
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