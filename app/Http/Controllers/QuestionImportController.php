<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\QuestionsImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;

class QuestionImportController extends Controller
{
    public function show()
    {
        return view('questions.import');
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:10240',
        ]);

        try {
            Excel::import(new QuestionsImport, $request->file('file'));
            
            return redirect()->route('questions.index')
                ->with('success', 'Les questions ont été importées avec succès !');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
             $failures = $e->failures();
             $errors = [];
             
             foreach ($failures as $failure) {
                 $errors[] = "Ligne {$failure->row()}: " . implode(', ', $failure->errors());
             }
             
             return back()->withErrors($errors)->withInput();
        } catch (\Exception $e) {
            Log::error('Erreur d\'importation Excel: ' . $e->getMessage());
            return back()->with('error', 'Une erreur est survenue lors de l\'importation. Vérifiez le format de votre fichier.');
        }
    }
}
