<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Validasi dan hitung diskon kupon secara AJAX.
     * POST /coupon/apply
     */
    public function apply(Request $request)
    {
        $request->validate([
            'code'  => 'required|string|max:50',
            'total' => 'required|integer|min:0',
        ]);

        $code  = strtoupper(trim($request->code));
        $total = (int) $request->total;

        $coupon = Coupon::where('code', $code)->first();

        if (!$coupon) {
            return response()->json([
                'valid'   => false,
                'message' => 'Kode kupon tidak ditemukan.',
            ], 200);
        }

        $result = $coupon->validate($total);

        if (!$result['valid']) {
            return response()->json([
                'valid'   => false,
                'message' => $result['message'],
            ], 200);
        }

        return response()->json([
            'valid'       => true,
            'message'     => $result['message'],
            'code'        => $coupon->code,
            'type'        => $coupon->type,
            'value'       => $coupon->value,
            'discount'    => $result['discount'],
            'final_total' => max(0, $total - $result['discount']),
            'description' => $coupon->description,
        ]);
    }
}
