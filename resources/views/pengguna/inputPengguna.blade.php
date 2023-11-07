<!DOCTYPE html>
<html lang="en">
    <head>
        @include('template.head')
        <title>Pengguna - Sinar Laundry</title>
    </head>
    <body class="sb-nav-fixed">
        @include('template.topNav')
        <div id="layoutSidenav">
            @include('template.sideNav')
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Pengguna</h1>
                        <ol class="breadcrumb mb-2">
                            <li class="breadcrumb-item active">Tambah Pengguna</li>
                        </ol>
                        @include('template.validate')
                        <div class="card shadow-lg border-0 rounded-lg ">
                            <form method="POST" action="/postPengguna">
                                {{ csrf_field() }} 

                                <label for="nama" class="fw-semibold form-label mx-3 mt-2 mb-0">Nama</label>
                                <div class="row mx-3 g-3 align-items-center">
                                    <div class="col-3">
                                        <input type="text" id="nama" class="form-control" name="nama" value="{{ Session::get('nama') }}" />
                                    </div>
                                </div>

                                <label for="email" class="fw-semibold form-label mx-3 mt-2 mb-0">Email</label>
                                <div class="row mx-3 g-3 align-items-center">
                                    <div class="col-3">
                                        <input type="email" id="email" class="form-control" name="email" value="{{ Session::get('email') }}" />
                                    </div>
                                </div>

                                <label for="no_telp" class="fw-semibold form-label mx-3 mt-2 mb-0">Nomor Telepon</label>
                                <div class="row mx-3 g-3 align-items-center">
                                    <div class="col-3">
                                        <input type="number" id="no_telp" class="form-control" name="no_telp" value="{{ Session::get('no_telp') }}" />
                                    </div>
                                </div>

                                <label for="level" class="fw-semibold form-label mx-3 mt-2 mb-0">Peran</label>
                                <div class="row mx-3 g-3 align-items-center">
                                    <div class="col-3">
                                        <select class="form-select" name="level" aria-label="Default select example" value="{{ Session::get('level') }}">
                                            <option selected disabled>Pilih Peran</option>
                                            <option value="admin">Admin</option>
                                            <option value="pengguna">Pengguna</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mx-3 mb-2 g-3 mt-1 align-items-center">
                                    <div class="col-auto">
                                    <a class="btn btn-danger" href="/pengguna" role="button">Kembali</a>
                                    </div>
                                    <div class="col-auto"><button type="submit" class="btn btn-primary btn-block" >Tambah Pengguna</button></div>
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
