<!DOCTYPE html>
<html lang="en">
    <head>
        @include('template.head')
        <link href="{{ asset('css/bootstrap-datepicker.min.css') }}" rel="stylesheet" />
        <title>Laporan - Sinar Laundry</title>
    </head>
    <body class="sb-nav-fixed">
        @include('template.topNav')
        <div id="layoutSidenav">
            @include('template.sideNav')
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4 ">
                        <h1 class="mt-4">Laporan Penjualan</h1>
                        <form method="POST" action="{{ url('owner/laporan/penjualan/tanggal') }}">
                            {{ csrf_field() }}
                            <label for="datepicker" class="fw-semibold form-label fs-5 mt-2 mb-0">Tanggal</label>
                            <div class="row g-3 align-items-center">
                                <div class="col-auto">
                                    <div class="input-daterange input-group" id="datepicker">
                                        <input type="text" class="input-sm form-control fs-5" name="awal" value="{{ $awal }}" />
                                        <span class="input-group-addon">s/d</span>
                                        <input type="text" class="input-sm form-control fs-5" name="akhir" value="{{ $akhir }}" />
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <div class="col-auto"><button type="submit" class="btn btn-secondary fw-semibold btn-block" role="button" data-toggle="tooltip" data-placement="top" title="Cek Tanggal">Cek</button></div>
                                </div> 
                                @if ($penjualan->count() != null)
                                    <div class="col-auto">
                                        @php
                                            $awal = Carbon\Carbon::createFromFormat('d/m/Y', $awal)->format('Y-m-d');
                                            $akhir = Carbon\Carbon::createFromFormat('d/m/Y', $akhir)->format('Y-m-d');
                                        @endphp
                                        <div class="col-auto"><a class="btn btn-success fw-semibold" href={{ url('owner/penjualan/export/'.$awal.'/'.$akhir) }} role="button" data-toggle="tooltip" data-placement="top" title="Unduh Excel">Unduh <i class="fa-solid fa-file-export"></i></a></div>
                                    </div>
                                @endif
                            </div>
                        </form>

                        <script src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
                        <script src="{{ asset('js/bootstrap-datepicker.id.min.js') }}"></script>
                        <script>
                            $('.input-daterange').datepicker({
                                clearBtn: true,
                                autoclose: true,
                                todayHighlight: true,
                                language: "id",
                                format: 'dd/mm/yyyy'
                            })
                        </script>
                        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
                        <div class="card mb-4 mt-3" style="height: 50rem;">                            
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                            </div>                            
                            <div class="card-body table-responsive ">
                                @include('laporan.tabel.tabelPenjualan', $penjualan)
                            </div>
                        </div>     
                    </div>
                </main>
                @include('sweetalert::alert')
            </div>
        </div>
        @include('template.foot')
    </body>
</html>
