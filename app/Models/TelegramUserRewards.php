<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TelegramUserRewards extends Model
{
    protected $fillable = [
        'UserID',
        'FromID',
        'Amount',
    ];

    use HasFactory;

    public function ReferralUser()
    {
        return $this->hasMany(TelegramUsers::class , 'UserID' , 'id');
    }
    public function ReferredUser()
    {
        return $this->hasMany(TelegramUsers::class , 'FromID' , 'id');
    }
}
