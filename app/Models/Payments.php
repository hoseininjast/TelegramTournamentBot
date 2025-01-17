<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
    protected $fillable = [
        'OrderID',
        'PaymentID',
        'FiatAmount',
        'CryptoAmount',
        'PaymentMethod',
        'PayingAddress',
        'UserTransactionHash',
        'AdminTransactionHash',
        'Status',
        'UserID',
    ];
    use HasFactory;

    public function User()
    {
        return $this->belongsTo(TelegramUsers::class , 'UserID' , 'id');
    }
}
