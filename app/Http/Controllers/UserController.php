<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Cabang;
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
        $pengguna = User::whereNot('id_user', Auth::user()->id_user)->where('level', 'pengguna')->get();
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
            'notifikasi' => "on",
        ]);
        $user->save();
        return redirect('admin/user')->with('success', 'Tambah Admin Sukses');
    }

    public function edit($id){  
        $user = User::findorfail($id);
        $cabang = Cabang::all();
        return view('user.edit', compact('user', 'cabang'));
    }

    public function update(Request $request, $id){  
        $user = User::findorfail($id);
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

        if (Auth::user()->level == "owner"){
            $request->validate([
                'cabang'=>'required',
            ], [
                'cabang.required' => 'cabang wajib diisi',
            ]);
        }

        $no_telp = $request->no_telp;
        $valid = new WAController;
        $valid = $valid->telepon($no_telp);
        if ($valid->not_registered != null ){
            return redirect('admin/user/'.$id.'/edit')->with('error', 'Nomor tidak terdaftar pada Whatsapp');
        }

        if(substr(trim($no_telp), 0, 2)=="62"){
            $no_telp = "62".substr(trim($no_telp), 2);
        }
        elseif(substr(trim($no_telp), 0, 1)=="0"){
            $no_telp = "62".substr(trim($no_telp), 1);
        }

        $user->update($request->all());
        $user->update([
            'no_telp' => $no_telp,
            'id_cabang' => $request->cabang,]);
        if($request->password == "on"){
            $user->update([ 'password' => Hash::make($request->email) ]);
        }
        return redirect('admin/user')->with('success', 'Edit Pengguna Sukses');
    }

    public function delete($id){  
        User::find($id)->delete();
        return redirect('admin/user')->with('success', 'Hapus Pengguna Sukses');
    }
}
