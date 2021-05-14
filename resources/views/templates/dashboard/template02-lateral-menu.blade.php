@extends('templates.dashboard.template01-dashboard-primary')

@section('content_secondary')
    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{url('dashboard')}}">FANTASY LEAGUE - ADMIN</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <!--  Auth::user()->name }} --> 
                        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#"><i class="fa fa-user fa-fw"></i> Meu Perfil </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <i class="fa fa-sign-out fa-fw"></i> Logout
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li>
                            <a href="{{url('dashboard')}}"><i class="fa fa-dashboard fa-fw"></i>Página Inicial</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-tag fa-fw"></i>Times de Futebol<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{{ route('team.index') }}">Exibir Times</a>
                                </li>
                                <li>
                                    <a href="{{ route('team.create') }}">Novo Time</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-tag fa-fw"></i>Campeonatos<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{{ route('competition.index') }}">Exibir Campeonatos</a>
                                </li>
                                <li>
                                    <a href="{{ route('competition.create')}}">Novo Campeonato</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        @yield('page_content')

    </div>
    <!-- /#wrapper -->
@endsection