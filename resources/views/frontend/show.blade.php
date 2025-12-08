<!DOCTYPE html>
<html lang="id">
<head>
    <title>{{ $film->title }} - Jadwal</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white">

    <div class="container mx-auto p-8">
        <a href="/" class="text-gray-400 hover:text-white mb-6 block">← Kembali ke Halaman Utama</a>

        <div class="flex flex-col md:flex-row gap-8 bg-gray-800 p-6 rounded-lg shadow-xl">
            <div class="w-full md:w-1/3">
                <img src="{{ $film->poster_url }}" class="w-full rounded-lg shadow-lg">
            </div>

            <div class="w-full md:w-2/3">
                <h1 class="text-4xl font-bold mb-4">{{ $film->title }}</h1>
                <p class="text-gray-300 mb-6 leading-relaxed">{{ $film->description }}</p>
                <div class="mb-8">
                    <span class="bg-gray-700 px-3 py-1 rounded text-sm">Durasi: {{ $film->duration_minutes }} Menit</span>
                </div>

                <h2 class="text-2xl font-bold mb-4 border-b border-gray-600 pb-2">Pilih Jadwal Tayang</h2>
                
                @if($film->schedules->isEmpty())
                    <p class="text-red-400">Belum ada jadwal tayang untuk film ini.</p>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach($film->schedules as $schedule)
                        <div class="bg-gray-700 p-4 rounded-lg flex justify-between items-center">
                            <div>
                                <p class="text-lg font-bold text-yellow-400">
                                    {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} WIB
                                </p>
                                <p class="text-xs text-gray-400">
                                    {{ \Carbon\Carbon::parse($schedule->start_time)->format('d M Y') }}
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="font-bold">Rp {{ number_format($schedule->price) }}</p>
                                <a href="{{ route('booking.create', $schedule->id) }}" class="mt-2 inline-block bg-green-600 text-xs px-4 py-2 rounded hover:bg-green-700 text-white">
                                    Pilih Kursi
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

</body>
</html>