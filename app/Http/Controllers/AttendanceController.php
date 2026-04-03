<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AttendanceController extends Controller
{
     public function scan(Request $request)
    {
        $qrData = $request->qr;

        return response()->json([
            'message' => 'Scanned: ' . $qrData
        ]);
    }
}
