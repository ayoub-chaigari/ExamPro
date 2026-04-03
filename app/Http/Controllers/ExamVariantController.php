<?php

namespace App\Http\Controllers;

use App\Models\ExamVariant;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ExamVariantController extends Controller
{
    public function exportPdf(ExamVariant $variant)
    {
        $variant->load('exam.category', 'questions');

        $data = [
            'variant' => $variant,
            'exam' => $variant->exam,
            'questions' => $variant->questions,
        ];

        $pdf = Pdf::loadView('pdf.variant', $data);
        
        // Return downloaded or streamlined PDF
        return $pdf->stream('Examen_' . $variant->exam->title . '_Variante_' . $variant->name . '.pdf');
    }
}
