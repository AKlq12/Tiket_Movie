<!DOCTYPE html>
<html lang="id">
<head>
    <title>Pilih Kursi - {{ $schedule->film->title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white min-h-screen flex items-center justify-center p-4">

    <div class="max-w-4xl w-full bg-gray-800 rounded-lg shadow-2xl p-8 flex flex-col md:flex-row gap-8">
        
        <div class="w-full md:w-1/3 border-r border-gray-700 pr-8">
            <img src="{{ $schedule->film->poster_url }}" class="w-full rounded mb-4 shadow-lg">
            <h1 class="text-2xl font-bold mb-2">{{ $schedule->film->title }}</h1>
            <p class="text-gray-400 mb-4">
                {{ \Carbon\Carbon::parse($schedule->start_time)->format('d M Y, H:i') }} WIB
            </p>
            <p class="text-xl font-bold text-yellow-400">Rp {{ number_format($schedule->price) }}</p>
            <a href="/" class="block mt-8 text-sm text-gray-500 hover:text-white">← Batal & Kembali</a>
        </div>

        <div class="w-full md:w-2/3">
            <h2 class="text-xl font-bold mb-6 text-center">LAYAR BIOSKOP</h2>
            <div class="w-full h-2 bg-gray-600 mb-12 shadow-[0_10px_20px_rgba(255,255,255,0.1)] rounded"></div>

            @if(session('error'))
                <div class="bg-red-600 text-white p-3 rounded mb-4 text-center animate-bounce">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('booking.store', $schedule->id) }}" method="POST">
    @csrf
    <div class="grid grid-cols-5 gap-4 justify-center max-w-sm mx-auto">
        @foreach($schedule->seats as $seat)
            @php
                $isBooked = $seat->status === 'booked';
                // Ubah style jika booked, checkbox, atau tersedia
                $color = $isBooked 
                    ? 'bg-red-900 cursor-not-allowed text-gray-500' 
                    : 'bg-gray-700 hover:bg-green-600 cursor-pointer peer-checked:bg-green-500 peer-checked:ring-2 peer-checked:ring-white';
            @endphp

            <label class="relative">
                <input type="checkbox" name="seats[]" value="{{ $seat->seat_number }}" class="peer sr-only" {{ $isBooked ? 'disabled' : '' }}>
                
                <div class="w-12 h-12 flex items-center justify-center rounded {{ $color }} transition-colors font-bold text-sm">
                    {{ $seat->seat_number }}
                </div>
            </label>
        @endforeach
    </div>

    <div class="mt-10 text-center">
        <p class="text-sm text-gray-400 mb-2">Kamu bisa memilih lebih dari 1 kursi</p>
        <button type="submit" class="bg-yellow-500 text-black font-bold px-8 py-3 rounded-full hover:bg-yellow-400 transform hover:scale-105 transition-all">
            BAYAR & BOOKING SEKARANG
        </button>
    </div>
</form>

            <div class="flex justify-center gap-6 mt-8 text-sm text-gray-400">
                <div class="flex items-center gap-2"><div class="w-4 h-4 bg-gray-700 rounded"></div> Tersedia</div>
                <div class="flex items-center gap-2"><div class="w-4 h-4 bg-red-900 rounded"></div> Terisi</div>
                <div class="flex items-center gap-2"><div class="w-4 h-4 bg-green-600 rounded"></div> Pilihanmu</div>
            </div>
        </div>
    </div>

</body>
</html>