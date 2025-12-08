<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Seat;
use App\Models\Ticket;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class BookingController extends Controller
{
    // 1. Tampilkan Denah Kursi
    public function create($scheduleId)
    {
        $schedule = Schedule::with(['film', 'seats'])->findOrFail($scheduleId);
        
        // Jika kursi belum digenerate untuk jadwal ini, kita buat otomatis (Lazy Init)
        if ($schedule->seats->isEmpty()) {
            $this->generateSeats($schedule);
            $schedule->refresh(); // Refresh data agar seats muncul
        }

        return view('booking.create', compact('schedule'));
    }

    // 2. Proses Booking (Multi-Seat Atomic Transaction)
    // INI BAGIAN YANG SUDAH DI-UPGRADE
    public function store(Request $request, $scheduleId)
    {
        // Validasi: pastikan 'seats' adalah daftar/array, bukan cuma satu data
        $request->validate([
            'seats' => 'required|array|min:1',
        ]);

        try {
            // MULAI TRANSAKSI DATABASE
            DB::transaction(function () use ($request, $scheduleId) {
                
                // Kita Loop (Ulangi) proses booking untuk SETIAP kursi yang dipilih
                foreach ($request->seats as $seatNumber) {

                    // A. Cari Kursi & KUNCI (Lock)
                    $seat = Seat::where('schedule_id', $scheduleId)
                                ->where('seat_number', $seatNumber)
                                ->lockForUpdate() // Kunci biar tidak diserobot orang lain
                                ->firstOrFail();

                    // B. Cek Status Terkini
                    if ($seat->status === 'booked') {
                        // Jika SATU saja kursi gagal, batalkan SEMUA transaksi
                        throw new \Exception("Maaf, kursi {$seatNumber} baru saja diambil orang lain! Transaksi dibatalkan.");
                    }

                    // C. Update Kursi jadi Booked
                    $seat->status = 'booked';
                    $seat->user_id = Auth::id();
                    $seat->save();

                    // D. Cetak Tiket
                    Ticket::create([
                        'user_id' => Auth::id(),
                        'schedule_id' => $scheduleId,
                        'seat_id' => $seat->id,
                        'booking_time' => now(),
                        'payment_status' => 'paid',
                    ]);

                    // E. CATAT LOG UNTUK MANAGER
                    ActivityLog::create([
                        'user_name' => Auth::user()->name,
                        'action' => 'Booking Tiket',
                        'description' => "Membeli tiket film " . $seat->schedule->film->title . " (Kursi: $seatNumber)",
                    ]);
                }
            });

            return redirect()->route('home')->with('success', 'Berhasil! Semua tiket pilihanmu sudah terbit.');

        } catch (\Exception $e) {
            // Jika error, kembali ke halaman pilih kursi dengan pesan error
            return back()->with('error', $e->getMessage());
        }
    }

    // Helper: Buat 20 kursi otomatis (A1-A5, B1-B5, dst)
    private function generateSeats($schedule)
    {
        $rows = ['A', 'B', 'C', 'D'];
        foreach ($rows as $row) {
            for ($i = 1; $i <= 5; $i++) {
                Seat::create([
                    'schedule_id' => $schedule->id,
                    'seat_number' => $row . $i,
                    'status' => 'available'
                ]);
            }
        }
    }
}