<!DOCTYPE html>
<html lang="en">
    <head>
        @include('template.head')
        <title>Penyimpanan - Sinar Laundry</title>
    </head>
    <body class="sb-nav-fixed">
        @include('template.topNav')
        <div id="layoutSidenav">
            @include('template.sideNav')
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Penyimpanan</h1>
                        <a class="btn btn-success" href="{{ url('admin/penyimpanan/create') }}" role="button">Tambah</a>
                        <form method="POST" action="{{ url('admin/penyimpanan/cabang') }}">
                            {{ csrf_field() }} 
                            <label for="cabang" class="fw-semibold form-label mt-2 mb-0">Cabang</label>
                            <div class="row g-3 align-items-center">
                                <div class="col-3">
                                    <select class="form-control select2" name="cabang" id="cabang" aria-label="Default select example" value="{{ Session::get('branch') }}">
                                            <option selected >{{ $branch }}</option>
                                            <option value="semua" >Semua</option>
                                            @foreach ($cabang as $item)
                                            <option value="{{ $item->id_cabang }}">{{ $item->nama }}</option>
                                            @endforeach
                                    </select>
                                </div>
                                <div class="col-3">
                                    <div class="col-auto"><button type="submit" class="btn btn-primary btn-block" >Cek</button></div>
                                </div> 
                            </div>
                        </form>
                        <div class="card mb-4 mt-2 ">                            
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                <a> <b class="fw-semibold"></b></a>
                            </div>                            
                            <div class="card-body  ">
                                <table id="datatablesSimple">
                                    <thead >
                                        <tr>
                                            <th>No</th>
                                            <th>Cabang</th>
                                            <th>Nama</th>
                                            <th>Merek</th>
                                            <th>Jumlah</th>
                                            <th>Harga</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tfoot >
                                        <tr>
                                            <th>No</th>
                                            <th>Cabang</th>
                                            <th>Nama</th>
                                            <th>Merek</th>
                                            <th>Jumlah</th>
                                            <th>Harga</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </tfoot>
                                    <?php
                                        $i=1;
                                    ?>
                                    <tbody >
                                        @foreach ($penyimpanan as $item)
                                        <tr>
                                            <th>{{ $i++ }}</th>
                                            <th>{{ $item -> cabang -> nama }}</th>
                                            <th>{{ $item -> nama }}</th>
                                            <th>{{ $item -> merek }}</th>
                                            <th>{{ $item -> jumlah }}</th>
                                            <th>{{ rupiah($item -> harga) }}</th>
                                            <td>
                                                <a class="btn btn-warning" href={{ url('admin/penyimpanan/'. $item->id_penyimpanan.'/edit') }} role="button">Edit</a>
                                                @php
                                                    $hapus = App\Models\TransaksiDetail::where('id_transaksi', $item->id_penyimpanan)->count();
                                                @endphp
                                                @if ($hapus == 0)
                                                <a class="btn btn-danger" href={{ url('admin/penyimpanan/'. $item->id_penyimpanan.'/delete') }} data-confirm-delete="true" role="button">Hapus</a>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
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
