<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TeamModel;
use App\Models\CompetitionModel;
use App\Models\FantasyLeagueModel;
//use App\User;

class DashboardController extends Controller
{
    public function index() 
    {
        $titulo = "Dashboard Fantasy";
        $titulo_secao = "Dashboard";

        $n_users    = '';//count(User::all());
        $n_teams    = count(TeamModel::all());
        $n_comps    = count(CompetitionModel::all());
        $n_fantleag = count(FantasyLeagueModel::all());

        return view(
            'dashboard/index',
            compact(
                'titulo',
                'titulo_secao', 
                'n_users', 
                'n_teams', 
                'n_comps', 
                'n_fantleag'
            )
        );
    }
}