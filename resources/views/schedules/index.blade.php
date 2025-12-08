<!DOCTYPE html>
<html lang="id">
<head>
    <title>Kelola Jadwal</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white p-10">
    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">📅 Jadwal Tayang Aktif</h1>
            <div class="space-x-2">
                <a href="{{ route('films.index') }}" class="bg-gray-600 px-4 py-2 rounded hover:bg-gray-700">Lihat Film</a>
                <a href="{{ route('schedules.create') }}" class="bg-blue-600 px-4 py-2 rounded hover:bg-blue-700">+ Buat Jadwal</a>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-600 p-3 rounded mb-4">{{ session('success') }}</div>
        @endif

        <div class="bg-gray-800 rounded-lg overflow-hidden border border-gray-700">
            <table class="w-full text-left">
                <thead class="bg-gray-700">
                    <tr>
                        <th class="p-4">Film</th>
                        <th class="p-4">Waktu Tayang</th>
                        <th class="p-4">Harga</th>
                        <th class="p-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($schedules as $schedule)
                    <tr class="border-b border-gray-700 hover:bg-gray-750">
                        <td class="p-4 font-bold">{{ $schedule->film->title }}</td>
                        <td class="p-4 text-yellow-400">
                            {{ \Carbon\Carbon::parse($schedule->start_time)->format('d M Y, H:i') }}
                        </td>
                        <td class="p-4">Rp {{ number_format($schedule->price) }}</td>
                        <td class="p-4">
                            <button class="text-red-400 hover:text-red-300">Hapus</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>