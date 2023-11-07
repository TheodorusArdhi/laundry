<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
Use Illuminate\Support\Facades\Hash;
use Auth;
use Str;
use Carbon\Carbon;
use Session;

class AuthController extends Controller
{
    public function register(){  
        return view('register');
    }

    public function postRegister(Request $request){
        Session::flash('nama', $request->nama);
        Session::flash('email', $request->email);
        Session::flash('no_telp', $request->no_telp);
        Session::flash('password', $request->password);
        Session::flash('passwordConfirm', $request->passwordConfirm);

        $request->validate([
            'nama'=>'required',
            'email'=>'required|unique:users',
            'no_telp'=>'required',
            'password'=>'required',
            'passwordConfirm'=>'required|same:password'
        ], [
            'nama.required' => 'nama wajib diisi',
            'email.required' => 'email wajib diisi',
            'email.unique' => 'email sudah terpakai',
            'no_telp.required' => 'nomor telepon wajib diisi',
            'password.required' => 'password wajib diisi',
            'passwordConfirm.required' => 'konfirmasi password wajib diisi',
            'passwordConfirm.same' => 'konfirmasi password wajib sama dengan password'
        ]);

        $user = new User([
            'nama' => $request->nama,
            'email' => $request->email,
            'no_telp' => $request->no_telp,
            'password' => Hash::make($request->password),
            'remember_token' => Str::random(60),
            'level' => ('pengguna'),
            'notifikasi' => ('on')
        ]);
        $user->save();
        return redirect('login')->with('success', 'Registrasi Sukses');
    }
    
    public function login(){  
        return view('login');
    }
    
    public function postLogin(Request $request){  
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
        // if(Auth::attempt($request->only('email','password'))){
        //     return redirect('/password');
        // }
        return redirect('login')->with('warning', 'email atau password salah')->withInput();
    }

    public function password(){  
        return view('password');
    }

    public function postPassword(Request $request){  
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
        return redirect('password')->with('success', 'Ubah Password Sukses')->withInput();
    }

    public function logout(){
        Auth::logout();        
        return redirect('/');
    }
}
