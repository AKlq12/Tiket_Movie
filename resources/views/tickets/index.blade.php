<!DOCTYPE html>
<html lang="id">
<head>
    <title>Tiket Saya</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white font-sans p-6">

    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold">🎫 Tiket Saya</h1>
            <a href="/" class="text-gray-400 hover:text-white">← Kembali ke Home</a>
        </div>

        @if($tickets->isEmpty())
            <div class="bg-gray-800 p-10 rounded text-center">
                <p class="text-gray-400 mb-4">Kamu belum pernah membeli tiket nonton.</p>
                <a href="/" class="bg-blue-600 px-4 py-2 rounded hover:bg-blue-700">Cari Film Sekarang</a>
            </div>
        @else
            <div class="grid gap-6">
                @foreach($tickets as $ticket)
                <div class="bg-gray-800 border-l-4 border-yellow-500 p-6 rounded shadow-lg flex flex-col md:flex-row justify-between items-center">
                    
                    <div class="flex items-center gap-4">
                        <img src="{{ $ticket->schedule->film->poster_url }}" class="w-16 h-24 object-cover rounded shadow">
                        <div>
                            <h2 class="text-xl font-bold">{{ $ticket->schedule->film->title }}</h2>
                            <p class="text-gray-400 text-sm">
                                {{ \Carbon\Carbon::parse($ticket->schedule->start_time)->format('d M Y, H:i') }} WIB
                            </p>
                            <span class="inline-block mt-2 bg-green-900 text-green-300 text-xs px-2 py-1 rounded">
                                LUNAS ({{ $ticket->payment_status }})
                            </span>
                        </div>
                    </div>

                    <div class="mt-4 md:mt-0 text-center md:text-right">
                        <p class="text-sm text-gray-500">NOMOR KURSI</p>
                        <p class="text-4xl font-bold text-yellow-400">{{ $ticket->seat->seat_number }}</p>
                        <p class="text-xs text-gray-500 mt-1">Order ID: #{{ $ticket->id }}</p>
                    </div>

                </div>
                @endforeach
            </div>
        @endif
    </div>

</body>
</html>