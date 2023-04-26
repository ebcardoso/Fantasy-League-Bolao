<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TeamModel;

class TeamController extends Controller
{
    public function __construct(/*GameModel $games*/) {
        $this->middleware('auth');
        //$this->games = $games;
    }

    public function index()
    {
        $titulo = "ADM Times";
        $titulo_secao = "Times";

        $times = TeamModel::all();

        return view('dashboard/team/index', compact('titulo', 'titulo_secao', 'times'));
    }

    public function create()
    {
        $titulo = "ADM Times";
        $titulo_secao = "Cadastrar Novo Time";

        return view('dashboard/team/create_edit', compact('titulo', 'titulo_secao'));
    }

    public function store(Request $request)
    {
        $dataForm = $request->except(['_token']);

        //cria o log da inserção
        $t = new TeamModel;
        $t->name_team = $dataForm['name_team'];
        $t->city_team = $dataForm['city_team'];
        $t->team_status = $dataForm['team_status'];

        if ($t->save()) {
            return redirect()->route('team.index');
        } else {
            return redirect()->route('team.create-edit')->with(["errors" => "Falha ao Cadastrar"]);
        }
    }

    public function show($id)
    {
        $time = TeamModel::find($id);

        if (is_null($time)) {
            return redirect()->route('team.index');
        } else {
            $titulo = "Time: {$time->name_team}";
            $titulo_secao = "Time: {$time->name_team}";
            
            return view('dashboard/team/show', compact('titulo', 'titulo_secao', 'time'));
        }
    }

    public function edit($id)
    {
        $t = TeamModel::find($id);

        if (is_null($t)) {
            return redirect()->route('team.index');
        } else {
            $titulo = "Editando: {$t->name_team}";
            $titulo_secao = "Editando: {$t->name_team}";
            return view('dashboard.team.create_edit', compact('titulo', 'titulo_secao', 't'));
        }
    }

    public function update(Request $request, $id)
    {
        //busca o time no BD
        $time = TeamModel::find($id);
        
        if (is_null($time)) {
            return redirect()->route('teams.index');
        } else {
            //editando no banco de dados
            $dataForm = $request->except(['_token', '_method']);
            $update = TeamModel::where('id', $id)->update($dataForm);
            
            if ($update) {
                return redirect()->route("team.index");
            } else {
                return redirect()->route("team.create_edit", $id)->with(["errors" => "Falha ao Editar"]);
            }
        }
    }

    public function destroy($id)
    {
        //busca o time
        $t = TeamModel::find($id);

        if (is_null($t)) {
            return redirect()->route('team.index');
        } else {   
            //apaga do BD
            $delete = $t->delete();
            
            if ($delete) {
                return redirect()->route("team.index");
            } else {
                return redirect()->route("team.show", $id)->with(["errors" => "Falha ao Deletar"]);
            }
        }
    }
}