<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'reset_token',
        'reset_token_expiry',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'reset_token',
    ];

    protected $casts = [
        'reset_token_expiry' => 'datetime',
    ];

    // 🔑 Relationship with Mail via pivot
    public function mails()
    {
        return $this->belongsToMany(Mail::class, 'mail_user')
            ->withPivot('folder', 'is_favorite', 'is_deleted')
            ->withTimestamps();
    }
}
