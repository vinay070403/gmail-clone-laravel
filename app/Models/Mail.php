<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mail extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'subject',
        'body',
        'is_favorite',
        'is_deleted'
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    // 🔑 Relationship with User via pivot
    public function users()
    {
        return $this->belongsToMany(User::class, 'mail_user')
            ->withPivot('folder', 'is_favorite', 'is_deleted')
            ->withTimestamps();
    }
}
