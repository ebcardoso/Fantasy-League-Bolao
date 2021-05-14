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
        
        <div class="row">
            <div class="col-lg-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Dados de Cadastro
                    </div>                
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-12">
                                @if (isset($time))
                                    <p> <b> Nome: </b> {{ $time->name_team }} </p>
                                    <p> <b> Cidade: </b> {{ $time->city_team }} </p>
                                    <p>
                                        <b>
                                            Ativo:
                                        </b> 
                                        @if ($time->team_status == 1)
                                            <font color="green">SIM</font>
                                        @else
                                            <font color="red">NÃO</font>
                                        @endif
                                    </p>
                                @endif
                            </div>
                        </div>
                        
                        <div class="row">
                            <hr>
                            <div class="col-lg-12">
                                <form method="post" action="{{route('team.destroy', $time->id)}}">
                                    @method('DELETE')
                                    @csrf
                                    <a href="{{route('team.index')}}" class="btn btn-default"> Voltar  </a>
                                    <a href="{{route('team.edit', $time->id)}}" class="btn btn-warning"> Editar </a>
                                    <button type="submit" class="btn btn-danger" id="btn-apagar">Deletar</button>
                                </form>
                            </div>
                        </div>
                        
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