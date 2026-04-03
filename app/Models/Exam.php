<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $fillable = ['title', 'category_id', 'duration', 'created_by', 'type', 'niveau', 'module_no', 'bareme'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function questions()
    {
        return $this->belongsToMany(Question::class, 'exam_questions')->withPivot('order')->withTimestamps();
    }

    public function variants()
    {
        return $this->hasMany(ExamVariant::class);
    }

    public function sections()
    {
        return $this->hasMany(Section::class)->orderBy('order');
    }

    public function getTotalPointsAttribute()
    {
        return $this->sections->sum(fn($section) => $section->total_points);
    }
}
