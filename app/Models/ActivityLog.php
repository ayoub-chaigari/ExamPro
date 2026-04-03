<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = ['user_id', 'action', 'description'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Helper to quickly log an action from anywhere in the app.
     */
    public static function log(string $action, string $description, ?int $userId = null): void
    {
        static::create([
            'user_id'     => $userId ?? auth()->id(),
            'action'      => $action,
            'description' => $description,
        ]);
    }
}
