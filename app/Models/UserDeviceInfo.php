<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDeviceInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'device',
        'browser',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
