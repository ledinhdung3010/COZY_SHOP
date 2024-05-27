<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
class QrCodeController extends Controller
{
    public function generateQRCode()
    {
        $url = 'https://example.com'; // URL hoặc bất kỳ văn bản nào bạn muốn mã hóa
    
        $qrCode = QrCode::size(200)->generate($url);
        // Trả về view hiển thị mã QR
        return view('admin.qr_code', compact('qrCode'));
    }
}
