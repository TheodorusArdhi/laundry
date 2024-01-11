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
                            <li class="breadcrumb-item active">Siaran Pengumuman</li>
                        </ol>
                        @include('template.validate')
                        <div class="card shadow-lg border-0 rounded-lg fs-5">
                            <form method="POST" action="{{ url('owner/pengumuman/siaran') }}">
                                {{ csrf_field() }} 
                                <label for="pesan" class="fw-semibold form-label mx-3 mt-2 mb-0">Pesan</label>
                                <div class="row mx-3 g-3 align-items-center">
                                    <textarea class="form-control form-control-lg" placeholder="Tulis pesan anda disini" id="pesan" name="pesan" style="height: 200px"></textarea>
                                </div>

                                <div class="row mx-3 mb-2 g-3 mt-1 align-items-center">
                                    <div class="col-auto">
                                    <a class="btn btn-danger fw-semibold" style="font-size: 1.12rem;" href="{{ url('owner/pengumuman') }}" role="button">Kembali</a>
                                    </div>
                                    <div class="col-auto"><button type="submit" class="btn btn-laundry btn-block fw-semibold" style="font-size: 1.12rem;" data-toggle="tooltip" data-placement="top" title="Siarkan Pengumuman">Siarkan</button></div>
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
