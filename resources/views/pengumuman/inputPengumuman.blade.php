<!DOCTYPE html>
<html lang="en">
    <head>
        @include('template.head')
        <title>Pengumuman - Sinar Laundry</title>
    </head>
    <body class="sb-nav-fixed">
        @include('template.topNav')
        <div id="layoutSidenav">
            @include('template.sideNav')
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Pengumuman</h1>
                        <ol class="breadcrumb mb-2">
                            <li class="breadcrumb-item active">Tambah Pengumuman</li>
                        </ol>
                        @include('template.validate')
                        <div class="card shadow-lg border-0 rounded-lg ">
                            <form method="POST" action="/postPengumuman">
                                {{ csrf_field() }} 

                                <label for="judul" class="fw-semibold form-label mx-3 mt-2 mb-0">Judul</label>
                                <div class="row mx-3 g-3 align-items-center">
                                    <div class="col-3">
                                        <input type="text" id="judul" class="form-control" name="judul" value="{{ Session::get('judul') }}" />
                                    </div>
                                </div>

                                <label for="deskripsi" class="fw-semibold form-label mx-3 mt-2 mb-0">Deskripsi</label>
                                <div class="row mx-3 g-3 align-items-center">
                                    <div class="col-3">
                                        <textarea  class="form-control" name="deskripsi" id="deskripsi"  >{{ Session::get('deskripsi') }}</textarea>
                                    </div>
                                </div>

                                <label for="diskon" class="fw-semibold form-label mx-3 mt-2 mb-0">Diskon</label>
                                <div class="row mx-3 g-3 align-items-center">
                                    <div class="col-3">
                                        <input type="number" id="diskon" class="form-control" name="diskon" aria-describedby="diskon" value="{{ Session::get('diskon') }}"/>
                                    </div>
                                    <div class="col-auto">
                                        <label for="diskon" class="col-form-label">%</label>
                                    </div>
                                </div>

                                <div class="row mx-3 mb-2 g-3 mt-1 align-items-center">
                                    <div class="col-auto">
                                    <a class="btn btn-danger" href="/pengumuman" role="button">Kembali</a>
                                    </div>
                                    <div class="col-auto"><button type="submit" class="btn btn-primary btn-block" >Tambah Pengumuman</button></div>
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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
    </body>
</html>
