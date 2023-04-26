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
                        Listagem de Campeonatos
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>Campeonato</th>
                                    <!--th>Tipo</th-->
                                    <th>Em Andamento</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($comps as $c)
                                    <tr class="odd gradeX"> 
                                        <td> <a href="{{route('competition.show', $c->id)}}"> {{$c->name_comp}} </a> </td>
                                        <!--td> 
                                            <center>
                                                if(isset($c) && $c->type_comp == 1)
                                                    Estadual
                                                elseif(isset($c) && $c->type_comp == 2)
                                                    Regional
                                                elseif(isset($c) && $c->type_comp == 3)
                                                    Nacional
                                                elseif(isset($c) && $c->type_comp == 4)
                                                    Times-Internacional
                                                elseif(isset($c) && $c->type_comp == 5)
                                                    Seleções
                                                else
                                                    -
                                                endif
                                            </center)
                                        </td-->
                                        <td>
                                            <center>
                                                @if(isset($c) && $c->status_comp == 1) 
                                                    <font color="green"> Em Andamento </font>
                                                @elseif(isset($c) && $c->status_comp == 2)
                                                    <font color="red"> Finalizado </font>
                                                @elseif(isset($c) && $c->status_comp == 3)
                                                    <font color="blue"> Futuro
                                                @else
                                                    -
                                                @endif
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