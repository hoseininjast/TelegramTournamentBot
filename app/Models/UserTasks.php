<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTasks extends Model
{
    protected $fillable = [
        'UserID',
        'TaskID',
    ];
    use HasFactory;

    public function Task()
    {
        return $this->belongsTo(Tasks::class , 'TaskID' , 'id');
    }
    public function User()
    {
        return $this->hasMany(TelegramUsers::class , 'id' , 'UserID');
    }


}
