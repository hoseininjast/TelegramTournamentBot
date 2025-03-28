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
        'Image',
        'WalletAddress',
        'TonWalletAddress',
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
    public function MyTournament($Mode)
    {
        $JoinedTournaments = UserTournaments::where('UserID' , $this->id)->get();

        $Tournaments = [];
        foreach ($JoinedTournaments as $jt) {
            if($jt->Tournament->Status == $Mode){
                $Tournaments[] = $jt->Tournament;
            }
        }

        return $Tournaments;

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


    public function WinnerPositionInTournament(Tournaments $Tournament)
    {
        $History = $Tournament->History;
        return array_keys($History->Winners, $this->id);
        /*        // get player position in the game
        $D = TournamentHistory::find(6);
        dd(array_keys($D->Winners, $PlayerID));*/
    }

    public function Referral()
    {
        return $this->hasOne(TelegramUsers::class , 'id' , 'ReferralID');
    }
    public function Referrals()
    {
        return $this->hasMany(TelegramUsers::class , 'ReferralID' , 'id');
    }

    public function ReferralPlanHistory()
    {
        return $this->hasMany(ReferralPlanHistory::class , 'UserID' , 'id');
    }


}
