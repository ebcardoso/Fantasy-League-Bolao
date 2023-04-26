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
                        @if(isset($t))
                        <form method="post" action="{{route('team.update', $t->id)}}">
                            @method('PUT')
                        @else
                        <form method="post" action="{{route('team.store')}}">
                        @endif
                            @csrf
                            <div class="row">
                                <div class="col-lg-5">
                                    <div class="form-group">
                                        <label>Nome do Time:*</label>
                                        <input type="text" name="name_team" class="form-control" placeholder="Insira o Nome"
                                            value="@if(isset($t) && isset($t->name_team)){{$t->name_team}}@else{{old('name_team')}}@endif"
                                        >
                                    </div>
                                </div> <!-- col-lg-7 -->

                                <div class="col-lg-5">
                                    <div class="form-group">
                                        <label>Cidade do Time:*</label>
                                        <input type="text" name="city_team" class="form-control" placeholder="Insira a Cidade"
                                            value="@if(isset($t) && isset($t->city_team)){{$t->city_team}}@else{{old('city_team')}}@endif"
                                        >
                                    </div>
                                </div> <!-- col-lg-7 -->

                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label>Ativo?:*</label>
                                        <select name="team_status"  class="form-control">
                                            <option value="1" @if(isset($t) && $t->team_status == 1) selected @endif>
                                                Sim
                                            </option>
                                            <option value="0" @if(isset($t) && $t->team_status == 0) selected @endif>
                                                Não
                                            </option>
                                        </select>
                                    </div> <!-- form group -->
                                </div> <!-- col-lg-2 -->
                            </div>

                            <div class="row">
                                <hr>
                                <div class="col-lg-12">
                                    <button type="submit" class="btn btn-success">Finalizar</button>
                                    @if (isset($t))
                                    <a href="{{route('team.show', $t->id)}}" class="btn btn-danger">Voltar</a>
                                    @else
                                    <a href="{{route('team.index')}}" class="btn btn-danger">Voltar</a>
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