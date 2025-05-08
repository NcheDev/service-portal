<?php
namespace App\Http\Controllers;
use Barryvdh\DomPDF\Facade\Pdf;


use Illuminate\Http\Request;

class DocumentationController extends Controller
{
    public function show()
    {
        return view('user.documentation');
    }

    public function downloadPdf()
    {
        $pdf = Pdf::loadView('user.documentation');
        return $pdf->download('Qualification_Documentation.pdf');
    }
}
