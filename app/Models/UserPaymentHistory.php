<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPaymentHistory extends Model
{
    protected $fillable = [
        'UserID',
        'Description',
        'Amount',
        'Currency',
        'Type',
    ];


}
