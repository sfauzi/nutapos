<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OjolRevenueController extends Controller
{
    public function hitungRevenue(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'harga_sebelum_markup' => 'required|numeric|min:0',
            'markup_persen' => 'required|numeric|min:0',
            'share_persen' => 'required|numeric|min:0|max:100',
        ]);

        $hargaSebelum = $validated['harga_sebelum_markup'];
        $markupPersen = $validated['markup_persen'];
        $sharePersen  = $validated['share_persen'];

        // Hitung harga setelah markup
        $hargaSetelahMarkup = $hargaSebelum + ($hargaSebelum * ($markupPersen / 100));

        // Hitung share untuk ojol
        $shareOjol = $hargaSetelahMarkup * ($sharePersen / 100);

        // Hitung net untuk resto
        $netResto = $hargaSetelahMarkup - $shareOjol;

        return response()->json([
            'net_untuk_resto' => round($netResto, 2),
            'share_untuk_ojol' => round($shareOjol, 2),
        ]);
    }
}
