<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PajakController extends Controller
{
    public function hitungPajak(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'total' => 'required|numeric|min:0',
            'persen_pajak' => 'required|numeric|min:0',
        ]);

        $total = $validated['total'];
        $persenPajak = $validated['persen_pajak'];

        // Hitung Net Sales (Dasar Pengenaan Pajak)
        $netSales = $total / (1 + ($persenPajak / 100));

        // Hitung Pajak Rp
        $pajakRp = $total - $netSales;

        return response()->json([
            'net_sales' => round($netSales, 2),  // dibulatkan 2 angka desimal
            'pajak_rp' => round($pajakRp, 2)
        ]);
    }
}
