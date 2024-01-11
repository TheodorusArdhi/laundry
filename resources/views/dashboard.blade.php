<!DOCTYPE html>
<html lang="en">
    <head>
        @include('template.head')
        <title>Dashboard - Sinar Laundry</title>
    </head>
    <body class="sb-nav-fixed">
        @include('template.topNav')
        <div id="layoutSidenav">
            @include('template.sideNav')
            
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Dashboard</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                        <div class="row">
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-primary text-white mb-4">
                                    <div class="card-body fw-medium fs-5">Transaksi</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <h4>{{ $transaksi }}</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-secondary text-white mb-4">
                                    <div class="card-body fw-medium fs-5">Proses</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <h4>{{ $proses }}</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-success text-white mb-4">
                                    <div class="card-body fw-medium fs-5">Sudah Diambil</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <h4>{{ $diambil }}</h4>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-danger text-white mb-4">
                                    <div class="card-body fw-medium fs-5">Tidak Diambil</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <h4>{{ $batasWaktu }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if(auth()->user()->level=="admin")
                        <div class="row">
                            <div class="col-xl-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-area me-1"></i>
                                        Pemasukan
                                    </div>
                                    <div class="card-body"><canvas id="pemasukan" width="100%" height="40"></canvas></div>
                                </div>
                            </div>
                            {{--  <div class="col-xl-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-bar me-1"></i>
                                        Bar Chart Example
                                    </div>
                                    <div class="card-body"><canvas id="myBarChart" width="100%" height="40"></canvas></div>
                                </div>
                            </div>  --}}
                        </div>
                        @endif
                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2023</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        @include('template.foot')
        <script>
            const pen = document.getElementById('pemasukan');
            new Chart(pen, {
                type: 'line',
                data: {
                    labels: {!! json_encode($bulans) !!},
                    datasets: [{
                    label: "Pemasukan",
                    lineTension: 0.3,
                    backgroundColor: "rgba(2,117,216,0.2)",
                    borderColor: "rgba(2,117,216,1)",
                    pointRadius: 5,
                    pointBackgroundColor: "rgba(2,117,216,1)",
                    pointBorderColor: "rgba(255,255,255,0.8)",
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: "rgba(2,117,216,1)",
                    pointHitRadius: 50,
                    pointBorderWidth: 2,
                    data: {!! json_encode($bulanTotal) !!},
                    }],
                },
                options: {
                    scales: {
                    xAxes: [{
                        time: {
                        unit: 'date'
                        },
                        gridLines: {
                        display: false
                        },
                        ticks: {
                        maxTicksLimit: 7
                        }
                    }],
                    yAxes: [{
                        ticks: {
                        min: 0,
                        max: round(max($bulanTotal), -5)+100000,
                        maxTicksLimit: 5
                        },
                        gridLines: {
                        color: "rgba(0, 0, 0, .125)",
                        }
                    }],
                    },
                    legend: {
                    display: false
                    }
                }
            });
        </script>
    </body>
</html>
