<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TelegramUsers extends Model
{

    protected $fillable = [
        'TelegramUserID',
        'TelegramChatID',
        'FirstName',
        'LastName',
        'UserName',
        'WalletAddress',
        'PlatoID',
        'PlatoScreenShot',
        'Status',
    ];

    use HasFactory;

    public function Tournaments()
    {
        return $this->hasMany(UserTournaments::class , 'UserID' , 'id');
    }


}
