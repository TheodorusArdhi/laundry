<!DOCTYPE html>
<html lang="en">
    <head>
        @include('template.head')
        <title>Transaksi - Sinar Laundry</title>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

    </head>
    <body class="sb-nav-fixed">
        @include('template.topNav')
        <div id="layoutSidenav">
            @include('template.sideNav')
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Transaksi</h1>
                        <ol class="breadcrumb mb-2">
                            <li class="breadcrumb-item active">Lihat Transaksi</li>
                        </ol>
                        @include('template.validate')
                        <div class="card shadow-lg border-0 rounded-lg mb-4">
                            <label for="namaAdmin" class="fw-semibold form-label mx-3 mt-2 mb-0">Admin</label>
                            <div class="row mx-3 g-3 align-items-center">
                                <div class="col-3">
                                    <input type="text" id="namaAdmin" disabled class="form-control " name="namaAdmin"  value="{{ $transaksi->admin->nama }}"/>
                                </div>
                            </div>

                            <label for="no_transaksi" class="fw-semibold form-label mx-3 mt-2 mb-0">Nomor Transaksi</label>
                            <div class="row mx-3 g-3 align-items-center">
                                <div class="col-3">
                                    <input type="text" id="no_transaksi"  class="form-control " name="no_transaksi"  value="{{ $transaksi->no_transaksi }}" disabled/>
                                </div>
                            </div>

                            <label for="tanggal" class="fw-semibold form-label mx-3 mt-2 mb-0">Tanggal</label>
                            <div class="row mx-3 g-3 align-items-center">
                                <div class="col-3">
                                    <input type="text" id="tanggal" disabled class="form-control " name="tanggal"  value="{{ $transaksi->tgl_masuk }}"/>
                                </div>
                            </div>

                            @include('sweetalert::alert')

                            <div class="card mb-4 mt-2 mx-3">                            
                                <div class="card-header">
                                    <i class="fas fa-table me-1"></i>
                                    <a> <b class="fw-semibold"></b></a>
                                </div>                            
                                <div class="card-body">
                                    <table id="datatablesSimple">
                                        <thead >
                                            <tr>
                                                <th>No</th>
                                                <th>Layanan</th>
                                                <th>Harga</th>
                                                <th>Jumlah</th>
                                                <th>Sub Total</th>
                                            </tr>
                                        </thead>
                                        <tfoot >
                                            <tr>
                                                <th>No</th>
                                                <th>Layanan</th>
                                                <th>Harga</th>
                                                <th>Jumlah</th>
                                                <th>Sub Total</th>
                                            </tr>
                                        </tfoot>
                                        <?php
                                            $i=1;
                                        ?>
                                        <tbody >
                                            @foreach ($transaksiDetail as $index => $item )
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $item -> layanan -> nama }}</td>
                                                <td>{{ $item -> harga }}</td>
                                                <td>{{ $item -> jumlah }}</td>
                                                <td>{{ $item -> subtotal }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <label for="nama" class="fw-semibold form-label mx-3 mt-2 mb-0">Nama Pengguna</label>
                            <div class="row mx-3 g-3 align-items-center">
                                <div class="col-3">
                                    <input type="text" id="nama" disabled class="form-control " name="nama"  value="{{ $transaksi-> user ->nama }}"/>
                                </div>
                            </div>

                            <label for="total_harga" class="fw-semibold form-label mx-3 mt-2 mb-0">Total Harga</label>
                            <div class="row mx-3 g-3 align-items-center">
                                <div class="col-3">
                                    <input type="number" id="total_harga" disabled class="form-control " name="total_harga"  value="{{ $transaksi->total_harga }}"/>
                                </div>
                            </div>

                            <label for="diskon" class="fw-semibold form-label mx-3 mt-2 mb-0">Diskon</label>
                            <div class="row mx-3 g-3 align-items-center">
                                <div class="col-3">
                                    @if($transaksi-> id_pengumuman == null)
                                    <input type="text" id="diskon" disabled class="form-control " name="diskon"  value="-"/>
                                    @else
                                    <input type="text" id="diskon" disabled class="form-control " name="diskon"  value="{{ $transaksi-> pengumuman ->judul }} {{ $transaksi-> pengumuman ->diskon }}%"/>
                                    @endif
                                </div>
                            </div>

                            <label for="total_tagihan" class="fw-semibold form-label mx-3 mt-2 mb-0">Total Tagihan</label>
                            <div class="row mx-3 g-3 align-items-center">
                                <div class="col-3">
                                    <input type="number" id="total_tagihan" disabled class="form-control " name="total_tagihan" value="{{ $transaksi->total_tagihan }}"/>
                                </div>
                            </div>

                            <label for="diterima" class="fw-semibold form-label mx-3 mt-2 mb-0">Diterima</label>
                            <div class="row mx-3 g-3 align-items-center">
                                <div class="col-3">
                                    <input type="number" id="diterima" disabled class="form-control" name="diterima" value="{{ $transaksi->diterima }}"/>
                                </div>
                            </div>

                            <label for="kembali" class="fw-semibold form-label mx-3 mt-2 mb-0">Kembali</label>
                            <div class="row mx-3 g-3 align-items-center mb-2">
                                <div class="col-3">
                                    <input type="number" id="kembali" disabled class="form-control " name="kembali" value=""/>
                                </div>
                            </div>
                            <div class="row mx-3 mb-2 g-3 mt-1 align-items-center">
                                <div class="col-auto">
                                    <a class="btn btn-danger" href="/transaksiAdmin" role="button">Kembali</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
                @include('sweetalert::alert')
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scriptsAdmin.js"></script>
        <script>$('.select2').select2();</script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="{{ asset('js/datatables-simple-demo.js') }}"></script>

        <script>
            $(document).ready(function() {
                function currencyFormat(x) {
                    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                }

                let diterima = $('[name="diterima"]');
                let kembali = $('[name="kembali"]');
                let total_tagihan = $('[name="total_tagihan"]');
                let total_harga = $('[name="total_harga"]').val();
                let diskon = $('[name="diskon"]');

                kembaliValue = diterima.val() - total_tagihan.val();
                if (kembaliValue < 0) {
                    kembali.val(0)
                } else {
                    kembali.val(kembaliValue);   
                }

            });
        </script>
    </body>
</html>
