<?php

namespace App\Http\Controllers\Game;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\FantasyLeagueModel;
use App\Models\FlJoinModel;
use App\Models\User;
use App\Models\CompetitionModel;
use App\Models\GameModel;

class FantasyLeagueController extends Controller
{
    private $fantasy;
    private $fl_join;
    private $usr;
    private $competitions;
    private $games;
    public function __construct(FlJoinModel $fj, FantasyLeagueModel $f, User $u, CompetitionModel $c, GameModel $g) 
    {
        $this->middleware('auth');
        $this->fantasy = $f;
        $this->fl_join = $fj;
        $this->usr = $u;
        $this->competitions = $c;
        $this->games = $g;
    }

    public function index()
    {
        $titulo = "352scores";
        $titulo_secao = "Minhas Ligas";

        $fl = $this->fantasy
                   ->select('fantasy_league.id as id',
                            'fantasy_league.name_fl as name_fl',
                            'fantasy_league.status_fl as status_fl',
                            'competition.name_comp as name_comp')
                   ->join('competition', 'competition.id', '=', 'fantasy_league.id_competition')
                   ->join('fl_join', 'fl_join.id_fantasy_league', '=', 'fantasy_league.id')
                   ->where('fl_join.id_users', Auth::user()->id)
                   ->orderBy('fantasy_league.name_fl')
                   ->get();

        return view('game/leagues/index', compact('titulo', 'titulo_secao', 'fl'));
    }

    public function create()
    {
        $titulo = "ADM Fantasy Leagues";
        $titulo_secao = "Cadastrar Nova Fantasy League";
        $comps = $this->competitions->select('*')->orderBy('name_comp')->get();

        return view('dashboard/fantasy_league/create_edit', compact('titulo', 'titulo_secao', 'comps'));
    }

    public function show($id)
    {
        //Pega as Informações da Liga
        $fl = $this->fantasy
                   ->select('fantasy_league.id as id',
                            'fantasy_league.name_fl as name_fl',
                            'fantasy_league.status_fl as status_fl',
                            'competition.name_comp as name_comp')
                   ->join('competition', 'competition.id', '=', 'fantasy_league.id_competition')
                   ->where('fantasy_league.id', $id)
                   ->orderBy('name_fl')
                   ->get();
        $fl = $fl[0];
        
        //Pega os Participantes da Liga
        $fj = $this->fl_join
                        ->select(
                            'users.id as id_users',
                            'users.name as name',
                            /*'users.email as email',
                            'fl_join.is_admin as is_admin',*/
                            DB::raw('sum( score.type_score ) as points'),
                            DB::raw('COUNT(CASE WHEN score.type_score = 10 THEN 1 END) as p10'),
                            DB::raw('COUNT(CASE WHEN score.type_score = 6 THEN 1 END) as p6'),
                            DB::raw('COUNT(CASE WHEN score.type_score = 4 THEN 1 END) as p4'),
                            DB::raw('COUNT(CASE WHEN score.type_score = 2 THEN 1 END) as p2')
                        )
                        ->join('users', 'users.id', '=' ,'fl_join.id_users')
                        ->join('score', 'score.id_users', '=', 'users.id')
                        ->join('fantasy_league', 'fantasy_league.id', '=', 'fl_join.id_fantasy_league')
                        ->join('competition', 'competition.id', '=', 'fantasy_league.id_competition')
                        ->join('round', 'competition.id', '=', 'round.id_competition')
                        ->join('game', function($join) {
                            $join->on('round.id', '=', 'game.id_round');
                            $join->on('score.id_game', '=', 'game.id');
                        })
                        ->where('fl_join.id_fantasy_league', $id)
                        ->where('score.type_score', '<>', 99)
                        ->groupBy('users.id')
                        ->groupBy('users.name')
                        ->orderBy('points', 'desc')
                        ->orderBy('p10', 'desc')
                        ->orderBy('p6', 'desc')
                        ->orderBy('p4', 'desc')
                        ->get();

        //Para os Resultados das Rodadas Anteriores
        $comps = $this->competitions
                        ->select(
                            'round.id as id_round',
                            'round.name_round as name_round',
                            'competition.id as id_competition',
                            'competition.name_comp as name_comp'
                        )
                        ->join('round', 'round.id_competition', '=', 'competition.id')
                        ->join('fantasy_league', 'fantasy_league.id_competition', '=', 'competition.id')
                        ->where('fantasy_league.id', $id)
                        ->where('round.dtinitdiplay', '<', Carbon::now())
                        //->where('round.status_round', '<>', 1)
                        //->where('round.status_round', '<>', 2)
                        ->orderBy('round.dtinitdiplay', 'desc')
                        ->get();
        //return $comps;
        
        foreach ($comps as $c) 
        {
            //Pegar as partidas nas quais foram feitos palpites
            $c->games_cp = $this->games
                            ->select(
                                'game.id as id_game',
                                'score.id as id_score',
                                't1.id as id_mandante',
                                't2.id as id_visitante',
                                't1.name_team as nome_mandante',
                                't2.name_team as nome_visitante',
                                'score.score_1 as placar_mandante',
                                'score.score_2 as placar_visitante',
                                'score.type_score as type_score')
                            ->join('team as t1', 'game.id_team1', '=', 't1.id')
                            ->join('team as t2', 'game.id_team2', '=', 't2.id')
                            ->join('score', 'score.id_game', '=', 'game.id')
                            ->where('game.id_round', $c->id_round)
                            ->where('score.id_users', Auth::user()->id)
                            ->orderBy('game.game_ko')
                            //->orderBy('t1.name_team')
                            ->get();
            //return $c->games_cp;
        }

        if (is_null($fl)) {
            return redirect()->route('fantasy_league.index');
        } else {
            $titulo = "$fl->name_fl";
            $titulo_secao = "Liga: $fl->name_fl";
            
            return view('game/leagues/show', compact('titulo', 'titulo_secao', 'fl', 'fj', 'comps'));
        }
    }

