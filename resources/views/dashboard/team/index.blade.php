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
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Listagem de Times de Futebol
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Cidade</th>
                                    <th>Ativo</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($times as $t)
                                    <tr class="odd gradeX"> 
                                        <td> {{$t->name_team}} </td>
                                        <td> {{$t->city_team}} </td>
                                        @if(isset($t) && $t->team_status == 0)
                                        <td> <center> <font color="red"> NÃO </font> </center> </td>
                                        @endif
                                        @if(isset($t) && $t->team_status == 1)
                                        <td> <center> <font color="green"> SIM </font> </center> </td>
                                        @endif
                                        <td>
                                            <center>
                                                <a href="{{route('team.show', $t->id)}}">Mostrar</a>
                                            </center>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!-- /.table-responsive -->
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        
    </div>
    <!-- /#page-wrapper -->
@endsection

@section('script_table')
    <!-- DataTables JavaScript -->
    <script src="{{url('vendor/datatables/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{url('vendor/datatables-plugins/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{url('vendor/datatables-responsive/dataTables.responsive.js')}}"></script>       

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
    </script>
@endsection