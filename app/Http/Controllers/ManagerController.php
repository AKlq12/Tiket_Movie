<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Ticket;
use App\Exports\ActivityLogExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class ManagerController extends Controller
{
    public function index()
    {
        // 1. Ambil Log Terbaru
        $logs = ActivityLog::latest()->limit(50)->get();

        // 2. Hitung Statistik Sederhana (Monitoring)
        $totalTickets = Ticket::count();
        // Hitung omzet (Join ke schedule untuk ambil harga)
        $totalRevenue = Ticket::join('schedules', 'tickets.schedule_id', '=', 'schedules.id')
                        ->sum('schedules.price');

        return view('manager.dashboard', compact('logs', 'totalTickets', 'totalRevenue'));
    }

    public function exportExcel()
    {
        return Excel::download(new ActivityLogExport, 'laporan-aktivitas.xlsx');
    }
}