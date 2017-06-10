<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title or "Software Gestão Odontológica" }}</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" href="{{ URL::asset('assets/css/css/bootstrap.min.css') }}" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <link href="{{ URL::asset('assets/css/font-awesome/css/font-awesome.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/css/css/animate.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/css/css/style.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="{{ URL::asset('assets/css/style.css') }}" />

    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>
<body>

    <div id="wrapper">
        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav metismenu" id="side-menu">
                    <li class="nav-header">
                        <div class="dropdown profile-element"> <span>
                            @if (Auth::guest())
                                <div><a href="{{ route('login') }}">Login</a></div>
                            @else
                                <div class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                        <span class="text-muted text-xs block">{{ Auth::user()->name }} <b class="caret"></span></b>
                                    </a>

                                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                                        <li>
                                            <a href="{{ route('logout') }}"
                                                onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                                                Logout
                                            </a>

                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                {{ csrf_field() }}
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            @endif
                        </div>
                    </li>
                    <li class="{{ ( Request::is('cadastro*') ? 'active' : '') }}">
                        <a href="index.html"><i class="fa fa-th-large"></i> 
                            <span class="nav-label">Cadastros</span> <span class="fa arrow"></span>
                        </a>
                        <ul class="nav nav-second-level collapse {{ ( Request::is('cadastro*') ? 'in' : '') }}">
                            <li class="{{ ( Request::is('cadastro/paciente*') ? 'active' : '') }}">
                                <a href="{{ route('paciente.index') }}">
                                    Paciente
                                </a>
                            </li>
                            <li class="{{ ( Request::is('cadastro/profissional*') ? 'active' : '') }}">
                                <a href="{{ route('profissional.index') }}">
                                    Profissional
                                </a>
                            </li>
                            <li class="{{ ( Request::is('cadastro/procedimento*') ? 'active' : '') }}">
                                <a href="{{ route('procedimento.index') }}">
                                    Procedimento
                                </a>
                            </li>
                            <li class="{{ ( Request::is('cadastro/agenda_profissional*') ? 'active' : '') }}">
                                <a href="{{ route('agenda_profissional.index') }}">
                                    Agenda Profissional
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="{{ ( Request::is('agenda/agenda_dia*') ? 'active' : '') }}">
                        <a href="{{ route('agenda_dia.index') }}">
                            <i class="fa fa-calendar"></i>     <span class="nav-label">  Agenda do dia </span>
                        </a>
                    </li>
                    <li class="{{ ( Request::is('atendimento*') ? 'active' : '') }}">
                        <a href="{{ route('atendimento.index') }}">
                            <i class="fa fa-clipboard"></i>     <span class="nav-label">  Atendimento </span>
                        </a>
                    </li>
                </ul>

            </div>
        </nav>

        <div id="page-wrapper" class='gray-bg'>
            @yield('content')
        </div>
    </div>

    <!-- Scripts -->
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    {{-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

    <!-- Mainly scripts -->
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    {{-- <script src="js/bootstrap.min.js"></script> --}}
    <script src="{{ asset('js/plugins/typehead/bootstrap3-typeahead.min.js') }}"></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
    <script src="{{ asset('js/plugins/dataTables/datatables.min.js')}}"></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>
    <script src="{{ asset('js/inspinia.js') }}"></script>
    <script src="{{ asset('js/jquery.mask.min.js')}}"></script>
    <script src="{{ asset('assets/js/js.js') }}"></script>
</body>
</html>