    public function showMember($id, $id_users) {        
        //Pegar o nome da liga
        $league_data = $this->fantasy->find($id);
        if(!is_null($league_data)) {
            $name_league = $league_data->name_fl;
        }

        //Pegar o nome do usuário
        $user_data = $this->usr->find($id_users);
        if(!is_null($user_data)) {
            $name_user = $user_data->name;
        }

        //Definindo os títulos da página
        $titulo = "352scores";
        $titulo_secao = "$name_league: $name_user";

        //Para os Resultados das Rodadas Anteriores
        $comps = $this->competitions
                        ->select(
                            'round.id as id_round',
                            'round.name_round as name_round',
                            'competition.id as id_competition',
                            'competition.name_comp as name_comp'
                        )
                        ->join('round', 'round.id_competition', '=', 'competition.id')
                        ->join('fantasy_league', 'fantasy_league.id_competition', '=', 'competition.id')
                        ->where('fantasy_league.id', $id)
                        ->where('round.dtinitdiplay', '<', Carbon::now())
                        //->where('round.status_round', '<>', 1)
                        //->where('round.status_round', '<>', 2)
                        ->orderBy('round.dtinitdiplay', 'desc')
                        ->get();
        //return $comps;
        
        foreach ($comps as $c) 
        {
            //Pegar as partidas nas quais foram feitos palpites
            $c->games_cp = $this->games
                            ->select(
                                'game.id as id_game',
                                'score.id as id_score',
                                't1.id as id_mandante',
                                't2.id as id_visitante',
                                't1.name_team as nome_mandante',
                                't2.name_team as nome_visitante',
                                'score.score_1 as placar_mandante',
                                'score.score_2 as placar_visitante',
                                'score.type_score as type_score')
                            ->join('team as t1', 'game.id_team1', '=', 't1.id')
                            ->join('team as t2', 'game.id_team2', '=', 't2.id')
                            ->join('score', 'score.id_game', '=', 'game.id')
                            ->where('game.id_round', $c->id_round)
                            ->where('score.id_users', $id_users)
                            ->where('game.game_ko', '<', Carbon::now('GMT-3')) //pegar apenas as partidas que já iniciaram
                            ->orderBy('game.game_ko')
                            //->orderBy('t1.name_team')
                            ->get();
            //return $c->games_cp;
        }

        return view('game/leagues/showmember',
            compact(
                'titulo',
                'titulo_secao',
                'comps',
                'id'
            )
        );
    }
}