<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Cabang;
use App\Models\Transaksi;
use RealRashid\SweetAlert\Facades\Alert;
use Auth;
use Session;
use Barryvdh\DomPDF\Facade\Pdf;
Use Illuminate\Support\Facades\Hash;
use Str;

class UserController extends Controller
{
    public function index(){  
        $pengguna = User::whereNot('id_user', Auth::user()->id_user)->orderBy('level')->get();
        $title = 'Yakin Hapus Pengguna?';
        confirmDelete($title);
        return view('user.index', compact('pengguna'));
    }

    public function indexAdmin(){  
        $pengguna = User::whereNot('id_user', Auth::user()->id_user)->whereIn('level', ['anggota','pelanggan'])->orderBy('level')->get();
        $title = 'Yakin Hapus Pengguna?';
        confirmDelete($title);
        return view('user.index', compact('pengguna'));
    }
    
    public function create(){  
        $cabang = Cabang::all();
        return view('user.create', compact('cabang'));
    }

    public function store(Request $request){
        Session::flash('nama', $request->nama);
        Session::flash('email', $request->email);
        Session::flash('no_telp', $request->no_telp);
        Session::flash('cabang', $request->cabang);

        $request->validate([
            'nama'=>'required',
            'email'=>'required|unique:users',
            'no_telp'=>['required','regex:/^(\+62|62|0)8[1-9][0-9]{6,9}$/'],
            'cabang'=>'required',
        ], [
            'nama.required' => 'nama wajib diisi',
            'email.required' => 'email wajib diisi',
            'email.unique' => 'email sudah terpakai',
            'no_telp.required' => 'nomor telepon wajib diisi',
            'no_telp.regex' => 'nomor telepon tidak valid',
            'cabang.required' => 'cabang wajib diisi',
        ]);

        $no_telp = $request->no_telp;
        $valid = new WAController;
        $valid = $valid->telepon($no_telp);
        if ($valid->not_registered != null ){
            return redirect('admin/user/create')->with('error', 'Nomor tidak terdaftar pada Whatsapp');
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
            'password' => Hash::make($request->email),
            'remember_token' => Str::random(60),
            'level' => "admin",
            'id_cabang' => $request->cabang,
            'notifikasi' => null,
        ]);
        //dd($user);
        $user->save();
        return redirect('pemilik/user')->with('success', 'Tambah Admin Sukses');
    }

    public function edit($id){  
        $user = User::findorfail($id);
        $cabang = Cabang::all();
        return view('user.edit', compact('user', 'cabang'));
    }

    public function update(Request $request, $id){  
        $user = User::findorfail($id);
        $request->validate([
            'cabang'=>'required',
        ], [
            'cabang.required' => 'cabang wajib diisi',
        ]);

        $user->update([
            'id_cabang' => $request->cabang,]);
        if($request->password == "on"){
            $user->update([ 'password' => Hash::make($request->email) ]);
        }

        return redirect('pemilik/user')->with('success', 'Edit Admin Sukses');
    }

    public function delete($id){  
        User::find($id)->delete();
        return redirect('admin/user')->with('success', 'Hapus Pengguna Sukses');
    }

    public function profil(){  
        $user = User::find(Auth::id());
        $transaksi = Transaksi::where('id_user', Auth::id())->count();
        return view('profil.index', compact('user', 'transaksi'));
    }

    public function profilUpdate(Request $request){  
        $request->validate([
            'nama'=>'required',
            'email'=>'required',
            'no_telp'=>['required','regex:/^(\+62|62|0)8[1-9][0-9]{6,9}$/'],
        ], [
            'nama.required' => 'nama wajib diisi',
            'email.required' => 'email wajib diisi',
            'no_telp.required' => 'nomor telepon wajib diisi',
            'no_telp.regex' => 'nomor telepon tidak valid',
        ]);

        $no_telp = $request->no_telp;
        $valid = new WAController;
        $valid = $valid->telepon($no_telp);
        if ($valid->not_registered != null ){
            return redirect('/profil')->with('error', 'Nomor tidak terdaftar pada Whatsapp');
        }

        if(substr(trim($no_telp), 0, 2)=="62"){
            $no_telp = "62".substr(trim($no_telp), 2);
        }
        elseif(substr(trim($no_telp), 0, 1)=="0"){
            $no_telp = "62".substr(trim($no_telp), 1);
        }
        
        $user = User::find(Auth::id());
        $user->nama = $request->nama;
        $user->email = $request->email;
        $user->no_telp = $no_telp;
        $user->notifikasi = $request->notifikasi;
        $user->save();
        return redirect('profil')->with('success', 'Ubah Profil Sukses');
    }
}
