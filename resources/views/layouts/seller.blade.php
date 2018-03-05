<!DOCTYPE html>
<html>
    <head>
        <title>Evaluation | @yield('title')</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

        <link rel="icon" href="{{ URL::asset('assets/image/icons/Evaluation.png') }}" />
        @yield('style')
        <!-- Bootstrap 3.3.6 -->
        <link rel="stylesheet" href="{{ URL::asset('assets/bootstrap/css/bootstrap.min.css') }}">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{ URL::asset('assets/bootstrap/css/font-awesome.css') }}">
        <!-- Ionicons -->
        <link rel="stylesheet" href="{{ URL::asset('assets/bootstrap/css/ionicons.css') }}">

        <link rel="stylesheet" href="{{ URL::asset('assets/plugins/datepicker/datepicker3.css') }}">
        <!-- DataTables -->
        <link rel="stylesheet" href="{{ URL::asset('assets/plugins/datatables/dataTables.bootstrap.css') }}">
        <!-- Theme style -->
        <link rel="stylesheet" href="{{ URL::asset('assets/dist/css/AdminLTE.css') }}">
        <!-- AdminLTE Skins. Choose a skin from the css/skins folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="{{ URL::asset('assets/dist/css/skins/_all-skins.min.css') }}">

        <link rel="stylesheet" href="{{ URL::asset('assets/custom/style.css') }}">
        <meta name="csrf_token" content="{{ csrf_token() }}" />
        
    </head>

    <body class="skin-green layout-top-nav">
        <div class="wrapper">
            <header class="main-header">
                <nav class="navbar navbar-static-top">
                    <div class="container">
                        <div class="navbar-header">
                            <a href="{{URL::to('/dashboard')}}" class="navbar-brand">Evaluation System</a>
                        </div>
                        <div class="navbar-custom-menu">
                            <ul class="nav navbar-nav">
                                <li class="dropdown user user-menu">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                        <img src="{{ URL::asset('assets/image/avatar/AdminAvatar.jpg') }}" class="user-image" alt="User Image">
                                        <span class="hidden-xs">{{\Auth::user()->seller->first_name}} {{\Auth::user()->seller->last_name}}</span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li class="user-header">
                                        <img src="{{ URL::asset('assets/image/avatar/AdminAvatar.jpg') }}" class="img-circle" alt="User Image">
                                            <p>
                                            {{\Auth::user()->seller->first_name}} {{\Auth::user()->seller->last_name}} - Seller
                                            </p>
                                        </li>
                                        <li class="user-footer">
                                            <div class="pull-right">
                                                <a href="{{URL::to('/logout')}}" class="btn btn-default btn-flat">Sign out</a>
                                            </div>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </header>
            <div class="content-wrapper">
                @yield('content')
            </div>
            <footer class="main-footer" style="position:relative;bottom:0">
                <div class="pull-right hidden-xs">
                <b>Version</b> 1.0
                </div>
                <strong>Copyright &copy; 2018 <a href="">Evaluation System</a>.</strong> All rights reserved.
            </footer>
        </div>

        <!-- <footer class="footer">
            <div class="container">
              <span class="text-muted">Copyright &copy; eValuation System 2017</span>
            </div>
        </footer> -->
        
        <script src="{{ URL::asset('assets/plugins/jQuery/jquery-2.2.3.min.js') }}"></script>
        <!-- Bootstrap 3.3.6 -->
        <script src="{{ URL::asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>
        <!-- bootstrap datepicker -->
        <script src="{{ URL::asset('assets/plugins/datepicker/bootstrap-datepicker.js') }}"></script>
        <!-- DataTables -->
        <script src="{{ URL::asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ URL::asset('assets/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
        <!-- SlimScroll -->
        <script src="{{ URL::asset('assets/plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>
        <!-- FastClick -->
        <script src="{{ URL::asset('assets/plugins/fastclick/fastclick.js') }}"></script>
        <!-- AdminLTE App -->
        <script src="{{ URL::asset('assets/dist/js/app.min.js') }}"></script>
        <!-- AdminLTE for demo purposes -->
        <script src="{{ URL::asset('assets/dist/js/demo.js') }}"></script>
        <!-- page script -->
        <script src="{{ URL::asset('assets/bootstrap/js/validator.min.js') }}"></script>
        <!-- page script -->
        <script src="{{ URL::asset('assets/bootstrap/js/bootbox.min.js') }}"></script>
        @yield('script')

    </body>
    
</html>