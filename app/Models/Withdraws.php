<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Withdraws extends Model
{
    protected $fillable = [
        'WithdrawID',
        'Amount',
        'PayingAddress',
        'UserTransactionHash',
        'Status',
        'UserID',
    ];
    use HasFactory;


    public function User()
    {
        return $this->belongsTo(TelegramUsers::class , 'UserID' , 'id');
    }
}
