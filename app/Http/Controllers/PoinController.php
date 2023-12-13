<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Transaksi;
use Auth;

class PoinController extends Controller
{
    public function indexAdmin(){  
        $user = 'Semua';
        $pengguna = User::where("level", "pengguna")->get();
        $poin = Transaksi::orderBy('id_transaksi', 'desc')->where('id_status_transaksi', 7)->get();
        return view('poin.index', compact('poin', 'user', 'pengguna'));
    }

    public function indexUser(){  
        $poin = Transaksi::where('id_user', Auth::user()->id_user)->orderBy('id_transaksi', 'desc')->where('id_status_transaksi', 7)->get();
        $user = User::find(Auth::user()->id_user);
        return view('poin.index', compact('poin', 'user'));
    }

    public function poin(Request $request){  
        if($request->nama == "semua"){
            return redirect('admin/poin');          
        }
        $user = User::where('id_user', $request->nama)->first()->nama;
        $pengguna = User::where("level", "pengguna")->get();
        $poin = Transaksi::where('id_user', $request->nama)->orderBy('id_transaksi', 'desc')->where('id_status_transaksi', 7)->get();
        return view('poin.index', compact('poin', 'user', 'pengguna'));
    }
}
