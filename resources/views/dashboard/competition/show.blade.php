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
                                @if (isset($comp))
                                    <p> <b> Nome: </b> {{ $comp->name_comp }} </p>
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
                                        @else
                                            <font color="red">Finalizado</font>
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
                                    <a href="{{route('competition.index')}}" class="btn btn-default"> Voltar  </a>
                                    <a href="{{route('competition.edit', $comp->id)}}" class="btn btn-warning"> Editar </a>
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