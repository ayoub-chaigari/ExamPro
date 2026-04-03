<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'type', 'content', 'options', 'correct_answer',
        'option_a', 'option_b', 'option_c', 'option_d',
        'section_id', 'points', 'order', 'requires_answer_space', 'answer_space_size',
        'parent_id', 'created_by', 'level'
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    protected $casts = [
        'options' => 'array',
        'requires_answer_space' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function parent()
    {
        return $this->belongsTo(Question::class, 'parent_id');
    }

    public function subQuestions()
    {
        return $this->hasMany(Question::class, 'parent_id')->orderBy('order');
    }

    public function exams()
    {
        return $this->belongsToMany(Exam::class, 'exam_questions')->withPivot('order')->withTimestamps();
    }

    public function variants()
    {
        return $this->belongsToMany(ExamVariant::class, 'variant_questions')->withPivot('order', 'shuffled_options', 'custom_text')->withTimestamps();
    }

    public function textVariants()
    {
        return $this->hasMany(QuestionVariant::class);
    }
}
