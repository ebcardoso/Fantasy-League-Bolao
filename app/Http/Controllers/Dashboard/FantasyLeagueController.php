<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FantasyLeagueModel;
use App\Models\FlJoinModel;
use App\Models\CompetitionModel;
use App\Models\User;

class FantasyLeagueController extends Controller
{
    private $fantasy;
    private $competitions;
    private $fl_join;
    private $usr;
    public function __construct(FantasyLeagueModel $f, CompetitionModel $c, FlJoinModel $fj, User $u) 
    {
        $this->middleware('auth');
        $this->fantasy = $f;
        $this->competitions = $c;
        $this->fl_join = $fj;
        $this->usr = $u;
    }    

    public function index()
    {
        $titulo = "ADM Fantasy Leagues";
        $titulo_secao = "Fantasy Leagues";

        $fl = $this->fantasy
                        ->select('fantasy_league.id as id',
                                 'fantasy_league.name_fl as name_fl',
                                 'fantasy_league.status_fl as status_fl',
                                 'competition.name_comp as name_comp')
                        ->join('competition', 'competition.id', '=', 'fantasy_league.id_competition')
                        ->orderBy('name_fl')->get();

        return view('dashboard/fantasy_league/index', compact('titulo', 'titulo_secao', 'fl'));
    }

    public function create()
    {
        $titulo = "ADM Fantasy Leagues";
        $titulo_secao = "Cadastrar Nova Fantasy League";
        $comps = $this->competitions->select('*')->orderBy('name_comp')->get();

        return view('dashboard/fantasy_league/create_edit', compact('titulo', 'titulo_secao', 'comps'));
    }

    public function store(Request $request)
    {
        $dataForm = $request->except(['_token']);

        //Inserindo a Liga no BD
        $c = new FantasyLeagueModel;
        $c->id_competition = $dataForm['id_competition'];
        $c->name_fl = $dataForm['name_fl'];
        $c->status_fl = 1;

        if ($c->save()) {
            return redirect()->route('fantasy_league.index');
        } else {
            return redirect()->route('fantasy_league.create-edit')->with(["errors" => "Falha ao Cadastrar"]);
        }
    }

    public function show($id)
    {
        $fl = $this->fantasy
                   ->select('fantasy_league.id as id',
                            'fantasy_league.name_fl as name_fl',
                            'fantasy_league.status_fl as status_fl',
                            'competition.name_comp as name_comp')
                   ->join('competition', 'competition.id', '=', 'fantasy_league.id_competition')
                   ->where('fantasy_league.id', $id)
                   ->orderBy('name_fl')
                   ->get();
        
        $fj = $this->fl_join
                        ->select(
                            'users.id as id',
                            'users.name as name',
                            'users.email as email',
                            'fl_join.is_admin as is_admin')
                        ->join('users', 'users.id', '=' ,'fl_join.id_users')
                        ->where('fl_join.id_fantasy_league', $id)
                        ->orderBy('users.name')
                        ->get();
                        
        $users = $this->usr
                        ->select(
                            'id as id', 
                            'name as name', 
                            'email as email')
                        ->where('type_user', 2)
                        ->orderBy('name')
                        ->get();

        $fl = $fl[0];

        if (is_null($fl)) {
            return redirect()->route('fantasy_league.index');
        } else {
            $titulo = "$fl->name_fl";
            $titulo_secao = "Liga: $fl->name_fl";
            
            return view('dashboard/fantasy_league/show', compact('titulo', 'titulo_secao', 'fl', 'fj', 'users'));
        }
    }

    public function edit($id)
    {
        $f = $this->fantasy->find($id);

        if (is_null($f)) {
            return redirect()->route('fantasy_league.index');
        } else {
            $titulo = "Editando: {$f->name_fl}";
            $titulo_secao = "Editando: {$f->name_fl}";
            return view('dashboard.fantasy_league.create_edit', compact('titulo', 'titulo_secao', 'f'));
        }
    }

    public function update(Request $request, $id)
    {
        //Busca a Liga no BD
        $fl = $this->fantasy->find($id);
        
        if (is_null($fl)) {
            return redirect()->route('fantasy_league.index');
        } else {
            //Editando no banco de dados
            $dataForm = $request->except(['_token', '_method']);
            $update = $this->fantasy->where('id', $id)->update($dataForm);
            
            if ($update) {
                return redirect()->route("fantasy_league.index");
            } else {
                return redirect()->route("fantasy_league.create_edit", $id)->with(["errors" => "Falha ao Editar"]);
            }
        }
    }

    public function destroy($id)
    {
        //Busca a Liga no BD
        $fl = $this->fantasy->find($id);

        if (is_null($fl)) {
            return redirect()->route('fantasy_league.index');
        } else {   
            //Apaga do BD
            $delete = $fl->delete();
            
            if ($delete) {
                return redirect()->route("fantasy_league.index");
            } else {
                return redirect()->route("fantasy_league.show", $id)->with(["errors" => "Falha ao Deletar"]);
            }
        }
    }

    public function addMemberToLeague(Request $request, $id)
    {
        $dataForm = $request->except(['_token']);

        $id_fantasy_league = $id;
        $id_users = $dataForm['id_users'];

        //Inserindo a Vínculo de Participação no BD
        $f = new FlJoinModel;
        $f->is_admin = 2; //Não é Admin
        $f->id_fantasy_league = $id_fantasy_league;
        $f->id_users = $id_users;
        $f->save();

        if ($f->save()) {
            return redirect()->route('fantasy_league.show', $id_fantasy_league);
        } else {
            return redirect()->route('fantasy_league.show', $id_fantasy_league)->with(["errors" => "Falha ao Cadastrar"]);
        }
    }
}