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
        
        @if (isset($errors) && count($errors) > 0)
            @foreach($errors->all() as $err)
                <div class="alert alert-danger alert-dismissable">
                    {{$err}}
                </div>
            @endforeach
        @endif     
        
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Preencha os Dados Corretamente
                        <br/>
                        <i>*Campos Obrigatórios</i>
                    </div>     

                    <div class="panel-body">                            
                        @if(isset($comp))
                        <form method="post" action="{{route('competition.update', $comp->id)}}">
                            @method('PUT')
                        @else
                        <form method="post" action="{{route('competition.store')}}">
                        @endif
                            @csrf
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Nome do Campeonato:*</label>
                                        <input type="text" name="name_comp" class="form-control" placeholder="Insira o Nome"
                                            value="@if(isset($comp) && isset($comp->name_comp)){{$comp->name_comp}}@else{{old('name_comp')}}@endif"
                                        >
                                    </div>
                                </div> <!-- col-lg-6 -->

                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label>Tipo:*</label>
                                        <select name="type_comp"  class="form-control">
                                            <option value="1" @if(isset($comp) && $comp->type_comp == 1) selected @endif>
                                                Estadual
                                            </option>
                                            <option value="2" @if(isset($comp) && $comp->type_comp == 2) selected @endif>
                                                Regional
                                            </option>
                                            <option value="3" @if(isset($comp) && $comp->type_comp == 3) selected @endif>
                                                Nacional
                                            </option>
                                            <option value="4" @if(isset($comp) && $comp->type_comp == 4) selected @endif>
                                                Times-Internacional
                                            </option>
                                            <option value="5" @if(isset($comp) && $comp->type_comp == 5) selected @endif>
                                                Seleções
                                            </option>
                                        </select>
                                    </div> <!-- form group -->
                                </div> <!-- col-lg-4 -->

                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label>Status?:*</label>
                                        <select name="status_comp"  class="form-control">
                                            <option value="3" @if(isset($comp) && $comp->status_comp == 3) selected @endif>
                                                Futuro
                                            </option>
                                            <option value="1" @if(isset($comp) && $comp->status_comp == 1) selected @endif>
                                                Em Andamento
                                            </option>
                                            <option value="2" @if(isset($comp) && $comp->status_comp == 2) selected @endif>
                                                Finalizado
                                            </option>
                                        </select>
                                    </div> <!-- form group -->
                                </div> <!-- col-lg-5 -->
                            </div>

                            <div class="row">
                                <hr>
                                <div class="col-lg-12">
                                    <button type="submit" class="btn btn-success">Finalizar</button>
                                    @if (isset($t))
                                    <a href="{{route('competition.show', $comp->id)}}" class="btn btn-danger">Voltar</a>
                                    @else
                                    <a href="{{route('competition.index')}}" class="btn btn-danger">Voltar</a>
                                    @endif
                                </div> <!-- col-lg-6 -->
                            </div> <!-- row -->
                        </form>
                    </div> <!-- panel-body -->
                </div> <!-- panel panel-default -->
            </div> <!-- col-lg-12 -->
        </div> <!-- row -->       
    </div>
    <!-- /#page-wrapper -->
@endsection