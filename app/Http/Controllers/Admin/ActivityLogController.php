<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Str;

class ActivityLogController extends Controller
{
    public function reportPage()
    {
        return view('admin.super-admin.logs.download-report');
    }

    public function userActivity(Request $request)
    {
        $filters = [
            'user' => $request->get('user'),
            'date' => $request->get('date'),
            'search' => $request->get('search'),
        ];

        $activities = collect([
            [
                'time' => '2025-11-13 09:20',
                'type' => 'create',
                'user' => 'Super Admin',
                'user_role' => 'super_admin',
                'desc' => 'Admin Desa A menambahkan konten berita',
                'context' => 'Artikel / Berita',
            ],
            [
                'time' => '2025-11-13 08:55',
                'type' => 'update',
                'user' => 'Admin Desa B',
                'user_role' => 'admin_desa',
                'desc' => 'Mengubah status domain desa-b.id menjadi aktif',
                'context' => 'Manajemen Website',
            ],
            [
                'time' => '2025-11-13 08:10',
                'type' => 'login',
                'user' => 'Finance Admin',
                'user_role' => 'finance',
                'desc' => 'Login berhasil dari IP 103.15.12.22',
                'context' => 'Otentikasi',
            ],
            [
                'time' => '2025-11-13 07:42',
                'type' => 'payment',
                'user' => 'UMKM Admin',
                'user_role' => 'umkm',
                'desc' => 'Mencatat pembayaran paket langganan PRO',
                'context' => 'Keuangan',
            ],
        ]);

        // Apply filters
        $filtered = $activities->filter(function ($item) use ($filters) {
            // Filter by user (contains on 'user' field)
            if (!empty($filters['user'])) {
                if (!Str::of($item['user'])->lower()->contains(Str::lower($filters['user']))) {
                    return false;
                }
            }

            // Filter by date (match YYYY-MM-DD part of 'time')
            if (!empty($filters['date'])) {
                $datePart = substr($item['time'], 0, 10);
                if ($datePart !== $filters['date']) {
                    return false;
                }
            }

            // Search across multiple fields
            if (!empty($filters['search'])) {
                $needle = Str::lower($filters['search']);
                $haystack = Str::lower(
                    implode(' ', [
                        $item['time'],
                        $item['type'],
                        $item['user'],
                        $item['user_role'],
                        $item['desc'],
                        $item['context'],
                    ])
                );
                if (!Str::contains($haystack, $needle)) {
                    return false;
                }
            }

            return true;
        })->values();

        return view('admin.super-admin.logs.user-activity', [
            'activities' => $filtered,
            'filters' => $filters,
        ]);
    }

    public function systemAudit(Request $request)
    {
        $filters = [
            'level' => $request->get('level'),
            'date' => $request->get('date'),
            'search' => $request->get('search'),
        ];

        $systemLogs = collect([
            [
                'time' => '2025-11-13 09:30:12',
                'level' => 'INFO',
                'component' => 'Scheduler',
                'message' => 'Backup otomatis selesai dalam 2m13s',
                'meta' => ['job' => 'daily-backup', 'status' => 'success'],
            ],
            [
                'time' => '2025-11-13 09:02:01',
                'level' => 'WARNING',
                'component' => 'Queue',
                'message' => 'Antrian email meningkat di atas ambang batas',
                'meta' => ['queue' => 'emails', 'size' => 128],
            ],
            [
                'time' => '2025-11-13 08:47:55',
                'level' => 'ERROR',
                'component' => 'PaymentGateway',
                'message' => 'Timeout saat menghubungi provider',
                'meta' => ['provider' => 'Midtrans', 'timeout_ms' => 3000],
            ],
            [
                'time' => '2025-11-13 08:20:11',
                'level' => 'INFO',
                'component' => 'System',
                'message' => 'Rotasi log berhasil dijalankan',
                'meta' => ['files_rotated' => 5],
            ],
        ]);

        // Apply filters
        $filtered = $systemLogs->filter(function ($item) use ($filters) {
            // Level exact match
            if (!empty($filters['level'])) {
                if (Str::upper($item['level']) !== Str::upper($filters['level'])) {
                    return false;
                }
            }

            // Date match on YYYY-MM-DD prefix
            if (!empty($filters['date'])) {
                $datePart = substr($item['time'], 0, 10);
                if ($datePart !== $filters['date']) {
                    return false;
                }
            }

            // Search across fields (including meta)
            if (!empty($filters['search'])) {
                $needle = Str::lower($filters['search']);
                $metaStr = Str::lower(json_encode($item['meta']));
                $haystack = Str::lower(
                    implode(' ', [
                        $item['time'],
                        $item['level'],
                        $item['component'],
                        $item['message'],
                        $metaStr,
                    ])
                );
                if (!Str::contains($haystack, $needle)) {
                    return false;
                }
            }

            return true;
        })->values();

        $backupSummary = [
            'last_backup_at' => '2025-11-13 09:30',
            'last_backup_status' => 'success',
            'next_backup_eta' => '23:59',
            'storage_used' => '2.4 GB',
            'files_count' => 1542,
        ];

        return view('admin.super-admin.logs.system-audit', [
            'systemLogs' => $filtered,
            'filters' => $filters,
            'backupSummary' => $backupSummary,
        ]);
    }

