<!DOCTYPE html>
<html lang="id">
<head>
    <title>Tambah Jadwal</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white p-10">
    <div class="max-w-xl mx-auto bg-gray-800 p-6 rounded-lg border border-gray-700">
        <h1 class="text-2xl font-bold mb-6">📅 Buat Jadwal Tayang</h1>

        <form action="{{ route('schedules.store') }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label class="block mb-1">Pilih Film</label>
                <select name="film_id" class="w-full p-2 rounded bg-gray-700 border border-gray-600">
                    @foreach($films as $film)
                        <option value="{{ $film->id }}" {{ request('film_id') == $film->id ? 'selected' : '' }}>
                            {{ $film->title }} ({{ $film->duration_minutes }} Menit)
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block mb-1">Waktu Tayang</label>
                <input type="datetime-local" name="start_time" class="w-full p-2 rounded bg-gray-700 border border-gray-600" required>
            </div>

            <div class="mb-4">
                <label class="block mb-1">Harga Tiket (Rp)</label>
                <input type="number" name="price" placeholder="50000" class="w-full p-2 rounded bg-gray-700 border border-gray-600" required>
            </div>

            <button type="submit" class="bg-blue-600 w-full py-2 rounded font-bold hover:bg-blue-700">Simpan Jadwal</button>
            <a href="{{ route('schedules.index') }}" class="block text-center mt-4 text-gray-400 hover:text-white">Batal</a>
        </form>
    </div>
</body>
</html>