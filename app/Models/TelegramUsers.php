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
        'KryptoArenaID',
        'Image',
        'Bio',
        'Country',
        'City',
        'WalletAddress',
        'Charge',
        'KAT',
        'PlatoID',
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
    public function JoinedTournamentsWithGame($GameID)
    {
        $JoinedTournaments = UserTournaments::where('UserID' , $this->id)->get();

        $Tournaments = [];
        foreach ($JoinedTournaments as $jt) {
            if($jt->Tournament->GameID == $GameID){
                $Tournaments[] = $jt->Tournament;
            }
        }

        return $Tournaments;

    }
    public function JoinedTournaments(): array
    {
        $JoinedTournaments = UserTournaments::where('UserID' , $this->id)->get();

        $Tournaments = [];
        foreach ($JoinedTournaments as $jt) {
            $Tournaments[] = $jt->Tournament;
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


    public function TournamentsWonWithGame(int $GameID)
    {

        $W = TournamentHistory::whereHas('Tournament' , function ($q) use ($GameID) {
            $q->where('GameID', '=', $GameID);
        })->get();
        return $W->filter(function($tournament) {
            return in_array($this->id, $tournament->Winners) ? $tournament : null;
        });


    }

    public function Stars()
    {
        return $this->hasMany(UserStars::class , 'UserID' , 'id');
    }


    public function WinnerPositionInTournament(TournamentHistory $Tournament)
    {
        $History = $Tournament;
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
    public function PaymentHistory()
    {
        return $this->hasMany(UserPaymentHistory::class , 'UserID' , 'id');
    }


}
