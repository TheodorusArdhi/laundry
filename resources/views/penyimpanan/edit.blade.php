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
                            <li class="breadcrumb-item active">Edit Penyimpanan</li>
                        </ol>
                        @include('template.validate')
                        <div class="card shadow-lg border-0 rounded-lg fs-5">
                            <form method="POST" action="{{ url('admin/penyimpanan/'.$penyimpanan->id_penyimpanan.'/update') }}">
                                {{ csrf_field() }} 
                                <div class="row mx-3 g-3 align-items-center">
                                    <div class="col-6">
                                        <label for="nama" class="fw-semibold form-label mt-2 mb-0">Nama Barang</label>
                                        <input type="text" id="nama" class="form-control form-control-lg" name="nama" placeholder="Nama Barang" value="{{ $penyimpanan->nama }}" />
                                    </div>
                                    <div class="col-6">
                                        <label for="merek" class="fw-semibold form-label mt-2 mb-0">Merek</label>
                                        <input type="text" id="merek" class="form-control form-control-lg" name="merek" placeholder="Merek Barang" value="{{ $penyimpanan->merek }}" />
                                    </div>
                                </div>

                                <div class="row mx-3 g-3 align-items-center">
                                    <div class="col-6">
                                        <label for="jumlah" class="fw-semibold form-label mt-2 mb-0">Jumlah</label>
                                        <input type="number" id="jumlah" class="form-control form-control-lg" name="jumlah" placeholder="Jumlah Barang" value="{{ $penyimpanan->jumlah }}" />
                                    </div>
                                    <div class="col-6">
                                        <label for="harga" class="fw-semibold form-label mt-2 mb-0">Harga</label>
                                        <input type="number" id="harga" class="form-control form-control-lg" name="harga" placeholder="Harga Barang" value="{{ $penyimpanan->harga }}" />
                                    </div>
                                </div>

                                @if (Auth::user()->level == "pemilik")
                                <div class="row mx-3 g-3 align-items-center">
                                    <div class="col-6">
                                            <label for="cabang" class="fw-semibold form-label mt-2 mb-0">Cabang</label>
                                            <select class="form-select form-select-lg" name="cabang" aria-label="Default select example" value="{{ Session::get('cabang') }}">
                                                <option selected value="{{ $penyimpanan->id_cabang }}">{{ $penyimpanan->cabang->nama }}</option>
                                                @foreach ($cabang as $item)
                                                <option value="{{ $item->id_cabang }}">{{ $item->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @endif

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
                @include('template.footer')
                @include('sweetalert::alert')
            </div>
        </div>
        @include('template.foot')
    </body>
</html>
