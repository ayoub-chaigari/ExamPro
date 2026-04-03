<?php

namespace App\Imports;

use App\Models\Question;
use App\Models\Category;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Illuminate\Support\Facades\Auth;

class QuestionsImport implements ToModel, WithHeadingRow, WithValidation, SkipsEmptyRows
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Find or create category based on subject name
        $categoryName = trim($row['subject'] ?? 'Général');
        $category = Category::firstOrCreate(['name' => $categoryName]);

        // Map correct answer to original text if QCM and A,B,C,D provided
        $correctAnswer = trim($row['correct_answer']);
        $type = strtolower(trim($row['type'] ?? 'qcm'));

        if ($type === 'qcm') {
            $options = [
                'A' => trim($row['option_a'] ?? ''),
                'B' => trim($row['option_b'] ?? ''),
                'C' => trim($row['option_c'] ?? ''),
                'D' => trim($row['option_d'] ?? ''),
            ];
            
            // If correct_answer matches a key (A, B, C, D), use the value
            if (isset($options[strtoupper($correctAnswer)])) {
                $correctAnswer = $options[strtoupper($correctAnswer)];
            }
        }

        return new Question([
            'content'      => $row['question_text'],
            'type'         => $type,
            'category_id'  => $category->id,
            'option_a'     => $row['option_a'] ?? null,
            'option_b'     => $row['option_b'] ?? null,
            'option_c'     => $row['option_c'] ?? null,
            'option_d'     => $row['option_d'] ?? null,
            'correct_answer'=> $correctAnswer,
            'level'        => $row['level'] ?? 'facile',
            'created_by'   => Auth::id(),
        ]);
    }

    public function rules(): array
    {
        return [
            'question_text' => 'required|string',
            'type'          => 'required|in:qcm,true_false',
            'correct_answer'=> 'required',
            'subject'       => 'required|string',
        ];
    }
}
