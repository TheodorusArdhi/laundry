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
                    <div class="container-fluid px-4  fs-5">
                        <h1 class="mt-4">Penyimpanan</h1>
                        <a class="btn btn-laundry fw-semibold" style="font-size: 1.12rem;" href="{{ url('admin/penyimpanan/create') }}" role="button" data-toggle="tooltip" data-placement="top" title="Tambah Barang">Tambah <i class="fa-solid fa-plus"></i></a>
                        @if (Auth::user()->level == "owner")
                            <form method="POST" action="{{ url('owner/penyimpanan/cabang') }}">
                                {{ csrf_field() }} 
                                <label for="cabang" class="fw-semibold form-label mt-2 mb-0">Cabang</label>
                                <div class="row g-3 align-items-center">
                                    <div class="col-3">
                                        <select class="form-control form-control-lg" name="cabang" id="cabang" aria-label="Default select example" value="{{ Session::get('branch') }}">
                                                <option selected >{{ $branch }}</option>
                                                <option value="semua" >Semua</option>
                                                @foreach ($cabang as $item)
                                                <option value="{{ $item->id_cabang }}">{{ $item->nama }}</option>
                                                @endforeach
                                        </select>
                                    </div>
                                    <div class="col-3">
                                        <div class="col-auto"><button type="submit" class="btn btn-secondary fw-semibold btn-block" role="button" data-toggle="tooltip" data-placement="top" title="Cek Cabang">Cek</button></div>
                                    </div> 
                                </div>
                            </form>
                        @endif
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
                                            @if (Auth::user()->level == "owner")
                                            <th>Cabang</th>
                                            @endif
                                            <th>Nama Barang</th>
                                            <th>Jumlah</th>
                                            <th>Harga</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tfoot >
                                        <tr>
                                            <th>No</th>
                                            @if (Auth::user()->level == "owner")
                                            <th>Cabang</th>
                                            @endif
                                            <th>Nama Barang</th>
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
                                            @if (Auth::user()->level == "owner")
                                            <th>{{ $item -> cabang -> nama }}</th>
                                            @endif
                                            <th>{{ $item -> nama }}</th>
                                            <th>{{ $item -> jumlah }}</th>
                                            <th>{{ rupiah($item -> harga) }}</th>
                                            <td>
                                                <a class="btn btn-laundry" href={{ url('admin/penyimpanan/'.$item->id_penyimpanan.'/edit') }} role="button" data-toggle="tooltip" data-placement="top" title="Lihat Detil"><i class="fa-solid fa-magnifying-glass"></i></a>
                                                <a class="btn btn-danger" href={{ url('admin/penyimpanan/'.$item->id_penyimpanan.'/delete') }} role="button" data-toggle="tooltip" data-placement="top" title="Hapus" data-confirm-delete="true"><i class="fa-solid fa-trash"></i></a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @include('sweetalert::alert')
                        </div>
                    </div>
                </main>
            </div>
        </div>
        @include('template.foot')
    </body>
</html>
