
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.88.1">
    <title>{{ env('APP_NAME') }}</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.1/examples/pricing/">

    

    <!-- Bootstrap core CSS -->
<link href="/docs/5.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <!-- Favicons -->
<link rel="apple-touch-icon" href="/docs/5.1/assets/img/favicons/apple-touch-icon.png" sizes="180x180">
<link rel="icon" href="/docs/5.1/assets/img/favicons/favicon-32x32.png" sizes="32x32" type="image/png">
<link rel="icon" href="/docs/5.1/assets/img/favicons/favicon-16x16.png" sizes="16x16" type="image/png">
<link rel="manifest" href="/docs/5.1/assets/img/favicons/manifest.json">
<link rel="mask-icon" href="/docs/5.1/assets/img/favicons/safari-pinned-tab.svg" color="#7952b3">
<link rel="icon" href="/docs/5.1/assets/img/favicons/favicon.ico">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="{{asset('assets/css/argon.css')}}" type="text/css">

<link rel="stylesheet" href="{{asset('assets/vendor/@fortawesome/fontawesome-free/css/all.min.css')}}" type="text/css">
<meta name="theme-color" content="#7952b3">


    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
      body {
        /*background-image: linear-gradient(180deg, #eee, #fff 100px, #fff);*/
      }

      .container {
        max-width: 960px;
      }

      .pricing-header {
        max-width: 700px;
      }
    </style>

    
    <!-- Custom styles for this template -->
    {{-- <link href="pricing.css" rel="stylesheet"> --}}
  </head>
  <body>

<div class="container py-3">
  <header>
    <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
      <h5 class="my-0 mr-md-auto font-weight-large">{{ env('APP_NAME') }}</h5>
      <nav class="my-2 my-md-0 mr-md-3">
        {{-- <a class="p-2 text-dark" href="#">Features</a> --}}
        {{-- <a class="p-2 text-dark" href="#">Enterprise</a>
        <a class="p-2 text-dark" href="#">Support</a>
        <a class="p-2 text-dark" href="#">Pricing</a> --}}
      </nav>
      {{-- <a class="btn btn-outline-primary" href="#">Login</a>
      <a class="btn btn-outline-primary" href="#">Sign up</a> --}}
      @if(!isset(Auth::guard('customer')->user()->username ))

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Account
          </a>
          <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDarkDropdownMenuLink">
            <li><a class="dropdown-item" href="{{route('client.bundles')}}"><i class="fas fa-home"></i> Home</a></li>
            <div class="dropdown-divider"></div>
            <li><a class="dropdown-item" href="{{route('user.balance')}}"><i class="fas fa-money-bill"></i> Balance</a></li>
            <div class="dropdown-divider"></div>
            <li><a class="dropdown-item" href="{{route('get.customer.login')}}"><i class="fas fa-sign-in-alt"></i> Login</a></li>
            <div class="dropdown-divider"></div>
            <li><a class="dropdown-item" href="{{route('get.customer.register')}}"><i class="fas fa-sign-out-alt"></i> Sign up</a></li>
            <div class="dropdown-divider"></div>
          </ul>
        </li>
        @endif
        @if(isset(Auth::guard('customer')->user()->username ))
        <li class="nav-item dropdown">
          <a class="nav-link" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-bars"></i>
          </a>
          <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDarkDropdownMenuLink">
            <li class="bg-info"><a class="dropdown-item disabled text-white" href="#"><i class="fas fa-user"></i> Welcome {{ Auth::guard('customer')->user()->name }}</a></li>
            <div class="dropdown-divider"></div>
            <li><a class="dropdown-item" href="{{route('client.bundles')}}"><i class="fas fa-home"></i> Home</a></li>
            <div class="dropdown-divider"></div>
            <li><a class="dropdown-item" href="{{route('user.balance')}}"><i class="fas fa-money-bill"></i> Balance</a></li>
            <div class="dropdown-divider"></div>
            <li><a class="dropdown-item" href="{{route('user.get.cleanstale')}}"><i class="fas fa-cross"></i> Can't Access Internet</a></li>
            <div class="dropdown-divider"></div>
            <li><a class="dropdown-item" href="{{route('user.changephone')}}"><i class="fas fa-phone"></i> Change Phone</a></li>
            <div class="dropdown-divider"></div>
            <li><a class="dropdown-item" href="{{route('user.transactions')}}"><i class="fas fa-chart-line"></i> Transactions</a></li>
            <div class="dropdown-divider"></div>
            
            <div class="dropdown-divider"></div>
            <li><a class="dropdown-item" href="{{route('user.logout')}}"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            <div class="dropdown-divider"></div>
          </ul>
        </li>
        @endif
    </div>

    @yield('page_info')
  </header>

  <main>
    {{-- <div class="row row-cols-1 row-cols-md-3 mb-3 text-center"> --}}
      
    @yield('content')    
      @include('sweetalert::alert')

    {{-- </div> --}}
  </main>

  <footer class="pt-4 my-md-5 pt-md-5 border-top">
  
  </footer>
</div>
{{-- modal 5 --}}
<div class="modal fade" id="exampleModal3" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Enter Your Activation Code</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form method="POST" action="{{ route('activate.account') }}">
              <label>Account to Activate</label>
              <select name="package" required class="form-control">
                <option value="">select ...</option>
                @forelse(CustomerHelper::getUserAccounts(Auth::guard('customer')->user()->username??'') as $p)
                <option value="{{ $p->account_no }}">{{ $p->account_no }}</option>
                @empty
                <option value="">No Accounts available</option>
                @endforelse
            </select>
                    <label>Activation Code</label>
                    <input type="digit" name="activation_code" class="form-control" placeholder="e.g 1" required>
                    <input type="hidden" name="username" id="username">
                    

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Activate</button>
        </div>
        @csrf
    </form>
      </div>
    </div>
  </div>
{{-- end of modal 5 --}}

{{-- modal 6 --}}
<!-- Modal -->
<div class="modal fade" id="exampleModal6" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New Customer User Account</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{ route('suspend.account') }}">
           
            <input type="hidden" name="owner" value="{{ Auth::guard('customer')->user()->username??'' }}">
            
            <label>Select Account</label>
            <select name="username" required class="form-control">
                <option value="">select ...</option>
                @forelse(CustomerHelper::getUserAccounts(Auth::guard('customer')->user()->username??'') as $p)
                <option value="{{ $p->account_no }}">{{ $p->account_no }}</option>
                @empty
                <option value="">No Accounts available</option>
                @endforelse
            </select>
            
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Suspend Account</button>
      </div>
      @csrf
      </form>
    </div>
  </div>
</div>
{{-- end modal 6 --}}

    <script src="{{asset('js/app.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    @yield('js')
    <script type="text/javascript">
      $(document).ready(function(){
        $(".suspend").click(function(){
          if(confirm("Are you sure you want to suspend your internet access?")){
            var username = $(this).attr('id');
            $.ajax({
              method:'GET',
              url:'../client/account/suspend/'+username,
              success:function(res){
                alert(res);
                window.location.reload();
              }
            })
          }
        })
        $(".activate").click(function(){
          var username = $(this).attr('id');

          $("#username").val(username);
        })
      })
    </script>
  </body>
</html>
