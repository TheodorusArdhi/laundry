<!DOCTYPE html>
<html lang="en">
    <head>
        @include('template.head')
        <title>Cabang - Sinar Laundry</title>
    </head>
    <body class="sb-nav-fixed">
        @include('template.topNav')
        <div id="layoutSidenav">
            @include('template.sideNav')
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Cabang</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Edit Cabang</li>
                        </ol>
                        @include('template.validate')
                        <div class="card shadow-lg border-0 rounded-lg fs-5">
                            <form method="POST" action="{{ url('owner/cabang/'.$cabang->id_cabang.'/update') }}">
                                {{ csrf_field() }} 

                                <label for="nama" class="fw-semibold form-label mx-3 mt-2 mb-0">Nama</label>
                                <div class="row mx-3 g-3 align-items-center">
                                    <div class="col-3">
                                        <input type="text" id="nama" class="form-control form-control-lg" name="nama" placeholder="Masukkan Nama Cabang" value="{{ $cabang->nama }}" />
                                    </div>
                                </div>

                                <label for="alamat" class="fw-semibold form-label mx-3 mt-2 mb-0">Alamat</label>
                                <div class="row mx-3 g-3 align-items-center">
                                    <div class="col-3">
                                        <input type="text" id="alamat" class="form-control form-control-lg" name="alamat" placeholder="Masukkan Alamat Cabang" value="{{ $cabang->alamat }}" />
                                    </div>
                                </div>

                                <label for="no_telp" class="fw-semibold form-label mx-3 mt-2 mb-0">Nomor Telepon</label>
                                <div class="row mx-3 g-3 align-items-center">
                                    <div class="col-3">
                                        <input type="text" id="no_telp" class="form-control form-control-lg" name="no_telp" placeholder="Masukkan Nomor Telepon Cabang" value="{{ $cabang->no_telp }}" />
                                        <div id="no_telp" class="form-text">
                                            Masukkan nomor tanpa spasi
                                        </div>
                                    </div>
                                </div>

                                <label for="status" class="fw-semibold form-label mx-3 mt-2 mb-0">Status</label>
                                    <div class="row mx-3 g-3 align-items-center">
                                        <div class="col-3">
                                            <select class="form-control form-control-lg" name="status" aria-label="Default select example" value="{{ Session::get('status') }}">
                                                <option value="{{ $cabang->status }}">{{ $cabang->status }}</option>
                                                <option value="aktif">Aktif</option>
                                                <option value="tidak aktif">Tidak Aktif</option>
                                            </select>
                                        </div>
                                    </div>

                                <div class="row mx-3 mb-2 g-3 mt-1 align-items-center">
                                    <div class="col-auto">
                                    <a class="btn btn-danger fw-semibold" style="font-size: 1.12rem;" href="{{ url('owner/cabang') }}" role="button">Kembali</a>
                                    </div>
                                    <div class="col-auto"><button type="submit" class="btn btn-laundry btn-block fw-semibold" style="font-size: 1.12rem;" data-toggle="tooltip" data-placement="top" title="Simpan Cabang">Simpan</button></div>
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
