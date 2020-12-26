@extends('admin/core/main')
@extends('admin/core/navbar')
@extends('admin/core/footer')

@section('title', 'Dashboard - Admin Panel Pengajuan Webinar')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'A good dashboard to display your statistics')


@section('konten')
<div class="row mb-2">
    <div class="col-12 col-md-3">
        <div class="card card-statistic">
            <div class="card-body p-0">
                <div class="d-flex flex-column">
                    <div class='px-4 py-4 d-flex justify-content-between'>
                        <h3 class='card-title'>TOTAL</h3>
                        <div class="card-right d-flex align-items-center">
                        <p>{{ $total }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-3">
        <div class="card card-statistic">
            <div class="card-body p-0">
                <div class="d-flex flex-column">
                    <div class='px-4 py-4 d-flex justify-content-between'>
                        <h3 class='card-title'>Dikonfirmasi</h3>
                        <div class="card-right d-flex align-items-center">
                            <p>{{ $dikonfirmasi }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-3">
        <div class="card card-statistic">
            <div class="card-body p-0">
                <div class="d-flex flex-column">
                    <div class='px-4 py-4 d-flex justify-content-between'>
                        <h3 class='card-title'>Menunggu</h3>
                        <div class="card-right d-flex align-items-center">
                            <p>{{ $menunggu }} </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-3">
        <div class="card card-statistic">
            <div class="card-body p-0">
                <div class="d-flex flex-column">
                    <div class='px-4 py-4 d-flex justify-content-between'>
                        <h3 class='card-title'>Ditolak</h3>
                        <div class="card-right d-flex align-items-center">
                            <p>{{ $ditolak }} </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class='card-heading p-1 pl-3'>Perkembangan webinar</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 col-12">
                        <div class="pl-3">
                            <h1 class='mt-5'>{{ $bulan_ini }}</h1>
                            <p class='text-xs'>
                                @if ($persen >= 0)
                                    <span class="text-green"><i data-feather="bar-chart" width="15">
                                @else     
                                    <span class="text-red"><i data-feather="bar-chart-2" width="15">
                                @endif
                                </i> {{ $persen }}%</span> than last month</p>
                            <div class="legends">
                                <div class="legend d-flex flex-row align-items-center">
                                    <div class='w-3 h-3 rounded-full bg-info mr-2'></div><span class='text-xs'>Last Month</span>
                                </div>
                                <div class="legend d-flex flex-row align-items-center">
                                    <div class='w-3 h-3 rounded-full bg-blue mr-2'></div><span class='text-xs'>Current Month</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 col-12">
                        <canvas id="bar"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">List penjadwalan bulan ini</h4>
                <div class="d-flex ">
                </div>
            </div>
            <div class="card-body px-0 pb-0">
                <div class="table-responsive">
                    <table class='table mb-0' id="table1">
                        <thead>
                            <tr>
                                <th scope="col">Unit Kerja</th>
                                <th scope="col">keperluan</th>
                                <th scope="col">Tanggal</th>
                                <th scope="col">Pukul</th>
                                <th scope="col">Surat</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pendaftar as $user)
                            <tr>
                                <td>{{ $user->nama_pengaju }}</td>
                                <td>{{ $user->keperluan }}</td>
                                <td>{{ $user->tanggal }}</td>
                            <?php
                                list($masuk_hours, $masuk_minutes, $a) = explode(':', $user->jam_masuk);
                                list($keluar_hours, $keluar_minutes, $b) = explode(':', $user->jam_keluar);
                            ?>
                                <td>{{ $masuk_hours.':'.$masuk_minutes }} - {{ $keluar_hours.':'.$keluar_minutes }}</td>
                                <td>
                                    @if ($user->file_rekap != null)
                                        <a href="{{ url('file_rekap/'.$user->file_rekap) }}" download>
                                            <i data-feather="file"></i>
                                        </a>
                                    @else
                                        <i data-feather="file"></i>
                                    @endif
                                </td>
                                <td>
                                    @if ($user->konfirmasi == 1)
                                        <span class="badge bg-success">dikonfirmasi</span>
                                    @elseif ($user->konfirmasi == 0)
                                        <span class="badge bg-warning">menunggu</span>
                                    @else
                                        <span class="badge bg-danger">ditolak</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js_asset')
    {{-- <script src="{{ asset('/assets/admin/js/pages/dashboard.js') }}"></script> --}}
    <script>

        var chartColors = {
        red: 'rgb(255, 99, 132)',
        orange: 'rgb(255, 159, 64)',
        yellow: 'rgb(255, 205, 86)',
        green: 'rgb(75, 192, 192)',
        info: '#41B1F9',
        blue: '#3245D1',
        purple: 'rgb(153, 102, 255)',
        grey: '#EBEFF6'
        };

        var ctxBar = document.getElementById("bar").getContext("2d");
        var myBar = new Chart(ctxBar, {
        type: 'bar',
        data: {
            labels: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", 'Ags', 'Sep', 'Okt', 'Nov', 'Des'],
            datasets: [{
                label: 'Students',
                backgroundColor: {{ $color_bulan }},
                data: {{ $bulan }}
            }]
        },
        options: {
            responsive: true,
            barRoundness: 1,
            title: {
            display: false,
            text: "Chart.js - Bar Chart with Rounded Tops (drawRoundedTopRectangle Method)"
            },
            legend: {
            display:false
            },
            scales: {
            yAxes: [{
                ticks: {
                beginAtZero: true,
                //suggestedMax: 40 + 20,
                padding: 10,
                },
                gridLines: {
                drawBorder: false,
                }
            }],
            xAxes: [{
                    gridLines: {
                        display:false,
                        drawBorder: false
                    }
                }]
            }
        }
        });
        
        var radialBars = new ApexCharts(document.querySelector("#radialBars"), radialBarsOptions);
        radialBars.render();

    </script>
@endsection

@section('js_script')
<script></script>
@endsection 