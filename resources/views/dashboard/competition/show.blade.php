@extends('templates.dashboard.template02-lateral-menu')

@section('page_content')
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">{{$titulo_secao}}</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->

        @if(session()->has('success'))
        <div class="row">
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    {{session('success')}}</a>.
                </div>
            </div>
            <!-- .panel-body -->
        </div>
        @endif

        @if(session()->has('errors'))
        <div class="row">
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    {{session('errors')}}</a>.
                </div>
            </div>
            <!-- .panel-body -->
        </div>
        @endif
        
        <div class="row">
            <div class="col-lg-5">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Dados
                    </div>                
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-12">
                                @if (isset($comp))
                                    <!--p> <b> Nome: </b> $comp->name_comp </p-->
                                    <p>
                                        <b>
                                            Tipo:
                                        </b> 
                                        @if ($comp->type_comp == 1)
                                            Estadual
                                        @endif
                                        @if ($comp->type_comp == 2)
                                            Regional
                                        @endif
                                        @if ($comp->type_comp == 3)
                                            Nacional
                                        @endif
                                        @if ($comp->type_comp == 4)
                                            Times Internacional
                                        @endif
                                        @if ($comp->type_comp == 5)
                                            Seleções
                                        @endif
                                    </p>
                                    <p>
                                        <b>
                                            Status:
                                        </b> 
                                        @if ($comp->status_comp == 1)
                                            <font color="green">Em Andamento</font>
                                        @elseif ($comp->status_comp == 2)
                                            <font color="red">Finalizado</font>
                                        @elseif ($comp->status_comp == 3)
                                            <font color="blue">Futuro</font>
                                        @endif
                                    </p>
                                @endif
                            </div>
                        </div>
                        
                        <div class="row">
                            <hr>
                            <div class="col-lg-12">
                                <form method="post" action="{{route('competition.destroy', $comp->id)}}">
                                    @method('DELETE')
                                    @csrf
                                    <center>
                                        <a href="{{route('competition.index')}}" class="btn btn-default"> Voltar  </a>
                                        <a href="{{route('competition.edit', $comp->id)}}" class="btn btn-warning"> Editar </a>
                                        <button type="submit" class="btn btn-danger" id="btn-apagar">Deletar</button>
                                    </center>
                                </form>
                            </div>
                        </div>
                        
                    </div> <!-- panel-body -->
                </div> <!-- panel panel-default -->
            </div> <!-- col-lg-6 -->

            <div class="col-lg-7">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Rodadas do Campeonato
                    </div>                
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="panel-group" id="accordion">
                                    @foreach($comp_rounds as $c)
                                        @if ($c->status_round2 == 1)
                                            <div class="panel panel-primary">
                                        @elseif ($c->status_round2 == 2)
                                            <div class="panel panel-green">
                                        @elseif ($c->status_round2 == 4)
                                            <div class="panel panel-red">
                                        @else
                                            <div class="panel panel-default">
                                        @endif
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse-{{$c->id}}">{{$c->name_round}}</a>
                                                </h4>
                                            </div>
                                            <div id="collapse-{{$c->id}}" class="panel-collapse collapse @if(session()->has('id_round_active') && session('id_round_active') == $c->id) in @endif">
                                                <div class="panel-body">
                                                    <i><b>Início em:</b> {{$c->dtinitdiplay}}</i><br/>
                                                    <i><b>Final em:</b> {{$c->dtfinishdiplay}}</i><br/><br/>
                                                    <div class="table-responsive">
                                                        <table class="table table-striped table-bordered table-hover">
                                                            <tbody>
                                                            @foreach($c->games as $g)
                                                                <tr>
                                                                    <td align='right'>{{$g->nome_mandante}}</td>
                                                                    <td align='center'>
                                                                        <b>
                                                                        @if(isset($g->placar_mandante) && isset($g->placar_visitante))
                                                                            <a data-toggle="modal" data-target="#myModal-{{$c->id}}-{{$g->id}}" class="btn btn-success btn-xs">
                                                                                {{ $g->placar_mandante }} x {{ $g->placar_visitante }}
                                                                        @else
                                                                            <a data-toggle="modal" data-target="#myModal-{{$c->id}}-{{$g->id}}" class="btn btn-warning btn-xs">
                                                                                - x -
                                                                        @endif
                                                                            </a>
                                                                        </b>
                                                                        <!-- Modal -->
                                                                        <div class="modal fade" id="myModal-{{$c->id}}-{{$g->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                                            <div class="modal-dialog">
                                                                                <div class="modal-content">
                                                                                    <div class="modal-header">
                                                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                                        <h4 class="modal-title" id="myModalLabel">Definir Placar</h4>
                                                                                    </div>
                                                                                    
                                                                                    <form method="post" action="{{route('game.update', $g->id)}}">
                                                                                        @method('PUT')
                                                                                        @csrf
                                                                                        <div class="modal-body">
                                                                                            <input type="hidden" value="{{$comp->id}}" name="id_competition">
                                                                                            <input type="hidden" value="{{$g->id_round}}" name="id_round">

                                                                                            <div class="row">
                                                                                                <div class="col-lg-5">
                                                                                                    <div class="form-group">
                                                                                                        <label>{{$g->nome_mandante}}</label>                                                                                    
                                                                                                        <select name="score1" class="form-control">
                                                                                                            <option value="0">0</option>
                                                                                                            <option value="1">1</option>
                                                                                                            <option value="2">2</option>
                                                                                                            <option value="3">3</option>
                                                                                                            <option value="4">4</option>
                                                                                                            <option value="5">5</option>
                                                                                                            <option value="6">6</option>
                                                                                                            <option value="7">7</option>
                                                                                                            <option value="8">8</option>
                                                                                                            <option value="9">9</option>
                                                                                                            <option value="10">10</option>
                                                                                                        </select>
                                                                                                    </div>
                                                                                                </div> <!-- col-lg-5 --> 
                                                                                                <div class="col-lg-2">
                                                                                                    <div class="form-group">
                                                                                                        <label></label>  
                                                                                                        <center>
                                                                                                            <button type="button" class="btn btn-primary btn-circle"><i class="fa fa-times"></i></button>
                                                                                                        </center>
                                                                                                    </div>
                                                                                                </div> <!-- col-lg-2 -->  
                                                                                                <div class="col-lg-5">
                                                                                                    <div class="form-group">
                                                                                                    <label>{{$g->nome_visitante}}</label>                                                                                    
                                                                                                        <select name="score2" class="form-control">
                                                                                                            <option value="0">0</option>
                                                                                                            <option value="1">1</option>
                                                                                                            <option value="2">2</option>
                                                                                                            <option value="3">3</option>
                                                                                                            <option value="4">4</option>
                                                                                                            <option value="5">5</option>
                                                                                                            <option value="6">6</option>
                                                                                                            <option value="7">7</option>
                                                                                                            <option value="8">8</option>
                                                                                                            <option value="9">9</option>
                                                                                                            <option value="10">10</option>
                                                                                                        </select>
                                                                                                    </div>
                                                                                                </div> <!-- col-lg-5 -->                           
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="modal-footer">
                                                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                                            <button type="submit" class="btn btn-success">Finalizar</button>
                                                                                        </div>
                                                                                    </form>
                                                                                </div>
                                                                                <!-- /.modal-content -->
                                                                            </div>
                                                                            <!-- /.modal-dialog -->
                                                                        </div>
                                                                        <!-- /.modal -->
                                                                    </td>
                                                                    <td>{{$g->nome_visitante}}</td>
                                                                    <td>
                                                                        @if(isset($g->placar_mandante) && isset($g->placar_visitante))
                                                                        <center> 
                                                                            <form method="post" action="{{route('game.processarpalpites', $g->id)}}">
                                                                                @method('PUT')
                                                                                @csrf
                                                                                <input type="hidden" value="{{$comp->id}}" name="id_competition">
                                                                                <button type="submit" class="btn btn-primary btn-xs">Processar</button> 
                                                                            </form>
                                                                        </center>
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <!-- /.table-responsive -->
                                                    <hr>
                                                    <center>
                                                        <!-- Button trigger modal -->
                                                        <a class="btn btn-primary" data-toggle="modal" data-target="#myModal-{{$c->id}}">
                                                            Nova Partida
                                                        </a>
                                                    </center>
                                                    <!-- Modal -->
                                                    <div class="modal fade" id="myModal-{{$c->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                    <h4 class="modal-title" id="myModalLabel">Inserir Partida</h4>
                                                                </div>
                                                                <form method="post" action="{{route('game.store')}}">
                                                                    <div class="modal-body">
                                                                        @csrf
                                                                        <input type="hidden" value="{{$c->id}}" name="id_round"> 
                                                                        <input type="hidden" value="{{$comp->id}}" name="id_competition">

                                                                        <div class="row">
                                                                            <div class="col-lg-5">
                                                                                <div class="form-group">
                                                                                    <label><center>Mandante:*</center></label>                                                                                    
                                                                                    <select name="id_team1"  class="form-control">
                                                                                    @foreach($teams as $t)
                                                                                        <option value="{{$t->id}}">
                                                                                            {{$t->name_team}}
                                                                                        </option>
                                                                                    @endforeach
                                                                                    </select>
                                                                                </div>
                                                                            </div> <!-- col-lg-5 --> 
                                                                            <div class="col-lg-2">
                                                                                <div class="form-group">
                                                                                    <label></label>  
                                                                                    <center>
                                                                                        <button type="button" class="btn btn-primary btn-circle"><i class="fa fa-times"></i></button>
                                                                                    </center>
                                                                                </div>
                                                                            </div> <!-- col-lg-2 -->  
                                                                            <div class="col-lg-5">
                                                                                <div class="form-group">
                                                                                    <label><center>Visitante:*</center></label>                                                                 
                                                                                    <select name="id_team2"  class="form-control">
                                                                                    @foreach($teams as $t)
                                                                                        <option value="{{$t->id}}">
                                                                                            {{$t->name_team}}
                                                                                        </option>
                                                                                    @endforeach
                                                                                    </select>  
                                                                                </div>
                                                                            </div> <!-- col-lg-5 -->                            
                                                                        </div>                                                                        
                                                                        <div class="row">
                                                                            <div class="col-lg-12">
                                                                                <div class="form-group">
                                                                                    <label><center>Data/Hora:*</center></label> 
                                                                                    <input type="datetime-local" name="game_ko" class="form-control"/>  
                                                                                </div> <!-- col-lg-12 -->  
                                                                            </div> 
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                        <button type="submit" class="btn btn-success">Inserir</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                            <!-- /.modal-content -->
                                                        </div>
                                                        <!-- /.modal-dialog -->
                                                    </div>
                                                    <!-- /.modal -->
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <hr>
                                <center>
                                    <!-- Button trigger modal -->
                                    <a class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                                        Nova Rodada
                                    </a>
                                </center>
                                <!-- Modal -->
                                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                <h4 class="modal-title" id="myModalLabel">Inserir Rodada</h4>
                                            </div>
                                            <form method="post" action="{{route('dashboard.round.store', $comp->id)}}">
                                                <div class="modal-body">
                                                    @csrf
                                                    <input type="hidden" value="{{$comp->id}}" name="id_competition">

                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <label>Nome da Rodada:*</label>
                                                                <input type="text" name="name_round" class="form-control" placeholder="Insira o Nome"/>
                                                            </div>
                                                        </div> <!-- col-lg-12 -->                                
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <label>Início da Rodada:*</label>
                                                                <input type="datetime-local" name="dtinitdisplay" class="form-control"/>
                                                            </div>
                                                        </div> <!-- col-lg-12 -->                                
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <label>Fim da Rodada:*</label>
                                                                <input type="datetime-local" name="dtfinishdisplay" class="form-control"/>
                                                            </div>
                                                        </div> <!-- col-lg-12 -->                                
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-success">Inserir</button>
                                                </div>
                                            </form>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                                <!-- /.modal -->
                            </div> <!-- col-lg-12 -->
                        </div> <!-- row -->
                    </div> <!-- panel-body -->
                </div> <!-- panel panel-default -->
            </div> <!-- col-lg-6 -->
            
        </div> <!-- row -->
        
    </div>
    <!-- /#page-wrapper -->
@endsection

@section('script_delete')
    <script type="text/javascript">
        $(document).ready(function(){
            $("#btn-apagar").click( function(event) {
                var apagar = confirm('Deseja mesmo excluir ?');
                if (apagar){
                // aqui vai a instrução para apagar registro			
                }else{
                    event.preventDefault();
                }	
            });
        });
    </script>
@endsection