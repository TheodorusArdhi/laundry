<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\OTP;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use App\Models\Layanan;
use App\Models\Pengumuman;
use App\Models\Cabang;
Use Illuminate\Support\Facades\Hash;
use Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Str;
use Carbon\Carbon;
use Session;
use App\Http\Controllers\UserController;
// use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\WAController;

class AuthController extends Controller
{
    public function indexLogin(){  
        return view('auth.login');
    }
    
    public function indexRegister(){  
        return view('auth.register');
    }

    public function storeRegister(Request $request){
        Session::flash('nama', $request->nama);
        Session::flash('email', $request->email);
        Session::flash('no_telp', $request->no_telp);
        Session::flash('password', $request->password);
        Session::flash('passwordConfirm', $request->passwordConfirm);

        $request->validate([
            'nama'=>'required',
            'email'=>'required|unique:users',
            'no_telp'=>['required','regex:/^(\+62|62|0)8[1-9][0-9]{6,9}$/','unique:users'],
            'password'=>'required|min:8',
            'passwordConfirm'=>'required|same:password'
        ], [
            'nama.required' => 'Nama Wajib Diisi',
            'email.required' => 'Email Wajib Diisi',
            'email.unique' => 'Email sudah terpakai',
            'no_telp.required' => 'Nomor telepon Wajib Diisi',
            'no_telp.regex' => 'Nomor telepon tidak valid',
            'no_telp.unique' => 'Nomor telepon sudah terpakai',
            'password.required' => 'Password Wajib Diisi',
            'passwordConfirm.required' => 'Konfirmasi password Wajib Diisi',
            'password.min' => 'Karakter Password minimal 8',
            'passwordConfirm.same' => 'Konfirmasi password tidak sama'
        ]);
        $no_telp = $request->no_telp;
        $valid = new WAController;
        $valid = $valid->telepon($no_telp);
        if ($valid->not_registered != null ){
            return redirect('/register/index')->with('error', 'Nomor tidak terdaftar pada Whatsapp');
        }

        if(substr(trim($no_telp), 0, 2)=="62"){
            $no_telp = "62".substr(trim($no_telp), 2);
        }
        elseif(substr(trim($no_telp), 0, 1)=="0"){
            $no_telp = "62".substr(trim($no_telp), 1);
        }

        $user = new User([
            'nama' => $request->nama,
            'email' => $request->email,
            'no_telp' => $no_telp,
            'password' => Hash::make($request->password),
            'remember_token' => Str::random(60),
            'level' => 'pelanggan',
            'notifikasi' => 'on'
        ]);
        $user->save();
        return redirect()->route('indexLogin')->with('success', 'Registrasi Sukses');
    }
    
