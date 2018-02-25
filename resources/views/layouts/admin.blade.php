<!DOCTYPE html>
<html>
    <head>
        <title>Evaluation | @yield('title')</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

        <link rel="icon" href="{{ URL::asset('assets/image/icons/Evaluation.png') }}" />

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

    <body class="hold-transition skin-green-light sidebar-mini">
        <div class="wrapper">
            <header class="main-header">
                <!-- Logo -->
                <a href="index.php" class="logo">
                    <!-- mini logo for sidebar mini 50x50 pixels -->
                    <span class="logo-mini"><b>E</b></span>
                    <!-- logo for regular state and mobile devices -->
                    <span class="logo-lg"><b>Evaluation</b></span>
                </a>
                <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top">
                    <!-- Sidebar toggle button-->
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                        <span class="sr-only">Toggle navigation</span>
                    </a>
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <!-- User Account: style can be found in dropdown.less -->
                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <img src="{{ URL::asset('assets/image/avatar/AdminAvatar.jpg') }}" class="user-image" alt="User Image">
                                <span class="hidden-xs"></span>
                                </a>
                                <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header">
                                    <img src="{{ URL::asset('assets/image/avatar/AdminAvatar.jpg') }}" class="img-circle" alt="User Image" height="60" width="60">

                                    <p>
                                    
                                    </p>
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                    <a href="{{ URL::to('/user/profile') }}" class="btn btn-default btn-flat">Profile</a>
                                    </div>
                                    <div class="pull-right">
                                    <a href="{{ URL::to('/logout') }}" class="btn btn-default btn-flat">Sign out</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <!-- NAVBAR  -->

            <aside class="main-sidebar">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar light">
                    <!-- Sidebar user panel -->
                    <div class="user-panel">
                        <div class="pull-left image">
                            <img src="{{ URL::asset('assets/image/avatar/AdminAvatar.jpg') }}" img class="img-circle" height="65" width="65" id="user-pic" >
                        </div>
                        <div class="pull-left info">
                            <p></p>
                            <a href="{{ URL::to('/user/profile') }}">Administrator</a>
                        </div>
                    </div>
                    
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu">
                        <li class="header">MAIN NAVIGATION</li>
                        <li class="treeview">
                            <a href="{{ URL::to('/appraisers') }}">
                                <i class="fa fa-user"></i> <span>Appraiser</span>
                                <span class="pull-right-container">
                                </span>
                            </a>
                        </li>
                        <li class="treeview">
                            <a href="{{ URL::to('/housemodels') }}">
                                <i class="fa fa-home"></i> <span>House Model</span>
                                <span class="pull-right-container">
                                </span>
                            </a>
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-map"></i>
                                <span>Locations</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="{{ URL::to('/regions') }}"><i class="fa fa-circle-o"></i> Region</a></li>
                                <li><a href="{{ URL::to('/provinces') }}"><i class="fa fa-circle-o"></i> Province</a></li>
                                <li><a href="{{ URL::to('/cities') }}"><i class="fa fa-circle-o"></i> City / Municipality</a></li>
                                <li><a href="{{ URL::to('/barangays') }}"><i class="fa fa-circle-o"></i> Barangay</a></li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-laptop"></i>
                                <span>System Settings</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="{{ URL::to('/logos') }}"><i class="fa fa-circle-o"></i> Logo</a></li>
                                <li><a href="{{ URL::to('/covers') }}"><i class="fa fa-circle-o"></i> Cover</a></li>
                            </ul>
                        </li>
                        
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>
            <!-- SIDEBAR  -->

            <div class="content-wrapper">
                 @yield('content')
            </div>

            <footer class="main-footer">
                <div class="pull-right hidden-xs">
                <b>Version</b> 1.0
                </div>
                <strong>Copyright &copy; 2017 <a href="">Team Intern</a>.</strong> All rights reserved.
            </footer>
        </div>
        
        <script src="{{ URL::asset('assets/plugins/jQuery/jquery.min.js') }}"></script>
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