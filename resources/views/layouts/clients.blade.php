<!DOCTYPE html>
<html>
<head>
	<title>{{ env('APP_NAME') }}-Users</title>
	<script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="icon" href="{{asset('images/u2.png')}}" type="image/png">
  <!-- Fonts -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
  <!-- Icons -->
  <link rel="stylesheet" href="{{asset('assets/vendor/nucleo/css/nucleo.css')}}" type="text/css">
  <link rel="stylesheet" href="{{asset('assets/vendor/@fortawesome/fontawesome-free/css/all.min.css')}}" type="text/css">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset('assets/css/argon.css?v=1.2.0')}}" type="text/css">
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
 --}}

</head>
<body>
<div class="container-fluid">
  <div class="row">
    <div class="col-md-2" id="sidenav">
	<nav class="sidenav navbar navbar-vertical  fixed-left  navbar-expand-xs navbar-dark bg-dark" id="sidenav-main">

    <div class="scrollbar-inner">
      <!-- Brand -->
      <div class="sidenav-header  align-items-left">
        <a class="navbar-brand" href="javascript:void(0)">
        <img src="{{asset('images/u2.png')}}"> {{ env('APP_NAME') }}
        </a>
      </div>
      <div class="navbar-inner">
        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
          <ul class="navbar-nav mb-md-3">
            <li class="nav-item">
            <a href="{{route('client.bundles')}}" class="nav-link">
                <span class="fas fa-cubes"></span>&nbsp;
                <span class="sidenav-normal"> Packages </span>
              </a>
            </li>
            @if(isset(Auth::guard('customer')->user()->username ))
            <li class="nav-item">
            <a href="{{route('user.balance')}}" class="nav-link">
                <span class="fas fa-check-square"></span>&nbsp;
                <span class="sidenav-normal"> Check Package Balance </span>
              </a>
            </li>
            <li class="nav-item">
            <a href="{{route('user.changephone')}}" class="nav-link">
                <span class="fas fa-dice-d20"></span>&nbsp;
                <span class="sidenav-normal">Change Phone </span>
              </a>
            </li>
            <li class="nav-item">
            <a href="{{route('user.get.cleanstale')}}" class="nav-link">
                <span class="fas fa-water"></span>&nbsp;
                <span class="sidenav-normal"> Clean Stale Connections </span>
              </a>
            </li>
            <li class="nav-item">
            <a href="{{route('user.transactions')}}" class="nav-link">
                <span class="fas fa-money-check"></span>&nbsp;
                <span class="sidenav-normal"> Transactions </span>
              </a>
            </li>
            @endif
            @if(!isset(Auth::guard('customer')->user()->username ))
            <li class="nav-item">
                <a href="{{route('get.customer.register')}}" class="nav-link btn btn-primary btn-sm">
                    <span class="fas fa-user-plus"></span>&nbsp;
                    <span class="sidenav-normal"> Create Account </span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{route('get.customer.login')}}" class="nav-link btn btn-success btn-sm mt-1">
                    <span class="fas fa-sign-in-alt"></span>&nbsp;
                    <span class="sidenav-normal">  Login </span>
                </a>
            </li>
            @endif
            @if(isset(Auth::guard('customer')->user()->username ))
            <li class="nav-item">
            <a href="{{route('user.logout')}}" class="nav-link btn btn-danger btn-md">
                <span class="fas fa-sign-out-alt"></span>&nbsp;
                <span class="sidenav-normal"> Logout </span>
                </a>
            </li>
            @endif
        </div>
      </div>
    </div>
  </nav>
</div>
<div class="col-md-10">

<div class="container-fluid mt-2 ml-0">
<button class="btn btn-sm btn-dark" type="button">Menu</button><br><br>
  @yield('content')
</div>
</div>
</div>
</div>
<script src="{{asset('js/app.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
<script type="text/javascript">
$(document).ready(function(){
    var show = false;
    $(".btn-dark").click(function(){
        if(show==false){
            $("#sidenav").slideUp();
            show = true;
        }else{
            $("#sidenav").slideDown();
            show = false;
        }

    })
})
</script>
@yield('js')
</body>
</html>
