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
            
                @if(Auth::user()->type_user == 1)
                    <a class="navbar-brand" href="{{route('dashboard.index')}}">ADMIN - 352scores</a>
                @else
                    <a class="navbar-brand" href="{{route('game.index')}}">352scores</a>
                @endif
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        {{ Auth::user()->name }}
                        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#"><i class="fa fa-user fa-fw"></i> Meu Perfil </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}" id="dash_logout">
                                @csrf
                                <a href="#" onclick="document.getElementById('dash_logout').submit();"> 
                                    <i class="fa fa-sign-out fa-fw"></i> Logout
                                </a>
                            </form>
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
                        @if(Auth::user()->type_user == 1)
                            <li>
                                <a href="{{route('dashboard.index')}}"><i class="fa fa-dashboard fa-fw"></i>Página Inicial</a>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-tag fa-fw"></i>Times de Futebol<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="{{ route('team.index') }}">Exibir Times</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('team.create') }}">Criar Time</a>
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
                                        <a href="{{ route('competition.create')}}">Criar Campeonato</a>
                                    </li>
                                </ul>
                                <!-- /.nav-second-level -->
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-tag fa-fw"></i>Fantasy League<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="{{ route('fantasy_league.index') }}">Exibir Fantasy Leagues</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('fantasy_league.create')}}">Criar Fantasy League</a>
                                    </li>
                                </ul>
                                <!-- /.nav-second-level -->
                            </li>
                        @endif

                        @if(Auth::user()->type_user == 2)
                            <li>
                                <a href="{{route('game.index')}}"><i class="fa fa-dashboard fa-fw"></i>Página Inicial</a>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-tag fa-fw"></i>Minhas Ligas<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="{{ route('leagues.index') }}">Exibir Ligas</a>
                                    </li>
                                    <!--li>
                                        <a href="{{ route('leagues.create') }}">Criar Liga</a>
                                    </li-->
                                </ul>
                                <!-- /.nav-second-level -->
                            </li>
                        @endif
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