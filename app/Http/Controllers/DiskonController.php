<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DiskonController extends Controller
{
    public function hitungDiskon(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'discounts' => 'required|array',
            'discounts.*.diskon' => 'required|numeric|min:0|max:100',
            'total_sebelum_diskon' => 'required|numeric|min:0',
        ]);

        $totalSebelumDiskon = $validated['total_sebelum_diskon'];
        $hargaSetelahDiskon = $totalSebelumDiskon;
        $totalDiskon = 0;

        //  Proses diskon bertingkat
        foreach ($validated['discounts'] as $d) {
            $diskonPersen = $d['diskon'];
            $diskonRp = $hargaSetelahDiskon * ($diskonPersen / 100);

            $totalDiskon += $diskonRp;
            $hargaSetelahDiskon -= $diskonRp;
        }

        return response()->json([
            'total_diskon' => round($totalDiskon, 2),
            'total_harga_setelah_diskon' => round($hargaSetelahDiskon, 2),
        ]);
    }
}
