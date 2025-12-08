<!DOCTYPE html>
<html lang="id">
<head>
    <title>Bioskop Keycloak</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white font-sans">
    
    <nav class="bg-gray-800 p-4 border-b border-gray-700">
        <div class="container mx-auto flex justify-between items-center">
            <a href="/" class="text-2xl font-bold text-red-500">🍿 CINEMA XXI</a>
            <div>
                @auth
                    <span class="mr-4 text-gray-300 hidden md:inline">Halo, {{ Auth::user()->name }}</span>
                    
                    <a href="{{ route('tickets.index') }}" class="text-sm bg-yellow-600 px-3 py-1 rounded mr-2 hover:bg-yellow-500 font-bold text-black">
                        🎫 Tiket Saya
                    </a>

                    @if(Auth::user()->role === 'manager') 
                        <a href="{{ route('manager.dashboard') }}" class="text-sm bg-blue-700 px-3 py-1 rounded mr-2 hover:bg-blue-600">Manager Area</a>
                    @endif

                    @if(Auth::user()->role === 'admin' || Auth::user()->name === 'afif') 
                        <a href="{{ route('films.index') }}" class="text-sm bg-gray-700 px-3 py-1 rounded mr-2 hover:bg-gray-600">Admin Panel</a>
                    @endif
                    
                    <a href="{{ route('logout') }}" class="bg-red-600 px-4 py-2 rounded hover:bg-red-700 text-sm">Logout</a>
                @else
                    <a href="{{ route('login') }}" class="bg-blue-600 px-4 py-2 rounded hover:bg-blue-700">Login</a>
                @endauth
            </div>
        </div>
    </nav>

    <div class="container mx-auto p-8">
        <h1 class="text-4xl font-bold mb-8 text-center">Sedang Tayang Hari Ini</h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
            @foreach($films as $film)
            <div class="bg-gray-800 rounded-lg overflow-hidden shadow-lg hover:scale-105 transition-transform duration-300">
                <img src="{{ $film->poster_url }}" alt="{{ $film->title }}" class="w-full h-80 object-cover">
                <div class="p-4">
                    <h2 class="text-xl font-bold mb-2 truncate">{{ $film->title }}</h2>
                    <div class="flex justify-between items-center text-sm text-gray-400 mb-4">
                        <span>⏱ {{ $film->duration_minutes }} Menit</span>
                    </div>
                    <a href="{{ route('movie.show', $film->id) }}" class="block w-full text-center bg-yellow-500 text-black font-bold py-2 rounded hover:bg-yellow-400">
                        Lihat Jadwal
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>

</body>
</html>