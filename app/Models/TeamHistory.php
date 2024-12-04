<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeamHistory extends Model
{
    public function oldTeam()
    {
        return $this->belongsTo(Team::class, 'old_team_id');
    }

    public function newTeam()
    {
        return $this->belongsTo(Team::class, 'new_team_id');
    }
}
