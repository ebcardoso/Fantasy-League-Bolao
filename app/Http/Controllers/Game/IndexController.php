<?php

namespace App\Http\Controllers\Game;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\CompetitionModel;
use App\Models\FlJoinModel;
use App\Models\GameModel;
use App\Models\ScoreModel;

class IndexController extends Controller
{
    private $competitions;
    private $fl_join;
    private $games;
    private $scores;
    public function __construct(CompetitionModel $c, FlJoinModel $fj, GameModel $g, ScoreModel $s) 
    {
        $this->middleware('auth');
        $this->competitions = $c;
        $this->fl_join = $fj;
        $this->games = $g;
        $this->scores = $s;
    }

    public function index()
    {
        $titulo = "352scores";
        $titulo_secao = "Meus Campeonatos";

        //Obtém os campeonatos relacionados às ligas que o usuário está participando
        $comp_join = $this->fl_join
                            ->select('fantasy_league.id_competition')
                            ->join('fantasy_league', 'fantasy_league.id', '=', 'fl_join.id_fantasy_league')
                            ->where('fl_join.id_users', Auth::user()->id)
                            ->get();

        //Obtém as rodadas dos campeonatos
        $comps = $this->competitions
                            ->select(
                                'round.id as id_round',
                                'round.name_round as name_round',
                                'competition.id as id_competition',
                                'competition.name_comp as name_comp')
                            ->join('round', 'round.id_competition', '=', 'competition.id')
                            ->whereIn('competition.id', $comp_join)
                            ->where('round.dtinitdiplay',   '<', Carbon::now('GMT-3'))
                            ->where('round.dtfinishdiplay', '>', Carbon::now('GMT-3'))
                            //->where('round.status_round', 2)
                            ->orderBy('name_comp')
                            ->get();

        //return($comps);

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
                                DB::raw('IF(game_ko > now(), 1, 2) as can_modify'))
                            ->join('team as t1', 'game.id_team1', '=', 't1.id')
                            ->join('team as t2', 'game.id_team2', '=', 't2.id')
                            ->join('score', 'score.id_game', '=', 'game.id')
                            ->where('game.id_round', $c->id_round)
                            ->where('score.id_users', Auth::user()->id)
                            ->orderBy('game.game_ko')
                            ->get();

            //Pega os ids das partidas que foram feitos palpites
            $aux_id_teams = [];
            foreach($c->games_cp as $sc) 
            {
                $aux_id_teams[] = $sc->id_game;
            }

            //Pegar as partidas que não foram feitos palpites
            $c->games = $this->games
                            ->select(
                                'game.id as id_game',
                                't1.name_team as nome_mandante',
                                't2.name_team as nome_visitante',
                                /*'game.score1 as placar_mandante',
                                'game.score2 as placar_visitante,'*/
                                DB::raw('IF(game_ko > now(), 1, 2) as can_modify'))
                            ->join('team as t1', 'game.id_team1', '=', 't1.id')
                            ->join('team as t2', 'game.id_team2', '=', 't2.id')
                            ->where('game.id_round', $c->id_round)
                            ->whereNotIn('game.id', $aux_id_teams)
                            ->orderBy('game.game_ko')
                            ->get();
        }
                    
        return view(
            'game/index',
            compact(
                'titulo',
                'titulo_secao',
                'comps'
            )
        );
    }

    public function makePalpite(Request $request) 
    {
        $dataForm = $request->except(['_token']);
        $id_competition  = $dataForm['id_competition'];
        $id_game  = $dataForm['id_game'];
        $score_1 = $dataForm['score1'];
        $score_2 = $dataForm['score2'];
        $id_users = Auth::user()->id;

        //Pesquisa se usuário palpitou em tal jogo
        $previous = $this->scores->select('*')->where('id_game', $id_game)->where('id_users', $id_users)->get();
        if (count($previous) > 0) { //Se houver palpites na mesma partida, são deletados.
            $delete = $this->scores->where('id_game', $id_game)->where('id_users', $id_users)->delete();
            if (!($delete)) {
                return redirect()
                    ->route('game.index')
                    ->with([
                        "errors" => "Falha ao Cadastrar Palpite!", 
                        "id_competition_active" => $id_competition]);
            }
        }

        $g = new ScoreModel;
        $g->id_game = $id_game;
        $g->id_users = $id_users;
        $g->score_1 = $score_1;
        $g->score_2 = $score_2;
        $g->type_score = 99; //valor default

        if ($g->save()) {
            return redirect()
                    ->route("game.index")
                    ->with([
                            "success" => "Palpite Inserido!", 
                            "id_competition_active" => $id_competition]);
        } else {
            return redirect()
                    ->route('game.index')
                    ->with([
                        "errors" => "Falha ao Cadastrar Palpite!", 
                        "id_competition_active" => $id_competition]);
        }
    }
}