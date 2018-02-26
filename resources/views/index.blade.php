<!DOCTYPE html>
<html lang="en">
    <head>
        <title>eValuation | @yield('title')</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <meta name="csrf_token" content="{{ csrf_token() }}" />
        <link rel="icon" href="{{ URL::asset('assets/image/icons/Evaluation.png') }}" />
        <link rel="stylesheet" href="{{ URL::asset('assets/bootstrap/css/bootstrap.css') }}">
        <link rel="stylesheet" href="{{ URL::asset('assets/bootstrap/css/font-awesome.css') }}">
        <link rel="stylesheet" href="{{ URL::asset('assets/bootstrap/css/ionicons.css') }}">
        <link rel="stylesheet" href="{{ URL::asset('assets/dist/css/AdminLTE.css') }}">
        <link rel="stylesheet" href="{{ URL::asset('assets/dist/css/skins/_all-skins.min.css') }}">
        <!-- <link rel="stylesheet" href="{{ URL::asset('assets/temp/css/sticky-footer.css') }}"> -->
        <style>

          .tagline-cover {
            background: url('../assets/temp/images/background/header_bg.png') no-repeat bottom center;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            background-size: cover;
            -o-background-size: cover;
          }
        </style>
        @yield('style')
        
    </head>
    <body>
      <div class="jumbotron tagline-cover text-center"  style="color:white;">
        <h1>E-VALUATION SYSTEM</h1>
        <p>Let's build your dream house together</p> 
      </div>

      <!-- <nav class="navbar navbar-expand-lg navbar-light bg-faded py-lg-4">
        <div class="container">
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav mx-auto">
              <li class="nav-item px-lg-4">
                <a class="nav-link text-uppercase text-expanded" href="/">Home</a>
              </li>
              <li class="nav-item px-lg-4">
                <a class="nav-link text-uppercase text-expanded" href="/find_property">Find Property</a>
              </li>
              <li class="nav-item px-lg-4">
                <a class="nav-link text-uppercase text-expanded" href="/sell_property">Sell Property</a>
              </li>
              @if(!\Auth::user())
              <li class="nav-item px-lg-4">
                <a class="nav-link text-uppercase text-expanded" href="/login">Login / Register</a>
              </li>
              @endif
            </ul>
          </div>
        </div>
      </nav> -->

      <div class="container">
        @yield('content')
      </div>
      <footer class="footer">
        <div class="container">
          <span class="text-muted">Copyright &copy; Evaluation System 2018</span>
        </div>
      </footer>

    </body>

    

    <script src="{{ URL::asset('assets/jquery/jquery.min.js') }}"></script>
    <script src="{{ URL::asset('assets/temp/js/popper.min.js') }}"></script>
    <script src="{{ URL::asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>
    @yield('script')

</html>


