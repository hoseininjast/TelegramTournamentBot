<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TournamentHistory extends Model
{
    protected $fillable = [
        'TournamentID',
        'Winners',
        'AwardsProof',
        'Image',
    ];
    use HasFactory;

    protected $casts = [
        'Winners' => 'array',
        'AwardsProof' => 'array',
    ];

    use HasFactory;


    public function Tournament()
    {
        return $this->hasOne(Tournaments::class , 'id' , 'TournamentID');
    }
}
