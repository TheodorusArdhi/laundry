<!DOCTYPE html>
<html lang="en">
    <head>
        @include('template.head')
        <title>Layanan - Sinar Laundry</title>
    </head>
    <body class="sb-nav-fixed">
        @include('template.topNav')
        <div id="layoutSidenav">
            @include('template.sideNav')
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Layanan</h1>
                        <ol class="breadcrumb mb-2">
                            <li class="breadcrumb-item active">Tambah Layanan</li>
                        </ol>
                        @include('template.validate')
                        <div class="card shadow-lg border-0 rounded-lg ">
                            <form method="POST" action="{{ url('admin/layanan/store') }}">
                                {{ csrf_field() }} 
                                <label for="nama" class="fw-semibold form-label mx-3 mt-2 mb-0">Nama</label>
                                <div class="row mx-3 g-3 align-items-center">
                                    <div class="col-3">
                                        <input type="text" id="nama" class="form-control" name="nama" value="{{ Session::get('nama') }}" />
                                    </div>
                                </div>

                                <label for="harga" class="fw-semibold form-label mx-3 mt-2 mb-0">Harga</label>
                                <div class="row mx-3 g-3 align-items-center">
                                    <div class="col-auto">
                                    <label for="harga" class="col-form-label">Rp.</label>
                                    </div>
                                    <div class="col-3">
                                        <input class="form-control" name="harga" id="harga" type="number" value="{{ Session::get('harga') }}" />
                                    </div>
                                </div>

                                <label for="durasi" class="fw-semibold form-label mx-3 mt-2 mb-0">Durasi</label>
                                <div class="row mx-3 g-3 align-items-center">
                                    <div class="col-3">
                                        <input type="number" id="durasi" class="form-control" name="durasi" aria-describedby="durasi" value="{{ Session::get('durasi') }}"/>
                                    </div>
                                    <div class="col-auto">
                                        <label for="durasi" class="col-form-label">Hari</label>
                                    </div>
                                </div>

                                <label for="satuan" class="fw-semibold form-label mx-3 mt-2 mb-0">Satuan</label>
                                <div class="row mx-3 g-3 align-items-center">
                                    <div class="col-3">
                                        <select class="form-select" name="satuan" aria-label="Default select example" value="{{ Session::get('satuan') }}">
                                            <option selected disabled>Pilih Satuan</option>
                                            <option value="kg">Kg</option>
                                            <option value="satuan">Satuan</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mx-3 mb-2 g-3 mt-1 align-items-center">
                                    <div class="col-auto">
                                    <a class="btn btn-danger" href="{{ url('admin/layanan') }}" role="button">Kembali</a>
                                    </div>
                                    <div class="col-auto"><button type="submit" class="btn btn-primary btn-block" >Tambah Layanan</button></div>
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
