<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Models\GameModel;

class GameController extends Controller
{
    private $games;
    public function __construct(GameModel $games) {
        $this->middleware('auth');
        $this->games = $games;
    }

    public function index()
    {
        /*Quando a pessoa atualizar o placar da partida, disparar evento para atualizar
             as pontuações dos palpites envolvidas*/
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $dataForm = $request->except(['_token']);

        $id_competition = $dataForm['id_competition'];
        $game_ko = $dataForm['game_ko'];
        
        $g = new GameModel;
        $g->id_round = $dataForm['id_round'];
        $g->id_team1 = $dataForm['id_team1'];
        $g->id_team2 = $dataForm['id_team2'];
        $g->status_game = 1;
        if (isset($game_ko)) {
            $g->game_ko  = Carbon::parse($game_ko)->format('Y-m-d H:i:s');
        } else {
            return back()->with(["errors" => "Insira o Horário da Partida", "id_round_active" => $g->id_round]);
        }

        //return $g->game_ko;

        if ($g->save()) {
            return redirect()->route('competition.show', $id_competition)->with(["id_round_active" => $g->id_round]);
        } else {
            return redirect()->route('competition.show', $id_competition)->with(["errors" => "Falha ao Cadastrar Partida", "id_round_active" => $g->id_round]);
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //Pegando os dados da requisição
        $dataForm = $request->except(['_token', '_method']);
        $id_round_active = $dataForm['id_round'];//

        //Busca o time no BD
        $game = $this->games->find($id);
        
        if (is_null($game)) {
            return redirect()
                ->route("competition.show", $dataForm['id_competition'])
                ->with([
                    "errors" => "Falha ao Editar", 
                    "id_round_active" => $id_round_active]);
        } else {
            //Editando partida no banco de dados
            $game->score1 = $dataForm['score1'];
            $game->score2 = $dataForm['score2'];
            
            $success = $this->games->where('id', $id)->update([
                'score1' => $dataForm['score1'], 
                'score2' => $dataForm['score2']
            ]);

            if ($success) {
                return redirect()
                    ->route("competition.show", $dataForm['id_competition'])
                    ->with([
                        "id_round_active" => $id_round_active]);
            } else {
                return redirect()
                    ->route("competition.show", $dataForm['id_competition'])
                    ->with([
                        "errors" => "Falha ao Editar", 
                        "id_round_active" => $id_round_active]);
            }
        }
    }

    public function destroy($id)
    {
        //
    }
}