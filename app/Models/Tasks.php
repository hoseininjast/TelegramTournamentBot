<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{

    protected $fillable = [
        'TaskID',
        'Name',
        'Description',
        'Image',
        'Category',
        'Condition',
        'Reward',
    ];


    use HasFactory;

    public function History()
    {
        return $this->hasMany(UserTasks::class , 'TaskID' , 'id');
    }
}
