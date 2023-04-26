<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Models\RoundModel;

class RoundController extends Controller
{
    private $rounds;
    public function __construct(RoundModel $rounds) {
        $this->middleware('auth');
        $this->rounds = $rounds;
    }

    public function index()
    {
        //
    }

    public function create()
    {
        
    }

    public function store(Request $request)
    {
        $dataForm = $request->except(['_token']);
        $dtinitdisplay   = $dataForm['dtinitdisplay'];
        $dtfinishdisplay = $dataForm['dtfinishdisplay'];


        $r = new RoundModel;
        $r->id_competition = $dataForm['id_competition'];
        $r->name_round = $dataForm['name_round'];
        $r->status_round = 1;
        if (isset($dtinitdisplay) && isset($dtfinishdisplay)) {
            $r->dtinitdiplay   = Carbon::parse($dtinitdisplay)->format('Y-m-d H:i:s');
            $r->dtfinishdiplay = Carbon::parse($dtfinishdisplay)->format('Y-m-d H:i:s');
        } else {
            return redirect()->route('competition.show', $r->id_competition);
        }

        if ($r->save()) {
            return redirect()->route('competition.show', $r->id_competition);
        } else {
            return redirect()->route('competition.create-edit')->with(["errors" => "Falha ao Cadastrar"]);
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
        //
    }

    public function destroy($id)
    {
        //
    }
}