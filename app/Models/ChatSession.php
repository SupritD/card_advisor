<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ChatSession extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'token', 'title', 'content'];

    public static function createForUser($user = null, $content)
    {
        $token = (string) Str::uuid();
        $title = substr((string) $content, 0, 50);

        return static::create(['user_id' => $user ? $user->id : null, 'token' => $token, 'title' => $title, 'content' => $content]);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function messages()
    {
        return $this->hasMany(ChatMessage::class)->orderBy('created_at', 'asc');
    }
}
