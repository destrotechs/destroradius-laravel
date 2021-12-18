


<!DOCTYPE html>
<html>
<head>
	<title>DestroRadius-Users</title>
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
    <link rel="canonical" href="https://getbootstrap.com/docs/5.1/examples/headers/">
    <link rel="stylesheet" href="{{asset('assets/css/argon.css?v=1.2.0')}}" type="text/css">
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
 --}}

</head>
<body>
<header class="p-3 bg-dark text-white">
    <div class="container">
      <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
        <a href="{{route('client.bundles')}}" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
          <h3 class="text-white display-4 border p-2 br-2">DestroTechs</h3>
        </a>

        <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
            @if(isset(Auth::guard('customer')->user()->username ))
                <li><a href="{{route('user.balance')}}" class="nav-link px-2 text-yellow">MB(s) Balance</a></li>
                <li><a href="{{route('user.changephone')}}" class="nav-link px-2 text-yellow">Change Phone</a></li>
                <li><a href="{{route('user.get.cleanstale')}}" class="nav-link px-2 text-yellow">Stale Connections</a></li>
                <li><a href="{{route('user.transactions')}}" class="nav-link px-2 text-yellow">Transactions</a></li>
            @endif
        </ul>


        <div class="text-end">
        @if(!isset(Auth::guard('customer')->user()->username ))
          <a href="{{route('get.customer.login')}}" class="btn btn-outline-light me-2"><span class="fas fa-sign-in-alt"></span>&nbsp; Login</a>
          <a href="{{route('get.customer.register')}}" class="btn btn-warning"><span class="fas fa-user-plus"></span>&nbsp;Sign-up</a>
          @endif
          @if(isset(Auth::guard('customer')->user()->username ))
          <a href="{{route('user.logout')}}" class="btn btn-warning"><span class="fas fa-sign-out-alt"></span>&nbsp;Logout</a>
            @endif
        </div>

      </div>
    </div>
  </header>
<div class="container-fluid">

  <div class="row mt-5">
      <div class="col-md-12">
          @yield('content')
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
