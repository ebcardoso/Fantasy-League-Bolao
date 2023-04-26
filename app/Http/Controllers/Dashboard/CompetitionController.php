<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\CompetitionModel;
use App\Models\RoundModel;
use App\Models\GameModel;
use App\Models\TeamModel;

class CompetitionController extends Controller
{
    private $competitions;
    private $rounds;
    private $games;
    private $teams;
    public function __construct(CompetitionModel $competitions, RoundModel $rounds, GameModel $games, TeamModel $teams) {
        $this->middleware('auth');
        $this->competitions = $competitions;
        $this->rounds = $rounds;
        $this->games = $games;
        $this->teams = $teams;
    }

    public function index()
    {
        $titulo = "ADM Campeonatos";
        $titulo_secao = "Campeonatos";

        $comps = $this->competitions->select('*')->orderBy('name_comp')->get();

        return view('dashboard/competition/index', compact('titulo', 'titulo_secao', 'comps'));
    }

    public function create()
    {
        $titulo = "ADM Campeonatos";
        $titulo_secao = "Cadastrar Novo Campeonato";

        return view('dashboard/competition/create_edit', compact('titulo', 'titulo_secao'));
    }

    public function store(Request $request)
    {
        $dataForm = $request->except(['_token']);

        //cria o log da inserção
        $c = new CompetitionModel;
        $c->name_comp = $dataForm['name_comp'];
        $c->type_comp = $dataForm['type_comp'];
        $c->status_comp = $dataForm['status_comp'];

        if ($c->save()) {
            return redirect()->route('competition.index');
        } else {
            return redirect()->route('competition.create-edit')->with(["errors" => "Falha ao Cadastrar"]);
        }
    }

    public function show($id)
    {
        $comp = $this->competitions->find($id);

        if (is_null($comp)) {
            return redirect()->route('competition.index');
        } else {
            $titulo = "Campeonato: {$comp->name_comp}";
            $titulo_secao = "Campeonato: {$comp->name_comp}";

            $comp_rounds = $this->rounds->select(
                                            'id', 
                                            'id_competition', 
                                            'name_round',
                                            'status_round',
                                            'dtinitdiplay',
                                            'dtfinishdiplay',
                                            DB::raw(
                                            'CASE  
                                                WHEN (dtinitdiplay > now()) 
                                                    THEN 1
                                                WHEN (now() > dtinitdiplay && now() < dtfinishdiplay) 
                                                    THEN 2    
                                                ELSE 4
                                             END as status_round2'))
                                ->where('id_competition', $comp->id)
                                ->orderBy('id', 'desc')
                                ->get();
            
            foreach ($comp_rounds as $c) {
                $c->games = $this->games->select('game.id as id',
                                                 'game.id_round as id_round',
                                                 't1.name_team as nome_mandante',
                                                 't2.name_team as nome_visitante',
                                                 'game.score1 as placar_mandante',
                                                 'game.score2 as placar_visitante')
                            ->join('team as t1', 'game.id_team1', '=', 't1.id')
                            ->join('team as t2', 'game.id_team2', '=', 't2.id')
                            ->where('game.id_round', $c->id)
                            ->orderBy('game.game_ko') //, 'desc')
                            ->get();
            }

            $teams = $this->teams->orderBy('name_team')->get();
            
            return view(
                'dashboard/competition/show',
                compact('titulo', 
                        'titulo_secao', 
                        'comp', 
                        'comp_rounds',
                        'teams'
                )
            );
        }
    }

    public function edit($id)
    {
        $comp = $this->competitions->find($id);

        if (is_null($comp)) {
            return redirect()->route('competition.index');
        } else {
            $titulo = "Editando: {$comp->name_comp}";
            $titulo_secao = "Editando: {$comp->name_comp}";
            return view('dashboard.competition.create_edit', compact('titulo', 'titulo_secao', 'comp'));
        }
    }

    public function update(Request $request, $id)
    {
        //busca o capeonato no BD
        $comp = $this->competitions->find($id);
        
        if (is_null($comp)) {
            return redirect()->route('competition.index');
        } else {
            //editando no banco de dados
            $dataForm = $request->except(['_token', '_method']);
            $update = $this->competitions::where('id', $id)->update($dataForm);
            
            if ($update) {
                return redirect()->route("competition.index");
            } else {
                return redirect()->route("competition.create_edit", $id)->with(["errors" => "Falha ao Editar"]);
            }
        }
    }

    public function destroy($id)
    {
        //busca o campeonato
        $comp = $this->competitions->find($id);

        if (is_null($comp)) {
            return redirect()->route('competition.index');
        } else {   
            //apaga do BD
            $delete = $comp->delete();
            
            if ($delete) {
                return redirect()->route("competition.index");
            } else {
                return redirect()->route("competition.show", $id)->with(["errors" => "Falha ao Deletar"]);
            }
        }
    }
}