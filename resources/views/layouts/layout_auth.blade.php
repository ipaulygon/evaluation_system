<!DOCTYPE html>
<html lang="en">
    <head>
        <title>eValuation | @yield('title')</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="{{ URL::asset('assets/temp/image/icons/logo.png') }}" />
        
        <link rel="stylesheet" href="{{ URL::asset('assets/temp/css/bootstrap.min.css') }}">

        
        <link rel="stylesheet" href="{{ URL::asset('assets/temp/css/sticky-footer.css') }}">

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

      <div class="container">
        @yield('content')
      </div>

    </body>
    <footer class="footer">
      <div class="container">
        <span class="text-muted">Copyright &copy; eValuation System 2017</span>
      </div>
    </footer>

    <script src="{{ URL::asset('assets/temp/js/jquery.min.js') }}"></script>
    <script src="{{ URL::asset('assets/temp/js/popper.min.js') }}"></script>
    <script src="{{ URL::asset('assets/temp/js/bootstrap.min.js') }}"></script>
    @yield('script')

</html>


