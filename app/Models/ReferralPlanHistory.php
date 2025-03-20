<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReferralPlanHistory extends Model
{
    protected $fillable = [
        'ReferralPlanID',
        'UserID',
    ];

    use HasFactory;

    public function ReferralPlan()
    {
        return $this->belongsTo(ReferralPlan::class , 'ReferralPlanID' , 'id');
    }
    public function User()
    {
        return $this->hasMany(TelegramUsers::class , 'id' , 'UserID');
    }
}
