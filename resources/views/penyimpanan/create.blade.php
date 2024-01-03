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
                        <div class="card shadow-lg border-0 rounded-lg ">
                            <form method="POST" action="{{ url('admin/penyimpanan/store') }}">
                                {{ csrf_field() }} 
                                @if (Auth::user()->level == "owner")
                                    <label for="cabang" class="fw-semibold form-label mx-3 mt-2 mb-0">Cabang</label>
                                    <div class="row mx-3 g-3 align-items-center">
                                        <div class="col-3">
                                            <select class="form-select" name="cabang" aria-label="Default select example" value="{{ Session::get('cabang') }}">
                                                <option selected disabled>Pilih Cabang</option>
                                                @foreach ($cabang as $item)
                                                <option value="{{ $item->id_cabang }}">{{ $item->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @endif
                                <label for="nama" class="fw-semibold form-label mx-3 mt-2 mb-0">Nama</label>
                                <div class="row mx-3 g-3 align-items-center">
                                    <div class="col-3">
                                        <input type="text" id="nama" class="form-control" name="nama" value="{{ Session::get('nama') }}" />
                                    </div>
                                </div>

                                <label for="merek" class="fw-semibold form-label mx-3 mt-2 mb-0">Merek</label>
                                <div class="row mx-3 g-3 align-items-center">
                                    <div class="col-3">
                                        <input type="text" id="merek" class="form-control" name="merek" value="{{ Session::get('merek') }}" />
                                    </div>
                                </div>

                                <label for="jumlah" class="fw-semibold form-label mx-3 mt-2 mb-0">Jumlah</label>
                                <div class="row mx-3 g-3 align-items-center">
                                    <div class="col-3">
                                        <input type="number" id="jumlah" class="form-control" name="jumlah" value="{{ Session::get('jumlah') }}" />
                                    </div>
                                </div>

                                <label for="harga" class="fw-semibold form-label mx-3 mt-2 mb-0">Harga</label>
                                <div class="row mx-3 g-3 align-items-center">
                                    <div class="col-3">
                                        <input type="number" id="harga" class="form-control" name="harga" value="{{ Session::get('harga') }}" />
                                    </div>
                                </div>

                                <div class="row mx-3 mb-2 g-3 mt-1 align-items-center">
                                    <div class="col-auto">
                                    <a class="btn btn-danger" href="{{ url('admin/penyimpanan') }}" role="button">Kembali</a>
                                    </div>
                                    <div class="col-auto"><button type="submit" class="btn btn-primary btn-block" >Tambah Penyimpanan</button></div>
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
