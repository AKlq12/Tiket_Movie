<?php

namespace App\Exports;

use App\Models\ActivityLog;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ActivityLogExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        // Ambil data log aktivitas
        return ActivityLog::select('created_at', 'user_name', 'action', 'description')->latest()->get();
    }

    public function headings(): array
    {
        return ["Waktu", "User", "Aksi", "Detail Deskripsi"];
    }
}