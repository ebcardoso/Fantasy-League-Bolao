<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CompetitionModel;

class CompetitionController extends Controller
{
    private $competitions;
    public function __construct(CompetitionModel $competitions) {
        //$this->middleware('auth');
        $this->competitions = $competitions;
    }

    public function index()
    {
        $titulo = "ADM Campeonatos";
        $titulo_secao = "Campeonatos";

        $comps = $this->competitions->all();

        return view('dashboard/competition/index', compact('titulo', 'titulo_secao', 'comps'));
    }

    public function create()
    {
        $titulo = "Dashboard Times";
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
            
            return view('dashboard/competition/show', compact('titulo', 'titulo_secao', 'comp'));
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
