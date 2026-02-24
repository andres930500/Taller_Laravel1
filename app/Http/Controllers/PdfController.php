<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mpdf\Mpdf;

class PdfController extends Controller
{
    // Esta función genera el PDF de prueba
    public function generarPdf() {
        $mpdf = new Mpdf();
        $mpdf->WriteHTML('<h1>Hola Mundo</h1>');
        return $mpdf->Output();
    }

    // Esta función es la que procesará el formulario
    public function procesarTaller(Request $request) {
        $nombre = $request->input('nombre');
        $nota = $request->input('nota');

        $mpdf = new Mpdf();
        $html = "
            <h1 style='color:blue;'>Reporte del Taller</h1>
            <p><b>Estudiante:</b> $nombre</p>
            <p><b>Calificación:</b> $nota</p>
            <hr>
            <p>Generado exitosamente desde Laravel con Tailwind y mPDF.</p>
        ";
        
        $mpdf->WriteHTML($html);
        return $mpdf->Output('Reporte_Taller.pdf', 'I');
    }
}