    public function login(Request $request){  
        $request->validate([
            'email'=>'required',
            'password'=>'required'
        ], [
            'email.required' => 'Email Wajib Diisi',
            'password.required' => 'Password Wajib Diisi'
        ]);
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            if(Auth::user()->level == "pemilik" || Auth::user()->level == "admin"){
                return redirect('dashboard')->with('success', 'Selamat Datang '.Auth::user()->nama);
            }else{
                return redirect('profil')->with('success', 'Selamat Datang '.Auth::user()->nama);
            }
        }
        return redirect()->route('indexLogin')->with('warning', 'Email atau Password Salah')->withInput();
    }

    public function indexPassword(){  
        return view('auth.password');
    }

    public function updatePassword(Request $request){  
        $request->validate([
            'oldPassword'=>'required|current_password',
            'newPassword'=>'required|min:8',
            'newPasswordConfirm'=>'required|same:newPassword'
        ], [
            'oldPassword.required' => 'password lama Wajib Diisi',
            'oldPassword.current_password' => 'password lama salah',
            'newPassword.required' => 'password baru Wajib Diisi',
            'newPassword.min' => 'karakter password minimal 8',
            'newPasswordConfirm.required' => 'konfirmasi password baru Wajib Diisi',
            'newPasswordConfirm.same' => 'konfirmasi password baru wajib sama dengan password baru',
        ]);

        $user = User::find(Auth::id());
        $user->password = Hash::make($request->newPassword);
        $user->save();
        return redirect('profil')->with('success', 'Ubah Password Sukses')->withInput();
    }

    public function logout(){
        Auth::logout();        
        return redirect('/');
    }

    public function indexOTP(){
        return view('auth.otp');
    }
    
    public function indexInputOTP(){
        return view('auth.otpInput');
    }

    public function requestOTP(){
        $user = User::where('id_user', Auth::user()->id_user);
        $nomor = $user->first()->no_telp;
        $OTP = OTP::where('id_user', Auth::user()->id_user);

        if($OTP->count() > 0){
            $OTP->delete();
        }

        $curl = curl_init();
        $otp = rand(100000, 999999);
        $waktu = time();

        $newOTP = new OTP([
            'id_user' => Auth::user()->id_user,
            'otp' => $otp,
            'waktu' => $waktu,
        ]);
        $newOTP->save();

        $data = [
            'target' => $nomor,
            'message' => "Sinar Laundry Loyalty Program

Kode OTP Anda : ".$otp."

(berlaku 5 menit). Demi keamanan akun Anda, mohon TIDAK MEMBERIKAN kode OTP kepada siapapun."

        ];
  
        curl_setopt(
            $curl,
            CURLOPT_HTTPHEADER,
            array(
                "Authorization: Jv-ZUx0YHVq#NEu5AJPz",
            )
        );
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($curl, CURLOPT_URL, "https://api.fonnte.com/send");
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        $result = curl_exec($curl);
        curl_close($curl);

        return redirect('/pelanggan/otp/input')->with('success', 'Koded OTP telah terkirim pada Whatsapp Anda');

    }
  
    public function verifyOTP(Request $request){
        $user = User::where('id_user', Auth::user()->id_user);
        $nomor = $user->first()->no_telp;
        $DB = OTP::where('id_user', Auth::user()->id_user)->where('otp', $request->otp);

        if ($DB->count() > 0) {
            $waktu = $DB->first()->waktu;
            if (time() - $waktu <= 300) {
                $user->update(['level' => "anggota"]);
                $WA = new WAController;
                $WA->anggota(Auth::user()->id_user);
                return redirect('/dashboard')->with('success', 'Kode OTP Benar');
            } else {
                return redirect('/pelanggan/otp')->with('error', 'Kode OTP Kadaluarsa, Silahkan Coba Lagi');
            }
        } else {
            return redirect('/pelanggan/otp/input')->with('error', 'Kode OTP Salah');
        }
    }

    public function dashboard(){   
        if(Transaksi::where('id_user', null)->count() != 0){
            $id_transaksi = Transaksi::where('id_user', null)->first()->id_transaksi;
            TransaksiDetail::where('id_transaksi', $id_transaksi)->delete();
            Transaksi::where('id_transaksi', $id_transaksi)->delete();
        }
        if(Auth::user()->level == "pemilik"){
            $transaksi = Transaksi::count();
            $proses = Transaksi::where('id_status_transaksi', 3)->count();
            $diambil = Transaksi::where('id_status_transaksi', 7)->count();
            $batasWaktu = Transaksi::where('id_status_transaksi', 6)->count();
        }elseif(Auth::user()->level == "admin"){
            $transaksi = Transaksi::where('id_cabang', Auth::user()->id_cabang)->count();
            $proses = Transaksi::where('id_cabang', Auth::user()->id_cabang)->where('id_status_transaksi', 3)->count();
            $diambil = Transaksi::where('id_cabang', Auth::user()->id_cabang)->where('id_status_transaksi', 7)->count();
            $batasWaktu = Transaksi::where('id_cabang', Auth::user()->id_cabang)->where('id_status_transaksi', 6)->count();
        }elseif(Auth::user()->level == "pelanggan" || Auth::user()->level == "anggota"){
            $transaksi = Transaksi::where('id_user', Auth::user()->id_user)->count();
            $proses = Transaksi::where('id_user', Auth::user()->id_user)->where('id_status_transaksi', 3)->count();
            $diambil = Transaksi::where('id_user', Auth::user()->id_user)->where('id_status_transaksi', 7)->count();
            $batasWaktu = Transaksi::where('id_user', Auth::user()->id_user)->where('id_status_transaksi', 6)->count();
        }

        $data = Transaksi::select('total_tagihan', 'tgl_masuk')->where('id_status_pembayaran', 1)->orderBy('tgl_masuk', 'asc')->get()->groupBy(function($data){
            return Carbon::parse($data->tgl_masuk)->translatedFormat('F Y');
        });
        $bulans=[];
        $bulanTotal=[];
        if($bulanTotal == null){
            $bulans=now()->translatedFormat('F Y');
            $bulanTotal[0]=0;
        }else{
            foreach($data as $bulan => $value){
                $bulans[]=$bulan;
                $bulanTotal[]=$value->sum('total_tagihan');
            }
        }
        return view('dashboard', compact('transaksi', 'proses', 'diambil', 'batasWaktu', 'bulans', 'bulanTotal'));
    }

    public function home(){ 
        $layanan = Layanan::where('status', 'aktif')->get();
        $pengumuman = Pengumuman::where('status', 'aktif')->get();
        $cabang = Cabang::where('status', 'aktif')->get();
        return view('home', compact('layanan', 'pengumuman', 'cabang'));
    }

}
