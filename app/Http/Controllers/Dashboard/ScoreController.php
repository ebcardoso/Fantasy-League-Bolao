<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\GameModel;
use App\Models\ScoreModel;

class ScoreController extends Controller
{
    private $games;
    private $scores;
    public function __construct(GameModel $g, ScoreModel $s) {
        $this->middleware('auth');
        $this->games = $g;
        $this->scores = $s;
    }

    public function processarPalpites(Request $request, $id)
    {
        $dataForm = $request->except(['_token']);

        //Busca a partida que terá seus palpites processados
        $game = $this->games->find($id);

        //Busca os palpites relacionados à partida
        $scs = $this->scores->select('*')->where('id_game', $id)->get();

        foreach($scs as $s)
        {
            if (($s->score_1 == $game->score1) && ($s->score_2 == $game->score2))
            {  
                //10 Pontos - Acertou o (Placar da Partida)
                $s->type_score = 10;
            }
            elseif ($s->score_1 == $game->score1)
            {
                if (($game->score1 > $game->score2) && ($s->score_1 > $s->score_2))
                {
                    //6 Pontos - Acertou (Placar do Mandante) e (Mandante Vencedor)
                    $s->type_score = 6;
                } 
                elseif (($game->score1 > $game->score2) && ($s->score_1 < $s->score_2))
                {
                    //2 Pontos - Acertou só (Placar do Mandante)
                    $s->type_score = 2;
                }
                elseif (($game->score1 < $game->score2) && ($s->score_1 < $s->score_2))
                {
                    //6 Pontos - Acertou (Placar do Mandante) e (Mandante Perdedor)
                    $s->type_score = 6;
                }
                elseif (($game->score1 < $game->score2) && ($s->score_1 > $s->score_2))
                {
                    //2 Pontos - Acertou só (Placar do Mandante)
                    $s->type_score = 2;
                } else {
                    //2 Pontos - Acertou só (Placar do Mandante) e jogo deu empate
                    $s->type_score = 2;
                }
            }
            elseif ($s->score_2 == $game->score2) 
            {
                if (($game->score1 < $game->score2) && ($s->score_1 < $s->score_2))
                {
                    //6 Pontos - Acertou (Placar do Visitante) e (Visitante Vencedor)
                    $s->type_score = 6;
                }
                elseif (($game->score1 < $game->score2) && ($s->score_1 > $s->score_2))
                {
                    //2 Pontos - Acertou só (Placar do Visitante)
                    $s->type_score = 2;
                }
                elseif (($game->score1 > $game->score2) && ($s->score_1 > $s->score_2))
                {
                    //6 Pontos - Acertou (Placar do Visitante) e (Visitante Perdedor)
                    $s->type_score = 6;
                }
                elseif (($game->score1 > $game->score2) && ($s->score_1 < $s->score_2))
                {
                    //2 Pontos - Acertou só (Placar do Visitante)
                    $s->type_score = 2;
                } else {
                    //2 Pontos - Acertou só (Placar do Visitante) e jogo deu empate
                    $s->type_score = 2;
                }
            }  
            elseif (($game->score1 > $game->score2) && ($s->score_1 > $s->score_2))
            {
                //6 Pontos - Acertou só (Mandante Vencedor)
                $s->type_score = 4;
            }
            elseif (($game->score1 < $game->score2) && ($s->score_1 < $s->score_2))
            {
                //6 Pontos - Acertou só (Visitante Vencedor)
                $s->type_score = 4;
            }
            elseif (($game->score1 == $game->score2) && ($s->score_1 == $s->score_2))
            {
                //6 Pontos - Acertou só (Empate)
                $s->type_score = 4;
            } else {
                //Acertou Nada
                $s->type_score = 0;
            }
            $s->save();
        }

        return redirect()->route("competition.show", $dataForm['id_competition']);
    }
}