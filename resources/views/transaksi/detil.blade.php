{{--  @include('sweetalert::alert')  --}}
<table class="table table-bordered table-hover ">
    <thead class="fw-semibold">
        <tr>
            <th style="font-weight: 600 !important;">No</th>
            <th style="font-weight: 600 !important;">Layanan</th>
            <th style="font-weight: 600 !important;">Harga</th>
            <th style="font-weight: 600 !important;">Jumlah</th>
            <th style="font-weight: 600 !important;">Subtotal</th>                                      
        </tr>  
    </thead>
    <?php
        $i=1;
    ?>
    <tbody >
        @forelse ($detail as $item)
        <tr>
            <td>{{ $i++ }}</td>
            <td>{{ $item -> layanan -> nama }}</td>
            <td>{{ rupiah($item -> harga) }}</td>
            <td>{{ $item -> jumlah }}</td>
            <td>{{ rupiah($item -> subtotal) }}</td>
        </tr>
        @empty
            <tr>
                <td class="text-center" colspan="6">Data tidak ditemukan</td>
            </tr>
        @endforelse 
    </tbody>                          
</table>