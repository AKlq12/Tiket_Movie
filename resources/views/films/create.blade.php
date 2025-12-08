<!DOCTYPE html>
<html lang="id">
<head>
    <title>Tambah Film</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white p-10">
    <div class="max-w-xl mx-auto bg-gray-800 p-6 rounded-lg border border-gray-700">
        <h1 class="text-2xl font-bold mb-6">Tambah Film Baru</h1>

        <form action="{{ route('films.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block mb-1">Judul Film</label>
                <input type="text" name="title" class="w-full p-2 rounded bg-gray-700 border border-gray-600" required>
            </div>

            <div class="mb-4">
                <label class="block mb-1">Deskripsi</label>
                <textarea name="description" class="w-full p-2 rounded bg-gray-700 border border-gray-600"></textarea>
            </div>

            <div class="mb-4">
                <label class="block mb-1">Durasi (Menit)</label>
                <input type="number" name="duration_minutes" class="w-full p-2 rounded bg-gray-700 border border-gray-600" required>
            </div>

            <div class="mb-4">
                <label class="block mb-1">URL Poster (Link Gambar)</label>
                <input type="url" name="poster_url" placeholder="https://..." class="w-full p-2 rounded bg-gray-700 border border-gray-600" required>
            </div>

            <button type="submit" class="bg-green-600 w-full py-2 rounded font-bold hover:bg-green-700">Simpan Film</button>
        </form>
    </div>
</body>
</html>