<!DOCTYPE html>
<html lang="id">
<head>
    <title>Manager Report & Monitoring</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white font-sans p-6">

    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-8 border-b border-gray-700 pb-4">
            <div>
                <h1 class="text-3xl font-bold text-blue-400">📊 Manager Area</h1>
                <p class="text-gray-400 text-sm">Laporan & Monitoring Realtime</p>
            </div>
            <div class="flex gap-3">
                <a href="/" class="bg-gray-700 px-4 py-2 rounded hover:bg-gray-600 font-bold">🏠 Home</a>
                <a href="{{ route('logout') }}" class="bg-red-600 px-4 py-2 rounded hover:bg-red-700 font-bold">🚪 Logout</a>
            </div>
        </div>

        <div class="mb-10">
            <h2 class="text-xl font-bold mb-4 flex items-center gap-2">
                📈 Live Monitoring (Grafana)
            </h2>
            <div class="bg-gray-800 p-2 rounded-lg shadow-lg border border-gray-700 h-[400px]">
                <iframe src="http://192.168.56.101:3000/d-solo/adnz8wg/new-dashboard?orgId=1&from=1765207404068&to=1765229004068&timezone=browser&theme=dark&panelId=panel-1&__feature.dashboardSceneSolo=true" 
                    width="100%" 
                    height="100%" 
                    frameborder="0">
                </iframe>
                
                <div class="text-center mt-2">
                    <a href="http://192.168.56.101:3000" target="_blank" class="text-blue-400 text-sm hover:underline">
                        Buka Full Dashboard Grafana ↗
                    </a>
                </div>
            </div>
        </div>

        <h2 class="text-xl font-bold mb-4 flex items-center gap-2">
            📄 Laporan Aktivitas
        </h2>
        
        <div class="bg-gray-800 rounded-lg overflow-hidden shadow-lg border border-gray-700">
            <div class="p-4 bg-gray-700 flex justify-between items-center">
                <h3 class="font-bold text-gray-200">Log Transaksi & Aktivitas User</h3>
                <a href="{{ route('manager.export') }}" class="bg-green-600 text-xs px-3 py-1 rounded hover:bg-green-500 font-bold">
                    Download Excel
                </a>
            </div>
            <table class="w-full text-left">
                <thead class="bg-gray-900 text-gray-400 uppercase text-xs">
                    <tr>
                        <th class="p-4">Waktu</th>
                        <th class="p-4">User</th>
                        <th class="p-4">Aksi</th>
                        <th class="p-4">Detail</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @foreach($logs as $log)
                    <tr class="hover:bg-gray-750 transition">
                        <td class="p-4 text-sm text-gray-400 font-mono">
                            {{ $log->created_at->format('d/m/Y H:i') }}
                        </td>
                        <td class="p-4 font-bold text-white">
                            {{ $log->user_name }}
                        </td>
                        <td class="p-4">
                            <span class="bg-blue-900 text-blue-200 px-2 py-1 rounded text-xs">
                                {{ $log->action }}
                            </span>
                        </td>
                        <td class="p-4 text-sm text-gray-300">
                            {{ $log->description }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</body>
</html>