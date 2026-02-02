@extends('layouts.app', ['title' => 'Dashboard'])

@section('content')
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />

<style>
    :root {
        --deep-blue: #004a69;
        --soft-blue: rgba(0, 74, 105, 0.1);
    }

    .welcome-card {
        background: linear-gradient(135deg, #004a69 0%, #006087 100%);
        border-radius: 15px;
        position: relative;
        overflow: hidden;
    }
    .welcome-card::after {
        content: '';
        position: absolute;
        right: -50px; top: -50px;
        width: 200px; height: 200px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 50%;
    }

    .pulse-urgent { animation: pulse-deep-blue 2s infinite; }
    @keyframes pulse-deep-blue {
        0% { box-shadow: 0 0 0 0 rgba(0, 74, 105, 0.4); }
        70% { box-shadow: 0 0 0 10px rgba(0, 74, 105, 0); }
        100% { box-shadow: 0 0 0 0 rgba(0, 74, 105, 0); }
    }

    .table-hover-custom tbody tr { transition: all 0.2s; border-left: 3px solid transparent; }
    .table-hover-custom tbody tr:hover {
        background-color: #f0f7fa;
        transform: scale(1.01);
        border-left: 3px solid var(--deep-blue);
    }
    .card { border-radius: 12px; }
    .stat-icon {
        width: 48px; height: 48px;
        background: var(--soft-blue);
        color: var(--deep-blue);
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
    }

    /* Custom Styling for FullCalendar */
    #calendar {
        max-height: 500px;
        font-size: 0.85rem;
    }
    .fc-header-toolbar { margin-bottom: 1rem !important; }
    .fc-button-primary { background-color: var(--deep-blue) !important; border-color: var(--deep-blue) !important; }
    .fc-day-today { background: var(--soft-blue) !important; }
</style>

