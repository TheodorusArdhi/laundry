<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Controllers\TransaksiController;
use App\Models\Layanan;


class TransaksiDetailController extends Controller
{
    public function store(Request $request){  
        $request->validate([
            'layanan'=>'required',
            'jumlah'=>'required|gt:0',
        ], [
            'layanan.required' => 'layanan wajib diisi',
            'jumlah.required' => 'jumlah wajib diisi',
            'jumlah.gt' => 'jumlah terlalu sedikit',
        ]);

        $layanan = Layanan::where('id_layanan', $request['layanan'])->get();
        foreach ($layanan as $item){
            $id = $item->id_layanan;
            $nama = $item->name;
            $harga = $item->harga;
        }
        
        $subTotal = $request->jumlah * $harga;
        $no_transaksi = $request->no_transaksi;
        $id_transaksi = Transaksi::where('no_transaksi', $no_transaksi)->first()->id_transaksi;

        $detail = TransaksiDetail::where([
            ['id_transaksi', '=', $id_transaksi],
            ['id_layanan', '=', $id]
        ])->get();
       
        $transaksiDetail = [
            'id_transaksi' => $id_transaksi, 
            'id_layanan' => $request->layanan, 
            'jumlah' => $request->jumlah, 
            'harga' => $harga, 
            'subtotal' => $subTotal
        ];

        if (!$detail->isEmpty()){
            foreach ($detail as $details){
                if ($details->id_layanan == $id){
                    $update = [
                        'jumlah' => $details->jumlah + $request->jumlah,
                        'subtotal' => $details->subtotal + $subTotal,
                    ];
                    TransaksiDetail::findOrFail($details->id_transaksi_detail)->update($update);
                }else{
                    TransaksiDetail::create($transaksiDetail);
                }
            }
        }else{
            TransaksiDetail::create($transaksiDetail);
        }
        return redirect('admin/transaksi/create')->with('success', 'Tambah Layanan Sukses');   
    }

    public function storeEdit(Request $request, $id){  
        $request->validate([
            'layanan'=>'required',
            'jumlah'=>'required|gt:0',
        ], [
            'layanan.required' => 'layanan wajib diisi',
            'jumlah.required' => 'jumlah wajib diisi',
            'jumlah.gt' => 'jumlah terlalu sedikit',
        ]);

        $layanan = Layanan::where('id_layanan', $request['layanan'])->get();
        foreach ($layanan as $item){
            $id_layanan = $item->id_layanan;
            $nama = $item->name;
            $harga = $item->harga;
        }
        
        $subTotal = $request->jumlah * $harga;
        $no_transaksi = $request->no_transaksi;

        $detail = TransaksiDetail::where([
            ['id_transaksi', '=', $id],
            ['id_layanan', '=', $id_layanan]
        ])->get();
       
        $transaksiDetail = [
            'id_transaksi' => $id, 
            'id_layanan' => $request->layanan, 
            'jumlah' => $request->jumlah, 
            'harga' => $harga, 
            'subtotal' => $subTotal
        ];

        if (!$detail->isEmpty()){
            foreach ($detail as $details){
                if ($details->id_layanan == $id_layanan){
                    $update = [
                        'jumlah' => $details->jumlah + $request->jumlah,
                        'subtotal' => $details->subtotal + $subTotal,
                    ];
                    TransaksiDetail::findOrFail($details->id_transaksi_detail)->update($update);
                }else{
                    TransaksiDetail::create($transaksiDetail);
                }
            }
        }else{
            TransaksiDetail::create($transaksiDetail);
        }
        return redirect('admin/transaksi/'.$id.'/edit')->with('success', 'Tambah Layanan Sukses');   
    }

    public function update(Request $request, $id){  
        $transaksi = TransaksiDetail::where('id_transaksi_detail', $id)->first()->id_transaksi;
        
        if($request->jumlah == 0){
            TransaksiDetail::findOrFail($id)->delete();
            return redirect('admin/transaksi/create')->with('success', 'Edit Layanan Sukses');
        }
        $update = [
            'jumlah' => $request->jumlah,
            'subtotal' => $request->jumlah * $request->harga,
        ];
        TransaksiDetail::findOrFail($id)->update($update);
        return redirect('admin/transaksi/create')->with('success', 'Edit Layanan Sukses');
    }

    public function updateEdit(Request $request, $id){  
        $transaksi = TransaksiDetail::where('id_transaksi_detail', $id)->first()->id_transaksi;

        if($request->jumlah == 0){
            TransaksiDetail::findOrFail($id)->delete();
            return redirect('admin/transaksi/'.$transaksi.'/edit')->with('success', 'Edit Layanan Sukses');
        }
        $update = [
            'jumlah' => $request->jumlah,
            'subtotal' => $request->jumlah * $request->harga,
        ];
        TransaksiDetail::findOrFail($id)->update($update);
        return redirect('admin/transaksi/'.$transaksi.'/edit')->with('success', 'Edit Layanan Sukses');
    }

    public function delete($id){  
        TransaksiDetail::find($id)->delete();
        return redirect('admin/transaksi/create')->with('success', 'Hapus Layanan Sukses');
    }

    public function deleteEdit($id){  
        $transaksi = TransaksiDetail::where('id_transaksi_detail', $id)->first()->id_transaksi;
        TransaksiDetail::find($id)->delete();
        return redirect('admin/transaksi/'.$transaksi.'/edit')->with('success', 'Hapus Layanan Sukses');
    }
}
