<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Registrasi - Sinar Laundry</title>
        <link rel="icon" type="image/x-icon" href="assets/washing_machine.ico" />
        <link href="css/stylesAdmin.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-7">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Buat Akun</h3></div>
                                    <div class="card-body">
                                        @include('template.validate')
                                        <form method="POST" action="/postRegister">
                                            {{ csrf_field() }} 
                                            <div class="form-floating mb-3">
                                                <input class="form-control" name="nama" type="text" placeholder="Nama" value="{{ Session::get('nama') }}" />
                                                <label for="nama">Nama</label>
                                            </div>

                                            <div class="form-floating mb-3">
                                                <input class="form-control" name="email" type="email" placeholder="name@example.com" value="{{ Session::get('email') }}"/>
                                                <label for="email">Email</label>
                                            </div>

                                            <div class="form-floating mb-3">
                                                <input class="form-control" name="no_telp" type="number" placeholder="Nomor Telepon" value="{{ Session::get('no_telp') }}"/>
                                                <label for="noTelp">Nomor Telepon</label>
                                            </div>
                                            
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" name="password" type="password" placeholder="Create a password" value="{{ Session::get('password') }}"/>
                                                        <label for="password">Password</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" name="passwordConfirm" type="password" placeholder="Konfirmasi Password" value="{{ Session::get('passwordConfirm') }}"/>
                                                        <label for="passwordConfirm">Konfirmasi Password</label>
                                                    </div>
                                                </div>
                                            </div>

                                            {{--  <input type="submit" class="btn btn-primary" value="Login">  --}}

                                            <div class="mt-4 mb-0">
                                                <div class="d-grid"><button type="submit" class="btn btn-primary btn-block" >Buat Akun</button></div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center py-3">
                                        <div class="small"><a href="/login">Punya akun? Login sekarang!</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
                @include('sweetalert::alert')
            </div>
            <div id="layoutAuthentication_footer">
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
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scriptsAdmin.js"></script>
    </body>
</html>
