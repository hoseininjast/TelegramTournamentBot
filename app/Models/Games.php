<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Games extends Model
{
    protected $fillable = [
        'Name',
        'Description',
        'Image',
    ];

    public function Tournaments()
    {
        return $this->hasMany(Tournaments::class , 'GameID' , 'id');
    }

    use HasFactory;
}
