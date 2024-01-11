<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Layanan;
use RealRashid\SweetAlert\Facades\Alert;
use Session;

class LayananController extends Controller
{
    public function index(){  
        $layanan = Layanan::all();
        $title = 'Yakin Hapus Layanan?';
        confirmDelete($title);
        return view('layanan.index', compact('layanan'));
    }

    public function create(){  
        return view('layanan.create');
    }

    public function store(Request $request){
        Session::flash('nama', $request->nama);
        Session::flash('harga', $request->harga);
        Session::flash('durasi', $request->durasi);
        Session::flash('satuan', $request->satuan);

        $request->validate([
            'nama'=>'required',
            'harga'=>'required',
            'durasi'=>'required',
            'satuan'=>'required',
        ], [
            'nama.required' => 'nama wajib diisi',
            'harga.required' => 'harga wajib diisi',
            'durasi.required' => 'durasi wajib diisi',
            'satuan.required' => 'satuan wajib diisi',
        ]);

        $layanan = new Layanan([
            'nama' => $request->nama,
            'harga' => $request->harga,
            'durasi' => $request->durasi,
            'satuan' => $request->satuan,
            'status' => "aktif"
        ]);
        $layanan->save();
        return redirect('owner/layanan')->with('success', 'Tambah Layanan Sukses');
    }

    public function edit($id){  
        $layanan = Layanan::findorfail($id);
        return view('layanan.edit', compact('layanan'));
    }

    public function update(Request $request, $id){  
        $layanan = Layanan::findorfail($id);
        $request->validate([
            'nama'=>'required',
            'harga'=>'required',
            'durasi'=>'required',
            'satuan'=>'required',

        ], [
            'nama.required' => 'nama wajib diisi',
            'harga.required' => 'harga wajib diisi',
            'durasi.required' => 'durasi wajib diisi',
            'satuan.required' => 'satuan wajib diisi',
        ]);

        $layanan->update($request->all());
        return redirect('owner/layanan')->with('success', 'Edit Layanan Sukses');
    }

    public function delete($id){  
        Layanan::find($id)->delete();
        return redirect('owner/layanan')->with('success', 'Hapus Layanan Sukses');
    }
}
