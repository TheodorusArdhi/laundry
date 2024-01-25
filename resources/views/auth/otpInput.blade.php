<!DOCTYPE html>
<html lang="en">
    <head>
        @include('template.head')
        <title>OTP - Sinar Laundry</title>
    </head>
    <body class="bg-secondary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Loyalty Program</h3></div>
                                    <div class="card-body">
                                        <form method="POST" action="{{ url('pelanggan/otp/verify') }}">
                                            {{ csrf_field() }}
                                            <div class="row mx-3 g-3 align-items-center">
                                                    <input type="number" id="otp" class="form-control form-control-lg" name="otp" placeholder="kode OTP"/>
                                            </div>
                                            <div class="mt-4 mb-0">
                                                <div class="d-grid">
                                                    <button type="submit" class="btn btn-laundry btn-block fw-semibold" style="font-size: 1.12rem;" data-toggle="tooltip" data-placement="top" title="Verifikasi Kode OTP">Verifikasi</button>
                                                </div>
                                            </div>
                                        </form>                                        
                                    </div>
                                    <div class="card-footer text-start py-3">
                                        <a class="btn btn-danger fw-semibold" style="font-size: 1.12rem;" href="{{ url('pelanggan/otp') }}" role="button" >Kembali</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
                @include('sweetalert::alert')
            </div>
            {{--  <div id="layoutAuthentication_footer">
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2023</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>  --}}
        </div>
        @include('template.foot')
    </body>
</html>
