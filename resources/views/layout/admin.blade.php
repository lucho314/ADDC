<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>ADDC  | Archivo Digital</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.5 -->


        <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{asset('css/font-awesome.css')}}">
        <!-- Theme style -->
        <link rel="stylesheet" href="{{asset('css/AdminLTE.min.css')}}">
                <!-- AdminLTE Skins. Choose a skin from the css/skins
             folder instead of downloading all of them to reduce the load. -->    


        <link rel="stylesheet" href="{{asset('css/_all-skins.min.css')}}">
        <link rel="stylesheet" href="{{asset('css/jquery.fancybox.css')}}">
        <link rel="stylesheet" href="{{asset('css/jquery.fancybox-buttons.css?v=1.0.5')}}">

        <link rel="apple-touch-icon" href="{{asset('img/apple-touch-icon.png')}}">
        <link rel="shortcut icon" href="{{asset('img/favicon.ico')}}">
        <link rel="stylesheet" href="{{asset('css/query.dataTables.min.css')}}">
        <link rel="stylesheet" href="{{asset('css/buttons.dataTables.min.css')}}">
        <link rel="stylesheet" href="{{asset('css/sweetalert.css')}}">

        <link href="/css/select2.min.css" rel="stylesheet">
        <link rel="stylesheet" href="{{asset('css/documento.css')}}">

    </head>
    <body class="hold-transition skin-blue sidebar-mini {{$min or ''}}">                
        <div>

            <header class="main-header">                    

                <!-- Logo -->
                <a href="index2.html" class="logo">
                    <!-- mini logo fo                        r sidebar mini 50x50 pixels -->
                    <span class="logo-mini"><b>AD</b>DC</span>
                    <!-- logo for regular state and mobile devices -->
                    <span class="logo-lg"><b>Archivo Digital</b></span>
                </a>

                <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top" role="navigation">
                    <!-- Sidebar toggle button-->
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                        <span class="sr-only">Navegación</span>
                    </a>
                    <!-- Navbar Right Menu -->
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <!-- Messages: style can be found in dropdown.less-->

                            <!-- User Account: style can be found in dropdown.less -->
                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <span class="hidden-xs">{{ auth::user()->nom_usuario}}</span>
                                </a>

                            </li>

                        </ul>
                    </div>

                </nav>
            </header>
            <!-- Left side column. contains the logo and sideba            r -->
            <aside class="main-sidebar">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->

                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu">
                        <li class="header"></li>

                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-book"></i>
                                <span>Documento</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                @if(auth()->user()->hasRoles(['admin','carga']))
                                <li>
                                    <a href="{{URL::action('DocumentoController@create')}}">
                                        <i class="fa fa-circle-o"></i> Carga
                                    </a>
                                </li>
                                @endif
                                @if(auth()->user()->hasRoles(['admin','corrector','validador']))
                                <li>
                                    <a href="{{URL::action('DocumentoController@viewListaDocumentosPendientes',0)}}">
                                        <i class="fa fa-circle-o"></i> Validacion de carga
                                    </a>
                                </li>
                                @endif
                                @if(auth()->user()->hasRoles(['admin','corrector']))
                                <li>
                                    <a href="{{URL::action('DocumentoController@viewListaDocumentosPendientes',1)}}">
                                        <i class="fa fa-circle-o"></i> Validaciones pendientes
                                    </a>
                                </li>
                                @endif
                                @if(auth()->user()->hasRoles(['carga']))
                                <li>
                                    <a href="{{URL::action('DocumentoController@viewListaDocumentosCargados')}}">
                                        <i class="fa fa-circle-o"></i> Documentos cargados
                                    </a>
                                </li>
                                @endif
                                <li>
                                    <a href="{{URL::action('DocumentoController@index')}}">
                                        <i class="fa fa-circle-o"></i> Busqueda
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @if(auth()->user()->hasRoles(['admin','carga']))
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-th-large"></i>
                                <span>Cajas</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">

                                <li>
                                    <a href="{{URL::action('CajaController@create')}}">
                                        <i class="fa fa-circle-o"></i> Nueva caja
                                    </a>
                                </li>
                                <li>
                                    <a href="{{URL::action('CajaController@index')}}">
                                        <i class="fa fa-circle-o"></i> Buscar caja
                                    </a>
                                </li>
                                <li>
                                    <a href="{{URL::action('CajaController@imprimirPendientes')}}" target="_blank">
                                        <i class="fa fa-circle-o"></i> Etiquetas Pendientes
                                    </a>
                                </li>

                            </ul>
                        </li>
                        @endif

                        @if(auth()->user()->hasRoles(['admin']))
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-user"></i>
                                <span>Usuarios</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="{{URL::action('Auth\RegisterController@showRegistrationForm')}}"><i class="fa fa-circle-o"></i> Nuevo usuario</a></li>
                                <li><a href="{{URL::action('UsuarioController@index')}}"><i class="fa fa-circle-o"></i> Lista</a></li>
                            </ul>
                        </li>
                        @endif
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-lock"></i>
                                <span>Mi cuenta</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <!--<li><a href="{{URL('/usuario/micuenta',auth()->user()->getAuthIdentifier())}}"><i class="fa fa-circle-o"></i>Datos de usuario</a></li>-->
                                <li>
                                    <a href="{{ url('/logout') }}"
                                       onclick="event.preventDefault();
                                               document.getElementById('logout-form').submit();"><i class="fa fa-circle-o"></i>Cerrar sesión</a>

                                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>

                            </ul>
                        </li>


                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>


            <!--Contenido-->
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">

                <!-- Main content -->
                <section class="content">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="box" style="background: rgba(120, 173, 204, 0.68);">
                                <!--<div class="box-header with-border">
                                <h3 class="box-title">Sistema de Ventas</h3>
                                <div class="box-tools pull-right">
                                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                
                                <button class="btn btn-box-tool" data-w                                                                                                                                                                                                        idget="remove"><i class="fa fa-times"                                                                                                                                                                                                        ></i></button>
                                                             </div>
                                </div>-->
                                <!-- /.box-header -->
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <!--Contenido-->
                                            @yield('contenido')
                                            <!--Fin Contenido-->
                                        </div>
                                    </div>


                                </div><!-- /.row -->
                            </div><!-- /.box-body -->
                        </div><!-- /.box -->
                    </div><!-- /.col -->
            </div><!-- /.row -->

        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->
    <!--Fin-Contenido-->
    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Version</b> 1.0
        </div>
        <strong>Copyright &copy;  2016 - 2017 <a href="http://www.ater.gob.ar/ater2/home.asp">ATER - Administradora Tributaria de Entre Ríos </a>.</strong> Todos los derechos reservados.
    </footer>

    <!-- jQuery 2.1.4 -->
    <script src="{{asset('js/jQuery-2.1.4.min.js')}}"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    <script src="{{asset('js/jquery.dataTables.min.js')}}"></script>

    <script src="{{asset('js/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('js/buttons.flash.min.js')}}"></script>
    <script src="{{asset('js/jszip.min.js')}}"></script>
    <script src="{{asset('js/pdfmake.min.js')}}"></script>
    <script src="{{asset('js/vfs_fonts.js')}}"></script>
    <script src="{{asset('js/buttons.html5.min.js')}}"></script>
    <script src="{{asset('js/buttons.print.min.js')}}"></script>

    <!-- AdminLTE App -->
    <script src="{{asset('js/app.min.js')}}"></script>

    <script src="{{asset('js/lightbox.js')}}"></script>
    <script src="{{asset('js/jquery.fancybox.js')}}"></script>
    <script src="{{asset('js/jquery.fancybox.pack.js')}}"></script>
    <script src="{{asset('js/jquery.fancybox-buttons.js?v=1.0.5')}}"></script>
    <script src="{{asset('js/sweetalert.min.js')}}"></script>
    <script src="{{asset('js/checks.js')}}"></script>
    <script src="{{asset('js/documento.js')}}"></script>
    <script src="{{asset('js/caja.js')}}"></script>
    <!-- Select2---->
    <script src="/js/select2.min.js"></script>
    <script type="text/javascript">
       $(document).ready(function () {
            $(".js-example-basic-single").select2(); });
    </script>

    @yield('script')
</body>
</html>