{{--  @include('sweetalert::alert')  --}}
<table class="table table-bordered table-hover ">
    <thead>
        <tr>
            <th style="font-weight: 600 !important;">No</th>
            <th style="font-weight: 600 !important;">Layanan</th>
            <th style="font-weight: 600 !important;">Harga</th>
            <th style="font-weight: 600 !important;">Jumlah</th>
            <th style="font-weight: 600 !important;">Subtotal</th>
            <th style="font-weight: 600 !important;">Aksi</th>                                        
        </tr>  
    </thead>
    <?php
        $i=1;
    ?>
    <tbody >
        @forelse ($detail as $item)
        <tr>
            <form method="POST" action="{{ url('admin/transaksi/detail/'.$item->id_transaksi_detail.'/edit/update') }}">
                @csrf
                <input type="hidden" name="harga" value="{{ $item -> harga }}">
                <td>{{ $i++ }}</td>
                <td>{{ $item -> layanan -> nama }}</td>
                <td>{{ rupiah($item -> harga) }}</td>
                <td><input type="number" step="any" id="jumlah" class="form-control" name="jumlah" value="{{ $item -> jumlah }}"</td>
                <td>{{ rupiah($item -> subtotal) }}</td>
                <td>
                    <button type="submit" class="btn btn-laundry btn-block" data-toggle="tooltip" data-placement="top" title="Edit Layanan"><i class="fa-solid fa-pen"></i></button>
                    <a class="btn btn-danger" href={{ url('admin/transaksi/detail/'. $item->id_transaksi_detail.'/edit/delete') }} data-confirm-delete="true"><i class="fa-solid fa-trash"></i></a>
                    {{--  <a class="btn btn-danger" href={{ url('admin/transaksi/detail/'. $item->id_transaksi_detail.'/delete') }} data-confirm-delete="true" role="button" data-toggle="tooltip" data-placement="top" title="Hapus Layanan"><i class="fa-solid fa-trash"></i></a>  --}}
                </td>
            </form>
        </tr>
        @empty
            <tr>
                <td class="text-center" colspan="6">Data tidak ditemukan</td>
            </tr>
        @endforelse 
    </tbody>                          
</table>