<div class="container-fluid py-3">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card welcome-card shadow-sm border-0 text-white">
                <div class="card-body p-4 d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h4 fw-bold mb-1 text-white">Selamat Datang Kembali, {{ $namaLengkap }}!</h1>
                        <p class="mb-0 opacity-75">
                            Dashboard manajemen lembur — Role: <strong>{{ ucfirst(Auth::user()->role) }}</strong>
                            @if(Auth::user()->tim)
                            | Tim: <strong>{{ Auth::user()->tim->nama_tim }}</strong>
                            @else
                            | <strong>Pimpinan / Umum</strong>
                            @endif
                        </p>
                    </div>
                    <div class="d-none d-md-block">
                        <i class="fas fa-chart-line fa-3x opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-3">
            <div class="card shadow-sm mb-4 border-0">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon me-3">
                            <i class="fas fa-users fa-lg"></i>
                        </div>
                        <div>
                            <div class="text-muted small text-uppercase fw-bold">Total Pegawai</div>
                            <div class="h3 fw-bold mb-0" style="color: var(--deep-blue);">{{ $totalPegawai }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm mb-4 border-0">
                <div class="card-body">
                    <label class="small fw-bold text-muted text-uppercase mb-2 d-block">Periode Laporan</label>
                    <form action="{{ route('dashboard') }}" method="GET">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="fas fa-calendar-alt" style="color: var(--deep-blue);"></i></span>
                            <select name="tahun" class="form-select border-0 bg-light fw-bold" onchange="this.form.submit()" style="color: var(--deep-blue);">
                                @for($y = date('Y') + 1; $y >= 2024; $y--)
                                    <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>Tahun {{ $y }}</option>
                                @endfor
                            </select>
                        </div>
                    </form>
                </div>
            </div>

            @if(Auth::user()->role == 'admin')
            <div class="card shadow-sm mb-4 border-0 bg-light">
                <div class="card-body">
                    <h6 class="small fw-bold text-muted text-uppercase mb-3"><i class="fas fa-umbrella-beach me-2"></i>Libur Terdekat</h6>
                    @php
                        $libur = \App\Models\HariLibur::where('tanggal', '>=', now())->orderBy('tanggal', 'asc')->first();
                    @endphp
                    @if($libur)
                        <div class="fw-bold text-danger mb-1 small">{{ \Carbon\Carbon::parse($libur->tanggal)->translatedFormat('d F Y') }}</div>
                        <div class="small text-muted">{{ $libur->keterangan }}</div>
                    @else
                        <div class="small text-muted italic">Tidak ada data libur terdekat.</div>
                    @endif
                </div>
            </div>
            @endif
        </div>

        <div class="col-lg-9">
            @if(Auth::user()->role == 'kabag')
                <div class="card shadow-sm border-0 mb-4 h-100">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-0">
                        <h6 class="m-0 fw-bold" style="color: var(--deep-blue);"><i class="fas fa-tasks me-2"></i>Antrean Persetujuan Lembur</h6>
                        @if($pengajuanPending > 0)
                            <span class="badge pulse-urgent px-3 py-2" style="background-color: var(--deep-blue); color: white;">{{ $pengajuanPending }} Menunggu</span>
                        @endif
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover-custom align-middle mb-0">
                                <thead class="bg-light">
                                    <tr class="small text-muted text-uppercase">
                                        <th class="ps-4">PEGAWAI</th>
                                        <th>WAKTU ANTREAN</th>
                                        <th class="text-end pe-4">AKSI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($terbaru as $t)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="fw-bold text-dark">{{ $t->pegawai->nama_lengkap }}</div>
                                            <div class="text-muted small">Lembur: {{ \Carbon\Carbon::parse($t->tanggal)->locale('id')->translatedFormat('d F Y') }}</div>
                                        </td>
                                        <td>
                                            <span class="fw-medium small" style="color: var(--deep-blue);">
                                                <i class="far fa-clock me-1"></i> {{ $t->created_at->diffForHumans() }}
                                            </span>
                                        </td>
                                        <td class="text-end pe-4">
                                            <a href="{{ route('verifikasi.index') }}" class="btn btn-sm px-4 fw-bold text-white shadow-sm" style="background-color: var(--deep-blue); border-radius: 8px;">Verifikasi</a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr><td colspan="3" class="text-center py-5 text-muted small">Tidak ada antrean pengajuan.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            @elseif(Auth::user()->role == 'operator')
                <div class="card shadow-sm h-100 border-0">
                    <div class="card-header bg-white py-3 border-0">
                        <h6 class="m-0 fw-bold" style="color: var(--deep-blue);"><i class="fas fa-briefcase me-2"></i>Status Pengajuan Tim</h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-4"><div class="p-3 bg-warning bg-opacity-10 border-start border-4 border-warning rounded shadow-sm"><h6 class="mb-1 fw-bold text-warning">Pending</h6><h2 class="mb-0 fw-bold">{{ $statsTim['pending'] }}</h2></div></div>
                            <div class="col-md-4"><div class="p-3 bg-success bg-opacity-10 border-start border-4 border-success rounded shadow-sm"><h6 class="mb-1 fw-bold text-success">Disetujui</h6><h2 class="mb-0 fw-bold">{{ $statsTim['disetujui'] }}</h2></div></div>
                            <div class="col-md-4"><div class="p-3 bg-danger bg-opacity-10 border-start border-4 border-danger rounded shadow-sm"><h6 class="mb-1 fw-bold text-danger">Ditolak</h6><h2 class="mb-0 fw-bold">{{ $statsTim['ditolak'] }}</h2></div></div>
                        </div>
                    </div>
                </div>

            @elseif(Auth::user()->role == 'admin')
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-white py-3 border-0">
                        <h6 class="m-0 fw-bold" style="color: var(--deep-blue);"><i class="fas fa-calendar-alt me-2"></i>Monitoring Kalender Lembur</h6>
                    </div>
                    <div class="card-body">
                        <div id='calendar'></div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-lg-5 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white py-3 border-0"><h6 class="m-0 fw-bold text-dark"><i class="fas fa-chart-pie me-2" style="color: var(--deep-blue);"></i>{{ $judulChart2 }}</h6></div>
                <div class="card-body"><div style="height: 300px;"><canvas id="pieChart"></canvas></div></div>
            </div>
        </div>
        <div class="col-lg-7 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white py-3 border-0"><h6 class="m-0 fw-bold text-dark"><i class="fas fa-chart-bar me-2" style="color: var(--deep-blue);"></i>{{ $chart1Title }} ({{ $year }})</h6></div>
                <div class="card-body"><div style="height: 300px;"><canvas id="barChart"></canvas></div></div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>

<script>
    // FullCalendar Configuration (Hanya untuk Admin)
    @if(Auth::user()->role == 'admin')
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'id',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,dayGridWeek'
            },
            // Logic: Ambil data dari backend atau definisikan static events
            events: [
                // Contoh integrasi data libur
                @php $holidayData = \App\Models\HariLibur::all(); @endphp
                @foreach($holidayData as $h)
                {
                    title: '{{ $h->keterangan }}',
                    start: '{{ $h->tanggal }}',
                    display: 'background',
                    backgroundColor: '#ffdbdb'
                },
                @endforeach
                // Contoh integrasi titik lembur (agregat harian)
                @php
                    $lemburDaily = \App\Models\PengajuanLembur::where('status', 'disetujui')
                                    ->select('tanggal', \DB::raw('count(*) as total'))
                                    ->groupBy('tanggal')->get();
                @endphp
                @foreach($lemburDaily as $ld)
                {
                    title: '{{ $ld->total }} Orang Lembur',
                    start: '{{ $ld->tanggal }}',
                    color: '#004a69'
                },
                @endforeach
            ]
        });
        calendar.render();
    });
    @endif

    // Charts Config (Shared)
    Chart.defaults.maintainAspectRatio = false;
    Chart.defaults.color = '#64748b';
    Chart.defaults.font.family = 'Plus Jakarta Sans, sans-serif';

    new Chart(document.getElementById('barChart'), {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
            datasets: [{
                label: 'Total Orang', data: @json($dataBar),
                backgroundColor: '#004a69', borderRadius: 8, hoverBackgroundColor: '#006087'
            }]
        },
        options: { scales: { y: { grid: { display: false }, beginAtZero: true, ticks: { stepSize: 1 } }, x: { grid: { display: false } } }, plugins: { legend: { display: false } } }
    });

    new Chart(document.getElementById('pieChart'), {
        type: 'doughnut',
        data: {
            labels: @json($labelPie),
            datasets: [{
                data: @json($dataPie),
                backgroundColor: ['#004a69', '#0ea5e9', '#0284c7', '#38bdf8', '#7dd3fc', '#bae6fd'],
                borderWidth: 2, borderColor: '#ffffff'
            }]
        },
        options: { plugins: { legend: { position: 'bottom', labels: { usePointStyle: true, padding: 25, font: { size: 11 } } } }, cutout: '75%' }
    });
</script>
@endpush
@endsection
