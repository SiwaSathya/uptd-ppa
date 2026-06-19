<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\JenisKasus;
use App\Models\UndangUndang;
use App\Models\Faq;
use App\Models\Sop;
use App\Models\PanduanKeamanan;
use Illuminate\View\View;

class Knowledgepublik extends Controller
{
    public function index(): View
    {
        $jenisKasusList  = JenisKasus::all();
        $undangUndangList = UndangUndang::all();
        $faqList         = Faq::all();
        $sopList         = Sop::all();
        $panduanList     = PanduanKeamanan::all();

        return view('knowledgepublik', compact(
            'jenisKasusList', 'undangUndangList', 'faqList', 'sopList', 'panduanList'
        ));
    }
}