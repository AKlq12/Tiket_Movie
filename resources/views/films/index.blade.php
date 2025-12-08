<!DOCTYPE html>
<html lang="id">
<head>
    <title>Daftar Film</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white p-10 font-sans">
    <div class="max-w-6xl mx-auto">
        <div class="flex justify-between items-center mb-8 border-b border-gray-700 pb-4">
            <h1 class="text-3xl font-bold">🎬 Daftar Film Bioskop</h1>
            <div class="flex gap-3">
                <a href="/" class="bg-gray-700 px-4 py-2 rounded hover:bg-gray-600 font-bold transition">
                    🏠 Home
                </a>
                
                <a href="{{ route('films.create') }}" class="bg-blue-600 px-4 py-2 rounded hover:bg-blue-700 font-bold transition">
                    + Tambah Film
                </a>
                
                <a href="{{ route('logout') }}" class="bg-red-600 px-4 py-2 rounded hover:bg-red-700 font-bold transition">
                    🚪 Logout
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-600 text-white p-4 rounded mb-6 shadow-lg">
                ✅ {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($films as $film)
    <div class="bg-gray-800 rounded-lg overflow-hidden shadow-lg border border-gray-700 hover:scale-105 transition-transform duration-300">
        <img src="{{ $film->poster_url }}" alt="{{ $film->title }}" class="w-full h-64 object-cover">
        <div class="p-4">
            <h2 class="text-xl font-bold mb-2 truncate">{{ $film->title }}</h2>
            
            <div class="flex justify-between items-center mb-4">
                <span class="bg-yellow-600 text-black text-xs font-bold px-2 py-1 rounded">
                    {{ $film->duration_minutes }} Menit
                </span>
                <span class="text-gray-500 text-xs">ID: {{ $film->id }}</span>
            </div>

            <div class="grid grid-cols-1 gap-2">
                <a href="{{ route('schedules.create') }}?film_id={{ $film->id }}" class="bg-green-600 text-center text-sm py-2 rounded hover:bg-green-700 font-bold transition">
                    📅 Atur Jadwal Tayang
                </a>
                <a href="{{ route('movie.show', $film->id) }}" target="_blank" class="bg-gray-700 text-center text-sm py-2 rounded hover:bg-gray-600 font-bold transition">
                    👁️ Lihat di Web
                </a>
            </div>
        </div>
    </div>
@endforeach
        </div>
        
        @if($films->isEmpty())
            <div class="text-center text-gray-500 mt-10">
                <p>Belum ada film yang ditambahkan.</p>
            </div>
        @endif
    </div>
</body>
</html>