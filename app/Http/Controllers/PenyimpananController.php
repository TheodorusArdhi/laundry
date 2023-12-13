<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cabang;
use App\Models\Penyimpanan;
use RealRashid\SweetAlert\Facades\Alert;
use Session;

class PenyimpananController extends Controller
{
    public function index(){  
        $branch = 'Semua';
        $cabang = Cabang::all();
        $penyimpanan = Penyimpanan::orderBy('id_cabang', 'desc')->get();
        return view('penyimpanan.index', compact('penyimpanan', 'branch', 'cabang'));
    }

    public function cabang(Request $request){  
        if($request->cabang == "semua"){
            return redirect('admin/penyimpanan');          
        }
        $branch = Cabang::where('id_cabang', $request->cabang)->first()->nama;
        $cabang = Cabang::all();
        $penyimpanan = Penyimpanan::where('id_cabang', $request->cabang)->orderBy('created_at', 'desc')->get();
        return view('penyimpanan.index', compact('penyimpanan', 'branch', 'cabang'));
    }

    public function create(){  
        $cabang = Cabang::all();
        return view('penyimpanan.create', compact('cabang'));
    }

    public function store(Request $request){

        Session::flash('cabang', $request->cabang);
        Session::flash('nama', $request->nama);
        Session::flash('merek', $request->merek);
        Session::flash('jumlah', $request->jumlah);
        Session::flash('harga', $request->harga);

        $request->validate([
            'cabang'=>'required',
            'nama'=>'required',
            'merek'=>'required',
            'jumlah'=>'required',
            'harga'=>'required',
        ], [
            'cabang.required' => 'cabang wajib diisi',
            'nama.required' => 'nama wajib diisi',
            'merek.required' => 'merek wajib diisi',
            'jumlah.required' => 'jumlah wajib diisi',
            'harga.required' => 'harga wajib diisi',
        ]);

        $penyimpanan = new Penyimpanan([
            'id_cabang' => $request->cabang,
            'nama' => $request->nama,
            'merek' => $request->merek,
            'jumlah' => $request->jumlah,
            'harga' => $request->harga,
        ]);
        $penyimpanan->save();
        return redirect('admin/penyimpanan')->with('success', 'Tambah Penyimpanan Sukses');
    }

    public function edit($id){  
        $penyimpanan = Penyimpanan::findorfail($id);
        $cabang = Cabang::all();
        return view('penyimpanan.edit', compact('penyimpanan', 'cabang'));
    }

    public function update(Request $request, $id){  
        $penyimpanan = Penyimpanan::findorfail($id);

        $request->validate([
            'cabang'=>'required',
            'nama'=>'required',
            'merek'=>'required',
            'jumlah'=>'required',
            'harga'=>'required',
        ], [
            'cabang.required' => 'cabang wajib diisi',
            'nama.required' => 'nama wajib diisi',
            'merek.required' => 'merek wajib diisi',
            'jumlah.required' => 'jumlah wajib diisi',
            'harga.required' => 'harga wajib diisi',
        ]);

        $penyimpanan->update($request->all());
        $penyimpanan->update([ 'id_cabang' =>$request->cabang]);
        return redirect('admin/penyimpanan')->with('success', 'Edit Penyimpanan Sukses');
    }

    public function delete( $id){  
        $penyimpanan = Penyimpanan::findorfail($id)->delete();
        return redirect('admin/penyimpanan')->with('success', 'Hapus Penyimpanan Sukses');
    }
}
