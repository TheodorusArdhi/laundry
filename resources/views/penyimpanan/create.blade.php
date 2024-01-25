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
                        <ol class="breadcrumb mb-2">
                            <li class="breadcrumb-item active">Tambah Penyimpanan</li>
                        </ol>
                        @include('template.validate')
                        <div class="card shadow-lg border-0 rounded-lg fs-5">
                            <form method="POST" action="{{ url('admin/penyimpanan/store') }}">
                                {{ csrf_field() }} 
                                @if (Auth::user()->level == "pemilik")
                                    <label for="cabang" class="fw-semibold form-label mx-3 mt-2 mb-0">Cabang</label>
                                    <div class="row mx-3 g-3 align-items-center">
                                        <div class="col-3">
                                            <select class="form-select form-select-lg" name="cabang" aria-label="Default select example" value="{{ Session::get('cabang') }}">
                                                <option selected disabled>Pilih Cabang</option>
                                                @foreach ($cabang as $item)
                                                <option value="{{ $item->id_cabang }}">{{ $item->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @endif
                                <label for="nama" class="fw-semibold form-label mx-3 mt-2 mb-0">Nama Barang</label>
                                <div class="row mx-3 g-3 align-items-center">
                                    <div class="col-3">
                                        <input type="text" id="nama" class="form-control form-control-lg" name="nama" placeholder="Nama Barang" value="{{ Session::get('nama') }}" />
                                    </div>
                                </div>

                                <label for="merek" class="fw-semibold form-label mx-3 mt-2 mb-0">Merek</label>
                                <div class="row mx-3 g-3 align-items-center">
                                    <div class="col-3">
                                        <input type="text" id="merek" class="form-control form-control-lg" name="merek" placeholder="Merek Barang" value="{{ Session::get('merek') }}" />
                                    </div>
                                </div>

                                <label for="jumlah" class="fw-semibold form-label mx-3 mt-2 mb-0">Jumlah</label>
                                <div class="row mx-3 g-3 align-items-center">
                                    <div class="col-3">
                                        <input type="number" id="jumlah" class="form-control form-control-lg" name="jumlah" placeholder="Jumlah Barang" value="{{ Session::get('jumlah') }}" />
                                    </div>
                                </div>

                                <label for="harga" class="fw-semibold form-label mx-3 mt-2 mb-0">Harga</label>
                                <div class="row mx-3 g-3 align-items-center">
                                    <div class="col-3">
                                        <input type="number" id="harga" class="form-control form-control-lg" name="harga" placeholder="Harga Barang" value="{{ Session::get('harga') }}" />
                                    </div>
                                </div>

                                <div class="row mx-3 mb-2 g-3 mt-1 align-items-center">
                                    <div class="col-auto">
                                    <a class="btn btn-danger fw-semibold" style="font-size: 1.12rem;" href="{{ url('admin/penyimpanan') }}" role="button">Kembali</a>
                                    </div>
                                    <div class="col-auto"><button type="submit" class="btn btn-laundry btn-block fw-semibold" style="font-size: 1.12rem;" data-toggle="tooltip" data-placement="top" title="Simpan Barang">Simpan</button></div>
                                </div>
                            </form>
                        </div>
                    </div>
                </main>
                @include('sweetalert::alert')
            </div>
        </div>
        @include('template.foot')
    </body>
</html>
