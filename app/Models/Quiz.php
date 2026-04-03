<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'duration', 'code', 'created_by', 'is_active'];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function questions()
    {
        return $this->belongsToMany(Question::class, 'quiz_questions')->withPivot('order')->withTimestamps();
    }

    public function answers()
    {
        return $this->hasMany(StudentAnswer::class);
    }
}
