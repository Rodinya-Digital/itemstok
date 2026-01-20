@extends('layouts.SolarTheme')

@section('title')
    Telefon Doğrulama
@endsection

@section('content')
    <div class="container mt-5">
        <h1 class="text-center">Sunucu ve Uygulama Durumu</h1>

        <!-- Uygulama Durumları -->
        <div id="pm2-status" class="mt-4">
            <h3>PM2 Uygulama Durumu</h3>
            <table class="table table-striped" id="status-table">
                <thead>
                <tr>
                    <th>Uygulama Adı</th>
                    <th>Durum</th>
                    <th>PID</th>
                </tr>
                </thead>
                <tbody>
                <!-- Veriler buraya yüklenecek -->
                </tbody>
            </table>
        </div>

        <!-- Sistem Durumu (CPU, RAM, Disk) -->
        <div id="system-status" class="mt-4">
            <h3>Sistem Durumu</h3>
            <div id="cpu-info"></div>
            <div id="memory-info"></div>
            <div id="disk-info"></div>
        </div>

        <!-- Loglar -->
        <div id="pm2-logs" class="mt-4">
            <h3>PM2 Loglar</h3>
            <pre id="logs-output" class="bg-light p-3"></pre>
        </div>

    </div>

@endsection
@section('scripts')
    <script>
        // Sunucu durumunu almak
        function fetchPM2Status() {
            $.get('https://stokla.net/FDHDGFSBSD345234adsASDFASDF324234/pm2-status', function(data) {
                let tableRows = '';
                data.processes.forEach(process => {
                    tableRows += `
                        <tr>
                            <td>${process.name}</td>
                            <td>${process.pm2_env.status}</td>
                            <td>${process.pid}</td>
                        </tr>
                    `;
                });
                $('#status-table tbody').html(tableRows);
            });
        }

        // PM2 loglarını almak
        function fetchPM2Logs() {
            $.get('https://stokla.net/FDHDGFSBSD345234adsASDFASDF324234/pm2-logs', function(data) {
                $('#logs-output').text(data.logs.join('\n'));
            });
        }

        // Sistem durumunu almak (CPU, RAM, Disk)
        function fetchSystemStatus() {
            $.get('https://stokla.net/FDHDGFSBSD345234adsASDFASDF324234/system-status', function(data) {
                $('#cpu-info').html(`
                    <strong>CPU Model:</strong> ${data.cpu.manufacturer} ${data.cpu.brand} <br>
                    <strong>CPU Core Sayısı:</strong> ${data.cpu.cores} <br>
                    <strong>CPU Hızı:</strong> ${data.cpu.speed} GHz
                `);
                $('#memory-info').html(`
                    <strong>Toplam RAM:</strong> ${data.memory.total / 1073741824} GB <br>
                    <strong>Serbest RAM:</strong> ${data.memory.free / 1073741824} GB
                `);
                let diskInfo = '<strong>Diskler:</strong><br>';
                data.disk.forEach(disk => {
                    diskInfo += `
                        <strong>Disk Adı:</strong> ${disk.device} <br>
                        <strong>Toplam Alan:</strong> ${(disk.size / 1073741824).toFixed(2)} GB <br>
                    `;
                });
                $('#disk-info').html(diskInfo);
            });
        }

        // Sayfa yüklendiğinde verileri al
        $(document).ready(function() {
            fetchPM2Status();
            fetchPM2Logs();
            fetchSystemStatus();
        });
    </script>
@endsection
