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
                            <li class="breadcrumb-item active">Tambah Transaksi</li>
                        </ol>
                        @include('template.validate')
                        <div class="card shadow-lg border-0 rounded-lg mb-4">
                            <form method="POST" action="{{ route('tambahTransaksiDetail') }}">
                                {{ csrf_field() }}
                                <label for="namaAdmin" class="fw-semibold form-label mx-3 mt-2 mb-0">Admin</label>
                                <div class="row mx-3 g-3 align-items-center">
                                    <div class="col-3">
                                        <input type="text" id="namaAdmin" readonly class="form-control bg-light " name="namaAdmin"  value="{{ $transaksi->admin->nama }}"/>
                                    </div>
                                </div>
    
                                <label for="no_transaksi" class="fw-semibold form-label mx-3 mt-2 mb-0">Nomor Transaksi</label>
                                <div class="row mx-3 g-3 align-items-center">
                                    <div class="col-3">
                                        <input type="text" id="no_transaksi"  class="form-control bg-light" name="no_transaksi"  value="{{ $transaksi->no_transaksi }}" readonly/>
                                    </div>
                                </div>
    
                                <label for="tanggal" class="fw-semibold form-label mx-3 mt-2 mb-0">Tanggal</label>
                                <div class="row mx-3 g-3 align-items-center">
                                    <div class="col-3">
                                        <input type="text" id="tanggal" readonly class="form-control bg-light" name="tanggal"  value="{{ $transaksi->tgl_masuk }}"/>
                                    </div>
                                </div>

                                <div class="row g-3 align-items-center">
                                    <div class="col-3 ">
                                    <label for="layanan" class="fw-semibold form-label mx-3 mt-2 mb-0">Layanan</label>
                                        <div class="col mx-3">
                                            <select class="form-control " name="layanan" aria-label="Default select example" value="{{ Session::get('layanan') }}">
                                                <option selected disabled>Pilih Layanan</option>
                                                @foreach ($layanan as $item)
                                                <option value="{{ $item->id_layanan }}">{{ $item->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-3">
                                    <label for="jumlah" class="fw-semibold form-label  mt-2 mb-0">Jumlah</label>
                                        <div class="col mx-3">
                                            <input type="number" id="jumlah" class="form-control" name="jumlah" value="{{ Session::get('jumlah') }}"/>
                                        </div>
                                    </div>

                                    <div class="col-3">
                                        <div class="col-auto"><button type="submit" class="btn btn-primary btn-block" >Tambah</button></div>
                                    </div>
                                </div>
                            </form>
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
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tfoot >
                                            <tr>
                                                <th>No</th>
                                                <th>Layanan</th>
                                                <th>Harga</th>
                                                <th>Jumlah</th>
                                                <th>Sub Total</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </tfoot>
                                        <?php
                                            $i=1;
                                        ?>
                                        <tbody >
                                            @foreach ($detail as $index => $item )
                                            <tr>
                                                <form method="POST" action="{{ url('updateTransaksiDetail', $item->id_transaksi_detail) }}">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="harga" value="{{ $item -> harga }}">
                                                    <td>{{ $i++ }}</td>
                                                    <td>{{ $item -> layanan -> nama }}</td>
                                                    <td>{{ rupiah($item -> harga) }}</td>
                                                    <td><input type="number" id="jumlah" class="form-control" name="jumlah" value="{{ $item -> jumlah }}"</td>
                                                    <td>{{ rupiah($item -> subtotal) }}</td>
                                                    <td>
                                                        <button type="submit" class="btn btn-warning btn-block" >Edit</button>
                                                        <a class="btn btn-danger" href={{ url('hapusTransaksiDetail', $item->id_transaksi_detail) }} data-confirm-delete="true" role="button">Hapus</a>
                                                    </td>
                                                </form>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <form method="POST" action="/diskon">
                                {{ csrf_field() }}
                                <input type="hidden" name="id_transaksi" value="{{ $transaksi->id_transaksi }}">
                                <input type="hidden" name="total_harga" value="{{ $total_harga }}">
                                <label for="diskon" class="fw-semibold form-label mx-3 mt-2 mb-0">Diskon</label>
                                <div class="row mx-3 g-3 align-items-center">
                                    <div class="col-3">
                                        <select class="form-control " name="diskon" aria-label="Default select example" aria-describedby="diskon" value="{{$transaksi->id_pengumuman}}">
                                            @if ($transaksi->id_pengumuman == null)
                                            <option selected value="0" >Pilih Diskon</option>
                                            @foreach ($pengumuman as $item)     
                                            <option value="{{ $item->id_pengumuman }}" > {{ $item->judul }} {{ $item->diskon }}% </option>
                                            @endforeach                                               
                                            @else
                                            <option value="{{ $transaksi->id_pengumuman }}" > {{ $transaksi->pengumuman->judul }} {{ $transaksi->pengumuman->diskon }}% </option>
                                            @foreach ($pengumuman as $item)     
                                            <option value="{{ $item->id_pengumuman }}" > {{ $item->judul }} {{ $item->diskon }}% </option>
                                            @endforeach  
                                            <option value="0" >Pilih Diskon</option>
                                            @endif
                                        </select>
                                    </div>
                                    <div class="col-3">
                                        <div class="col-auto"><button type="submit" class="btn btn-primary btn-block" >Cek</button></div>
                                    </div>    
                                </div>     
                            </form>
                            <form method="POST" action="/simpanTransaksi">
                                {{ csrf_field() }} 
                                <input type="hidden" name="no_transaksi" value="{{ $transaksi->no_transaksi }}">
                                <label for="nama" class="fw-semibold form-label mx-3 mt-2 mb-0">Nama Pengguna</label>
                                <div class="row mx-3 g-3 align-items-center">
                                    <div class="col-3">
                                        <select class="form-control select2" name="nama" aria-label="Default select example" value="{{ Session::get('nama') }}">
                                            <option selected disabled>Pilih Pengguna</option>
                                            @foreach ($pengguna as $item)
                                            <option value="{{ $item->id_user }}">{{ $item->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <label for="total_harga" class="fw-semibold form-label mx-3 mt-2 mb-0">Total Harga</label>
                                <div class="row mx-3 g-3 align-items-center">
                                    <div class="col-3">
                                        <input type="number" id="total_harga" readonly class="form-control bg-light" name="total_harga"  value="{{ $total_harga }}"/>
                                    </div>
                                </div>


                                <label for="total_tagihan" class="fw-semibold form-label mx-3 mt-2 mb-0">Total Tagihan</label>
                                <div class="row mx-3 g-3 align-items-center">
                                    <div class="col-3">
                                        @if ($transaksi->id_pengumuman == null)
                                        <input type="number" id="total_tagihan" readonly class="form-control bg-light" name="total_tagihan" value="{{ $total_harga }}"/>                                            
                                        @else
                                        <input type="number" id="total_tagihan" readonly class="form-control bg-light" name="total_tagihan" value="{{ $transaksi->total_tagihan }}"/>                                            
                                        @endif
                                    </div>
                                </div>

                                <label for="diterima" class="fw-semibold form-label mx-3 mt-2 mb-0">Diterima</label>
                                <div class="row mx-3 g-3 align-items-center">
                                    <div class="col-3">
                                        <input type="number" id="diterima" class="form-control" name="diterima" value=""/>
                                    </div>
                                </div>

                                <label for="kembali" class="fw-semibold form-label mx-3 mt-2 mb-0">Kembali</label>
                                <div class="row mx-3 g-3 align-items-center">
                                    <div class="col-3">
                                        <input type="number" id="kembali" readonly class="form-control bg-light" name="kembali" value=""/>
                                    </div>
                                </div>

                                <div class="row mx-3 mb-2 g-3 mt-1 align-items-center">
                                    <div class="col-auto">
                                        <a class="btn btn-danger" href="/transaksiAdmin" role="button">Kembali</a>
                                    </div>
                                    <div class="col-auto"><button type="submit" class="btn btn-primary btn-block" >Tambah Transaksi</button></div>
                                </div>
                            </form>
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
        <script src="js/datatables-simple-demo.js"></script>
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

                diterima.on('input', function() {
                    kembaliValue = diterima.val() - total_tagihan.val();
                    if (kembaliValue < 0) {
                        kembali.val(0)
                    } else {
                        kembali.val(kembaliValue);   
                    }
                });
            });

        </script>
    </body>
</html>
