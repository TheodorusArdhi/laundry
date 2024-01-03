<table class="table table-striped table-bordered table-hover me-2 " >
    <thead class="table-dark" >
        @php
            $awal = Carbon\Carbon::createFromFormat('Y-m-d', $awal)->format('d-m-Y');
            $akhir = Carbon\Carbon::createFromFormat('Y-m-d', $akhir)->format('d-m-Y');
        @endphp
        <tr >
            <th class="text-center" colspan="6">Laporan Penjualan {{ $awal }} - {{ $akhir }}</th>
        </tr>
        <tr>
            <th>Nomor Transaksi</th>
            <th>Tanggal Masuk</th>
            <th>Total Harga</th>
            <th>Diskon</th>
            <th>Poin Keluar</th>
            <th>Total Tagihan</th>                                            
        </tr>  
    </thead>
    <tbody >
        <?php
            $totalTotalHarga = 0;
            $totalDiskon = 0;
            $totalPoin = 0;
            $totalTotalTagihan = 0;
        ?>
        @foreach ($penjualan as $item ) 
        <tr >                                       
            <th>{{$item -> no_transaksi}}</th>
            <th>{{$item -> tgl_masuk -> format('d-m-Y')}}</th>
            <th>{{rupiah($item -> total_harga)}}</th>
            @php
                $diskon = $item -> total_harga*$item -> diskon/100;
            @endphp
            @if ($item -> diskon == 0)
                <th>{{rupiah($item -> diskon)}}</th>
            @else
                <th>{{ rupiah($diskon) }}</th>
            @endif
            <th>{{rupiah($item -> poin_keluar)}}</th>
            <th>{{rupiah($item -> total_tagihan)}}</th>
        </tr>
        <?php
            $totalTotalHarga += $item -> total_harga;
            $totalDiskon += $diskon;
            $totalPoin += $item -> poin_keluar;
            $totalTotalTagihan += $item -> total_tagihan;
        ?>
        @endforeach
        <tr class="table-secondary">
            <th colspan="2" class="text-center">Total Keseluruhan</th>
            <th>{{rupiah($totalTotalHarga)}}</th>
            <th>{{rupiah($totalDiskon)}}</th>
            <th>{{rupiah($totalPoin)}}</th>
            <th>{{rupiah($totalTotalTagihan)}}</th>
        </tr>
    </tbody>                            
</table>