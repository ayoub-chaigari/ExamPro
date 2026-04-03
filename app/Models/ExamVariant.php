<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamVariant extends Model
{
    protected $fillable = ['exam_id', 'name'];

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function questions()
    {
        return $this->belongsToMany(Question::class, 'variant_questions')->withPivot('order', 'shuffled_options', 'custom_text')->orderBy('pivot_order')->withTimestamps();
    }
}
