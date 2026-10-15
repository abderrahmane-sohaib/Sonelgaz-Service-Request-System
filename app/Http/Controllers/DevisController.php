<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\View;

class DevisController extends Controller
{
    public function pdf_dash()
    {
        
        return view('devis.pdf');
    }
}
