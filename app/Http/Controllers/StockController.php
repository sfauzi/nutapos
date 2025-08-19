<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StockController extends Controller
{
    public function kartuStok()
    {
        // saldo awal
        $saldoAwalStok   = 0;
        $saldoAwalStokRp = 0;

        // data transaksi
        $kartuStok = [
            (object)["tanggal" => "2021-10-01", "masuk" => 10, "keluar" => 0, "saldoQty" => 0, "masukRp" => 10000, "keluarRp" => 0, "saldoRp" => 0],
            (object)["tanggal" => "2021-10-03", "masuk" => 45, "keluar" => 0, "saldoQty" => 0, "masukRp" => 36000, "keluarRp" => 0, "saldoRp" => 0],
            (object)["tanggal" => "2021-10-05", "masuk" => 40, "keluar" => 0, "saldoQty" => 0, "masukRp" => 35000, "keluarRp" => 0, "saldoRp" => 0],
            (object)["tanggal" => "2021-10-02", "masuk" => 0,  "keluar" => 5,  "saldoQty" => 0, "masukRp" => 0,     "keluarRp" => 0, "saldoRp" => 0],
            (object)["tanggal" => "2021-10-04", "masuk" => 0,  "keluar" => 40, "saldoQty" => 0, "masukRp" => 0,     "keluarRp" => 0, "saldoRp" => 0],
            (object)["tanggal" => "2021-10-06", "masuk" => 0,  "keluar" => 35, "saldoQty" => 0, "masukRp" => 0,     "keluarRp" => 0, "saldoRp" => 0],
        ];

        //  Urutkan berdasarkan tanggal
        usort($kartuStok, function ($a, $b) {
            return strtotime($a->tanggal) <=> strtotime($b->tanggal);
        });

        // Hitung akumulasi
        $saldoQty = $saldoAwalStok;
        $saldoRp  = $saldoAwalStokRp;

        foreach ($kartuStok as $row) {
            // hitung keluarRp berdasarkan saldo sebelumnya
            $keluarRp = 0;
            if ($row->keluar > 0 && $saldoQty > 0) {
                $hargaRata = $saldoRp / $saldoQty;
                $keluarRp  = $hargaRata * $row->keluar;
            }

            // update saldo
            $saldoQty = $saldoQty + $row->masuk - $row->keluar;
            $saldoRp  = $saldoRp + $row->masukRp - $keluarRp;

            // simpan hasil ke object
            $row->keluarRp = $keluarRp;
            $row->saldoQty = $saldoQty;
            $row->saldoRp  = $saldoRp;
        }

        //  Return response JSON
        return response()->json([
            'saldo_awal_qty' => $saldoAwalStok,
            'saldo_awal_rp'  => $saldoAwalStokRp,
            'kartu_stok'     => $kartuStok,
        ]);
    }
}