    public function downloadReport(Request $request)
    {
        $type = $request->get('type', 'user');
        $format = strtolower($request->get('format', 'xls')); // xls|xlsx|pdf

        // Build rows
        $rows = [
            ['Time', 'User', 'Action', 'Context', 'Description'],
            ['2025-11-13 09:20', 'Super Admin', 'CREATE', 'Artikel / Berita', 'Admin Desa A menambahkan konten berita'],
            ['2025-11-13 08:55', 'Admin Desa B', 'UPDATE', 'Manajemen Website', 'Mengubah status domain desa-b.id menjadi aktif'],
        ];

        if (in_array($format, ['xls', 'xlsx'])) {
            // Use HTML table-based XLS for maximum compatibility without external packages
            $filename = 'activity-report-' . $type . '-' . now()->format('Ymd_His') . '.xls';
            $headers = [
                'Content-Type' => 'application/vnd.ms-excel; charset=UTF-8',
                'Content-Disposition' => "attachment; filename=\"$filename\"",
                'Cache-Control' => 'max-age=0',
            ];

            $html = '<html><head><meta charset="UTF-8"></head><body><table border="1" cellspacing="0" cellpadding="4">';
            foreach ($rows as $i => $r) {
                $html .= '<tr>';
                foreach ($r as $cell) {
                    $tag = $i === 0 ? 'th' : 'td';
                    $html .= '<' . $tag . '>' . htmlspecialchars($cell, ENT_QUOTES, 'UTF-8') . '</' . $tag . '>';
                }
                $html .= '</tr>';
            }
            $html .= '</table></body></html>';

            return response($html, 200, $headers);
        }

        if ($format === 'pdf') {
            // If Dompdf is available, render a simple PDF
            if (class_exists(\Dompdf\Dompdf::class)) {
                $dompdf = new \Dompdf\Dompdf([
                    'isRemoteEnabled' => true,
                    'defaultFont' => 'Helvetica',
                ]);

                $html = '<html><head><meta charset="UTF-8"><style>table{border-collapse:collapse;width:100%;font-size:12px}th,td{border:1px solid #ccc;padding:6px;text-align:left}th{background:#f5f5f5}</style></head><body>';
                $html .= '<h3 style="margin:0 0 10px 0">Activity Report (' . htmlspecialchars(ucfirst($type), ENT_QUOTES, 'UTF-8') . ')</h3>';
                $html .= '<table>';
                foreach ($rows as $i => $r) {
                    $html .= '<tr>';
                    foreach ($r as $cell) {
                        $tag = $i === 0 ? 'th' : 'td';
                        $html .= '<' . $tag . '>' . htmlspecialchars($cell, ENT_QUOTES, 'UTF-8') . '</' . $tag . '>';
                    }
                    $html .= '</tr>';
                }
                $html .= '</table></body></html>';

                $dompdf->loadHtml($html, 'UTF-8');
                $dompdf->setPaper('A4', 'portrait');
                $dompdf->render();

                $filename = 'activity-report-' . $type . '-' . now()->format('Ymd_His') . '.pdf';
                return response($dompdf->output(), 200, [
                    'Content-Type' => 'application/pdf',
                    'Content-Disposition' => "attachment; filename=\"$filename\"",
                ]);
            }

            // Graceful fallback message if Dompdf is not installed
            return response('PDF export requires dompdf. Please install: composer require barryvdh/laravel-dompdf', 422, [
                'Content-Type' => 'text/plain; charset=UTF-8',
            ]);
        }

        // Unsupported format fallback
        return response('Unsupported format.', 400);
    }
}


