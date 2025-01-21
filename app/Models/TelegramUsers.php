<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TelegramUsers extends Model
{

    protected $fillable = [
        'TelegramUserID',
        'TelegramChatID',
        'ReferralID',
        'FirstName',
        'LastName',
        'UserName',
        'WalletAddress',
        'Charge',
        'PlatoID',
        'PlatoScreenShot',
        'Status',
    ];

    use HasFactory;

    public function Tournaments()
    {
        return $this->hasMany(UserTournaments::class , 'UserID' , 'id');
    }

    public function TournamentsWon()
    {
        /*        // get player position in the game
        $D = TournamentHistory::find(6);
        dd(array_keys($D->Winners, $PlayerID));*/
        return TournamentHistory::all()->filter(function($tournament) {
            return in_array($this->id, $tournament->Winners) ? $tournament : null;
        });
    }

    public function Referral()
    {
        return $this->hasMany(TelegramUsers::class , 'id' , 'ReferralID');
    }


}
