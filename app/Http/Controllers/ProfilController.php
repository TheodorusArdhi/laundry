<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use RealRashid\SweetAlert\Facades\Alert;

class ProfilController extends Controller
{
    public function index(){  
        $user = User::find(Auth::id());
        return view('profil.index', compact('user'));
    }

    public function update(Request $request){  
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
