<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    public function index()
    {
        // Ambil semua tiket milik user yang sedang login
        // Urutkan dari yang paling baru
        $tickets = Ticket::where('user_id', Auth::id())
                         ->with(['schedule.film', 'seat']) // Ambil data relasi film & kursi
                         ->latest()
                         ->get();

        return view('tickets.index', compact('tickets'));
    }
}