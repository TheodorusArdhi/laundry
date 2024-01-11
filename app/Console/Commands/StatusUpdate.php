<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Transaksi;
use Carbon\Carbon;
use App\Http\Controllers\WAController;

class StatusUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transaksi:statusUpdate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Transaksi Status Update';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $currentDate = Carbon::parse(now()->format('Y-m-d'));

        $statusProses = Transaksi::where('id_status_transaksi', 3)->get();
        foreach ($statusProses as $value){
            $transaksiDate = Carbon::parse($value->tgl_selesai);
            $hari = $currentDate->diffInDays($transaksiDate, false);
            if($hari <= 0){
                $transaksi = Transaksi::where('id_transaksi', $value->id_transaksi)->update(['id_status_transaksi' => 4]);
                $WA = new WAController;
                $WA->prosesSelesai($value->id_transaksi);
            }
            \Log::info($hari);
        }

        $statusProsesSelesai = Transaksi::where('id_status_transaksi', 4)->get();
        foreach ($statusProsesSelesai as $value){
            $date = Carbon::parse($value->tgl_selesai);
            $transaksiDate = Carbon::parse($date->addDays(14));
            $hari = $currentDate->diffInDays($transaksiDate, false);
            if($hari <= 0){
                Transaksi::where('id_transaksi', $value->id_transaksi)->update(['id_status_transaksi' => 5]);
                $WA = new WAController;
                $WA->hampirBatas($value->id_transaksi);
            }
            \Log::info($hari);
        }

        $statusHampirBatas = Transaksi::where('id_status_transaksi', 5)->get();
        foreach ($statusHampirBatas as $value){
            $transaksiDate = Carbon::parse($value->tgl_tenggat);
            $hari = $currentDate->diffInDays($transaksiDate, false);
            if($hari <= 0){
                Transaksi::where('id_transaksi', $value->id_transaksi)->update(['id_status_transaksi' => 6]);
                $WA = new WAController;
                $WA->lebihBatas($value->id_transaksi);
            }
            \Log::info($hari);
        }
    }
}
