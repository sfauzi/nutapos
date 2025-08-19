<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function hitungSaldo()
    {
        $saldoawal = 100000;

        $mutasi = [
            (object)["tanggal" => "2021-10-01", "masuk" => 200000, "keluar" => 0, "saldo" => 0],
            (object)["tanggal" => "2021-10-03", "masuk" => 300000, "keluar" => 0, "saldo" => 0],
            (object)["tanggal" => "2021-10-05", "masuk" => 150000, "keluar" => 0, "saldo" => 0],
            (object)["tanggal" => "2021-10-02", "masuk" => 0, "keluar" => 100000, "saldo" => 0],
            (object)["tanggal" => "2021-10-04", "masuk" => 0, "keluar" => 150000, "saldo" => 0],
            (object)["tanggal" => "2021-10-06", "masuk" => 0, "keluar" => 50000, "saldo" => 0],
        ];

        // Urutkan array berdasarkan tanggal
        usort($mutasi, function ($a, $b) {
            return strtotime($a->tanggal) <=> strtotime($b->tanggal);
        });

        //Hitung saldo akumulasi
        $saldo = $saldoawal;
        foreach ($mutasi as $m) {
            $saldo = $saldo + $m->masuk - $m->keluar;
            $m->saldo = $saldo;
        }

        // Return sebagai response Laravel (JSON)
        return response()->json([
            'saldo_awal' => $saldoawal,
            'mutasi' => $mutasi,
        ]);
    }
}
