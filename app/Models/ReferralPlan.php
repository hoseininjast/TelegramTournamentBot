<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReferralPlan extends Model
{
    protected $fillable = [
        'Name',
        'Description',
        'Image',
        'Level',
        'Count',
        'Award',
    ];

    use HasFactory;

    public function History()
    {
        return $this->hasMany(ReferralPlanHistory::class , 'ReferralPlanID' , 'id');
    }
}
