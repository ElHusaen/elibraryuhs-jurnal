@extends('layouts.app-simple')

@section('title', 'Dashboard')

@section('content')

{{-- Header --}}
<div class="row mb-4">
    <div class="col-md-12">
        <p class="text-muted">Ringkasan data jurnal di E-Library</p>
    </div>
</div>

{{-- Card Total --}}
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card-custom" style="background: linear-gradient(135deg, #1a3c6e, #2a5298); color: #fff;">
            <div class="card-body">
                <h5 class="card-title" style="color: rgba(255,255,255,0.8);">Total Jurnal</h5>
                <h2 class="mb-0">{{ $totalJurnal ?? 0 }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card-custom" style="background: linear-gradient(135deg, #28a745, #20c997); color: #fff;">
            <div class="card-body">
                <h5 class="card-title" style="color: rgba(255,255,255,0.8);">Total Penulis</h5>
                <h2 class="mb-0">{{ $totalMahasiswa ?? 0 }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card-custom" style="background: linear-gradient(135deg, #17a2b8, #0dcaf0); color: #fff;">
            <div class="card-body">
                <h5 class="card-title" style="color: rgba(255,255,255,0.8);">Total User</h5>
                <h2 class="mb-0">{{ $totalUser ?? 0 }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card-custom" style="background: linear-gradient(135deg, #ffc107, #fd7e14); color: #fff;">
            <div class="card-body">
                <h5 class="card-title" style="color: rgba(255,255,255,0.8);">Total Kategori</h5>
                <h2 class="mb-0">{{ $totalKategori ?? 0 }}</h2>
            </div>
        </div>
    </div>
</div>

{{-- Grafik 1: Statistik per Prodi --}}
<div class="row mb-4">
    <div class="col-md-6">
        <div class="card-custom">
            <div class="card-header-custom">
                <i class="fa fa-bar-chart"></i> Jumlah Jurnal per Program Studi
            </div>
            <div class="card-body">
                <canvas id="chartProdi" height="250"></canvas>
            </div>
        </div>
    </div>

    {{-- Grafik 2: Statistik per Kategori --}}
    <div class="col-md-6">
        <div class="card-custom">
            <div class="card-header-custom">
                <i class="fa fa-pie-chart"></i> Jumlah Jurnal per Kategori
            </div>
            <div class="card-body">
                <canvas id="chartKategori" height="250"></canvas>
            </div>
        </div>
    </div>
</div>

{{-- Grafik 3: Statistik per Tahun --}}
<div class="row mb-4">
    <div class="col-md-6">
        <div class="card-custom">
            <div class="card-header-custom">
                <i class="fa fa-line-chart"></i> Jumlah Jurnal per Tahun
            </div>
            <div class="card-body">
                <canvas id="chartTahun" height="250"></canvas>
            </div>
        </div>
    </div>

    {{-- Grafik 4: Statistik per Status --}}
    <div class="col-md-6">
        <div class="card-custom">
            <div class="card-header-custom">
                <i class="fa fa-donut-chart"></i> Jumlah Jurnal per Status
            </div>
            <div class="card-body">
                <canvas id="chartStatus" height="250"></canvas>
            </div>
        </div>
    </div>
</div>

{{-- 5 Jurnal Terbaru --}}
<div class="row">
    <div class="col-md-12">
        <div class="card-custom">
            <div class="card-header-custom">
                <i class="fa fa-clock-o"></i> 5 Jurnal Terbaru
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table-custom">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul</th>
                                <th>Penulis</th>
                                <th>Kategori</th>
                                <th>Tanggal Upload</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($jurnalTerbaru ?? [] as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->judul }}</td>
                                    <td>{{ $item->mahasiswa->nama_lengkap ?? '-' }}</td>
                                    <td>{{ $item->kategori->nama_kategori ?? '-' }}</td>
                                    <td>{{ $item->tgl_upload ? \Carbon\Carbon::parse($item->tgl_upload)->format('d-m-Y') : '-' }}</td>
                                    <td>
                                        <span class="badge-custom 
                                            @if($item->status == 'publish') badge-success-custom
                                            @elseif($item->status == 'review') badge-warning-custom
                                            @else badge-danger-custom @endif">
                                            {{ $item->status }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" style="text-align:center; padding:30px; color:#999;">
                                        <i class="fa fa-inbox" style="font-size:24px;display:block;margin-bottom:8px;"></i>
                                        Belum ada jurnal
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {

        // 1. Chart Prodi (Bar Chart)
        var ctx1 = document.getElementById('chartProdi').getContext('2d');
        new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: {!! json_encode($labelsProdi ?? []) !!},
                datasets: [{
                    label: 'Jumlah Jurnal',
                    data: {!! json_encode($dataProdi ?? []) !!},
                    backgroundColor: [
                        'rgba(26, 60, 110, 0.7)',
                        'rgba(40, 167, 69, 0.7)',
                        'rgba(255, 193, 7, 0.7)',
                        'rgba(23, 162, 184, 0.7)',
                        'rgba(153, 102, 255, 0.7)',
                        'rgba(255, 159, 64, 0.7)',
                        'rgba(199, 199, 199, 0.7)'
                    ],
                    borderColor: [
                        'rgba(26, 60, 110, 1)',
                        'rgba(40, 167, 69, 1)',
                        'rgba(255, 193, 7, 1)',
                        'rgba(23, 162, 184, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(199, 199, 199, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });

        // 2. Chart Kategori (Pie Chart)
        var ctx2 = document.getElementById('chartKategori').getContext('2d');
        new Chart(ctx2, {
            type: 'pie',
            data: {
                labels: {!! json_encode($labelsKategori ?? []) !!},
                datasets: [{
                    data: {!! json_encode($dataKategori ?? []) !!},
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.7)',
                        'rgba(26, 60, 110, 0.7)',
                        'rgba(255, 206, 86, 0.7)',
                        'rgba(75, 192, 192, 0.7)',
                        'rgba(153, 102, 255, 0.7)',
                        'rgba(255, 159, 64, 0.7)'
                    ],
                    borderColor: '#fff',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

        // 3. Chart Tahun (Line Chart)
        var ctx3 = document.getElementById('chartTahun').getContext('2d');
        new Chart(ctx3, {
            type: 'line',
            data: {
                labels: {!! json_encode($labelsTahun ?? []) !!},
                datasets: [{
                    label: 'Jumlah Jurnal',
                    data: {!! json_encode($dataTahun ?? []) !!},
                    backgroundColor: 'rgba(26, 60, 110, 0.1)',
                    borderColor: 'rgba(26, 60, 110, 1)',
                    borderWidth: 2,
                    pointBackgroundColor: 'rgba(26, 60, 110, 1)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });

        // 4. Chart Status (Doughnut Chart)
        var ctx4 = document.getElementById('chartStatus').getContext('2d');
        new Chart(ctx4, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($labelsStatus ?? []) !!},
                datasets: [{
                    data: {!! json_encode($dataStatus ?? []) !!},
                    backgroundColor: [
                        'rgba(255, 193, 7, 0.7)',  // review
                        'rgba(40, 167, 69, 0.7)',  // publish
                        'rgba(220, 53, 69, 0.7)'   // ditolak
                    ],
                    borderColor: '#fff',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

    });
</script>
@endpush