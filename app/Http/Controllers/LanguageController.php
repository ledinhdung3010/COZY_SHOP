<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stichoza\GoogleTranslate\GoogleTranslate;

class LanguageController extends Controller
{
    public function translate(Request $request)
    {
        $translator = new GoogleTranslate();

        // Lấy dữ liệu từ request

        $text = $request->text;
        // Dịch nội dung
        $translatedText = $translator->setSource('vi')->setTarget('en')->translate($text);
        dd($translatedText);
    }
}
