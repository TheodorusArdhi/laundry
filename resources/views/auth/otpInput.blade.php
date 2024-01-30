<!DOCTYPE html>
<html lang="en">
    <head>
        @include('template.head')
        <title>OTP - Sinar Laundry</title>
        <style>
            #spin{
                width:100%;
                height:100%;
                position: absolute;
              }
        </style>
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
                                        <div id="spin">
                                            <button class="btn btn-danger fw-semibold" disabled style="font-size: 1.12rem; width: 90px !important; opacity: 100%;" type="button">  
                                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                                <span id="timer"></span>
                                            </button>
                                        </div>
                                        <a class="btn btn-danger fw-semibold" style="font-size: 1.12rem;" href="{{ url('pelanggan/otp/request') }}" role="button" >Coba Lagi</a>
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
        <script>
            var delay = {{ $waktu }};
            setTimeout(function() 
                {  
                    $( "#spin" ).fadeOut( "slow" );
                },
                delay
            );

            document.getElementById('timer').innerHTML = {{ $menit[0] }} + ":" + {{ $menit[1] }};
                startTimer();

                function startTimer() {
                    var presentTime = document.getElementById('timer').innerHTML;
                    var timeArray = presentTime.split(/[:]+/);
                    var m = timeArray[0];
                    var s = checkSecond((timeArray[1] - 1));
                    if(s==59){m=m-1}
                    if(m<0){
                        return
                    }
                    
                    document.getElementById('timer').innerHTML = m + ":" + s;
                    console.log(m)
                    setTimeout(startTimer, 1000);
                }

                function checkSecond(sec) {
                if (sec < 10 && sec >= 0) {sec = "0" + sec}; // add zero in front of numbers < 10
                if (sec < 0) {sec = "59"};
                return sec;
                }
        </script>
    </body>
</html>
