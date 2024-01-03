<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
Use Illuminate\Support\Facades\Hash;
use Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Str;
use Carbon\Carbon;
use Session;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfilController;

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
            'password'=>'required',
            'passwordConfirm'=>'required|same:password'
        ], [
            'nama.required' => 'Nama wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.unique' => 'Email sudah terpakai',
            'no_telp.required' => 'Nomor telepon wajib diisi',
            'no_telp.regex' => 'Nomor telepon tidak valid',
            'no_telp.unique' => 'Nomor telepon sudah terpakai',
            'password.required' => 'Password wajib diisi',
            'passwordConfirm.required' => 'Konfirmasi password wajib diisi',
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
            'level' => 'pengguna',
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
            'email.required' => 'email wajib diisi',
            'password.required' => 'password wajib diisi'
        ]);
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            return redirect('dashboard');
        }
        return redirect()->route('indexLogin')->with('warning', 'Email atau Password Salah')->withInput();
    }

    public function indexPassword(){  
        return view('auth.password');
    }

    public function updatePassword(Request $request){  
        $request->validate([
            'oldPassword'=>'required|current_password',
            'newPassword'=>'required',
            'newPasswordConfirm'=>'required|same:newPassword'
        ], [
            'oldPassword.required' => 'password lama wajib diisi',
            'oldPassword.required' => 'password salah',
            'newPassword.required' => 'password baru wajib diisi',
            'newPasswordConfirm.required' => 'konfirmasi password baru wajib diisi',
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
}
