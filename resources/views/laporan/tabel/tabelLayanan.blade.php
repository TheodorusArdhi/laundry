<table class="table table-striped table-bordered table-hover me-2 " >
    <thead class="table-dark">
        @php
            $awal = Carbon\Carbon::createFromFormat('Y-m-d', $awal)->format('d-m-Y');
            $akhir = Carbon\Carbon::createFromFormat('Y-m-d', $akhir)->format('d-m-Y');
        @endphp
        <tr >
            <th class="text-center" colspan="4">Laporan Layanan {{ $awal }} - {{ $akhir }}</th>
        </tr>
        <tr>
            <th>Nama</th>
            <th>Harga</th>
            <th>Jumlah</th>
            <th>Pemasukan</th>                                          
        </tr>  
    </thead>
    <tbody >
        <?php
            $totalPemasukan = 0;
        ?>
        @foreach ($layananCount['layanan'] as $key => $value ) 
        <tr >                                       
            <th>{{$value -> nama}}</th>
            <th>{{rupiah($value -> harga)}}</th>
            @if ($value -> satuan == "kg")
                <th>{{$value -> jumlah}} Kg</th>
            @else
                <th>{{$value -> jumlah}}</th>
            @endif
            <th>{{rupiah($value -> pemasukan)}}</th>
        </tr>
        <?php
            $totalPemasukan += $value -> pemasukan;
        ?>
        @endforeach
        <tr class="table-secondary">
            <th colspan="3" class="text-center">Total Pemasukan</th>
            <th>{{rupiah($totalPemasukan)}}</th>
        </tr>
    </tbody>                            
</table>