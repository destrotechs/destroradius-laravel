<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="author" content="Morris Mbae Destro">
  <title>{{ env('APP_NAME') }}</title>
  <!-- Favicon -->
  <link rel="icon" href="{{asset('images/u2.png')}}" type="image/png">
  <!-- Fonts -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
  <!-- Icons -->
  <link rel="stylesheet" href="{{asset('assets/vendor/nucleo/css/nucleo.css')}}" type="text/css">
  <link rel="stylesheet" href="{{asset('assets/vendor/@fortawesome/fontawesome-free/css/all.min.css')}}" type="text/css">
  <!-- Page plugins -->
  <!-- Argon CSS -->
  <link href="{{ asset('js/select2.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('js/jquery.dataTables.min.css') }}" rel="stylesheet" />
  
  <link rel="stylesheet" type="text/css" href="{{asset('css/app.css')}}">
  <link rel="stylesheet" href="{{asset('assets/css/argon.css')}}" type="text/css">
  <script src="https://unpkg.com/chart.js@^2.9.3/dist/Chart.min.js"></script>
  <!-- Chartisan -->
  <script src="https://unpkg.com/@chartisan/chartjs@^2.1.0/dist/chartisan_chartjs.umd.js"></script>
  @yield('styles')
  <style>
    .navbar-nav>.active>a {
        background-color: blue;
        color: white;
    }

    .scrollbar-inner{
        overflow: auto;
        height: 200vh;
    }

    #footer {
        position: fixed;
        bottom: 0;
        margin-top: 5px;
        right: 0;
        left: 0;
        width: 100%;
        height: 40px;
        text-align: center;
        background: green;
        color: white;
    }

        
  </style>
</head>

<body>
  @php
  // use App\Models\User;
      function highlightNavigation($routes)
      {
          $fromPage =  Request::get("fromPage") ? Request::get("fromPage") : null;
          if($fromPage){
              if( is_array($routes) && in_array($fromPage,$routes) || $routes==$fromPage ){
                  return true;
              }
          }
          return Request::is($routes);
      }
      // $userDetails=User::where('id',Auth::user()->id)->first();
  @endphp
  <!-- Sidenav -->
  <nav class="sidenav navbar navbar-vertical  fixed-left  navbar-expand-xs navbar-white bg-white mb-5" id="sidenav-main">
     <!-- Brand -->
     <div class="sidenav-header  align-items-left">
      <a class="navbar-brand" href="javascript:void(0)">
      <img src="{{asset('images/logo.png')}}">
      </a>
    </div>
    <div class="scrollbar-inner" id="scrollbar-inner">
     
      <div class="navbar-inner">
        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
          <!-- Nav items -->
          <ul class="navbar-nav">
            <li class="nav-item  {{ highlightNavigation(['home*']) ? 'active': '' }}">
              <a class="nav-link" href="{{route('home')}}">
                <i class="ni ni-tv-2 {{ highlightNavigation(['home*']) ? 'text-white': 'text-orange' }}"></i>
                <span class="nav-link-text">Dashboard</span>
              </a>
            </li>
            <li class="nav-item {{ highlightNavigation(['zones/all*']) ? 'active': '' }}">
              <a class="nav-link" href="#network" data-toggle="collapse" role="button" aria-expanded=" {{ highlightNavigation(['zones/all*']) ? 'true': 'false' }}" aria-controls="navbar-examples">
                <i class="fas fa-wifi {{ highlightNavigation(['zones/all*']) ? 'text-white': 'text-orange' }}"></i>
                <span class="nav-link-text">&nbsp;Zones</span>
              </a>
              <div class="collapse" id="network" style="toggle: {{ highlightNavigation(['zones/all*']) ? 'true': 'false' }};display: {{ highlightNavigation(['zones/all*']) ? 'inline': '' }};">
                <ul class="nav nav-sm flex-column">
                  <li class="nav-item" style="background: {{ highlightNavigation(['zones/all*']) ? 'lightblue': '' }}">
                    <a href="{{route('zone.all')}}" class="nav-link">
                      <span class="fas fa-bars" style="color: {{ highlightNavigation(['zones/all*']) ? 'white': '' }}"></span>&nbsp;
                      <span class="sidenav-normal" style="color: {{ highlightNavigation(['zones/all*']) ? 'white': '' }}"> view zones </span>
                    </a>
                  </li>
                </ul>
              </div>
            </li>
            <li class="nav-item {{ highlightNavigation(['nas/new*','nas/view*','accounting/nas']) ? 'active': '' }}">
              <a class="nav-link" href="#nas" data-toggle="collapse" role="button" aria-expanded=" {{ highlightNavigation(['nas/new*','nas/view*','accounting/nas']) ? 'true': 'false' }}" aria-controls="navbar-examples">
                <i class="fas fa-globe {{ highlightNavigation(['nas/new*','nas/view*','accounting/nas']) ? 'text-white': 'text-orange' }}"></i>
                <span class="nav-link-text">&nbsp;Nas</span>
              </a>
              <div class="collapse" id="nas" style="toggle: {{ highlightNavigation(['nas/new*','nas/view*','accounting/nas']) ? 'true': 'false' }};display: {{ highlightNavigation(['nas/new*','nas/view*','accounting/nas']) ? 'inline': '' }};">
                <ul class="nav nav-sm flex-column">
                  @if(Auth::user()->role_id==1)
                  <li class="nav-item" style="background: {{ highlightNavigation(['nas/new*']) ? 'lightblue': '' }}">
                    <a href="{{route('nas.new')}}" class="nav-link">
                      <span class="fas fa-plus-circle" style="color: {{ highlightNavigation(['nas/new*']) ? 'white': '' }}"></span>&nbsp;
                      <span class="sidenav-normal" style="color: {{ highlightNavigation(['nas/new*']) ? 'white': '' }}"> New nas </span>
                    </a>
                  </li>
                  @endif
                  <li class="nav-item" style="background: {{ highlightNavigation(['nas/view*']) ? 'lightblue': '' }}">
                    <a href="{{route('nas.view')}}" class="nav-link">
                      <span class="fas fa-bars" style="color: {{ highlightNavigation(['nas/view*']) ? 'white': '' }}"></span>&nbsp;
                      <span class="sidenav-normal" style="color: {{ highlightNavigation(['nas/view*']) ? 'white': '' }}"> View nas </span>
                    </a>
                  </li>
                  <li class="nav-item" style="background: {{ highlightNavigation(['accounting/nas']) ? 'lightblue': '' }}">
                    <a href="{{route('nas.accounting')}}" class="nav-link">
                      <span class="fas fa-bars" style="color: {{ highlightNavigation(['accounting/nas']) ? 'white': '' }}"></span>&nbsp;
                      <span class="sidenav-normal" style="color: {{ highlightNavigation(['accounting/nas']) ? 'white': '' }}"> Nas Traffic </span>
                    </a>
                  </li>
                </ul>
              </div>
            </li>
            <li class="nav-item  {{ highlightNavigation(['packages/new*','packages/all*','packages/prices*']) ? 'active': '' }}">
              <a class="nav-link" href="#packages" data-toggle="collapse" role="button" aria-expanded=" {{ highlightNavigation(['packages/new*','packages/all*','packages/prices*']) ? 'true': 'false' }}" aria-controls="navbar-examples">
                <i class="fas fa-receipt {{ highlightNavigation(['packages/new*','packages/all*','packages/prices*']) ? 'text-white': 'text-orange' }}"></i>
                <span class="nav-link-text">&nbsp;Packages</span>
              </a>
              <div class="collapse" id="packages" style="toggle: {{ highlightNavigation(['packages/new*','packages/all*','packages/prices*']) ? 'true': 'false' }};display: {{ highlightNavigation(['packages/new*','packages/all*','packages/prices*']) ? 'inline': '' }};">
                <ul class="nav nav-sm flex-column">
                  @if(Auth::user()->role_id==1)
                  <li class="nav-item" style="background: {{ highlightNavigation(['packages/new*']) ? 'lightblue': '' }}">                  
                    <a href="{{route('packages.new')}}" class="nav-link">
                      <span class="fas fa-plus-circle"  style="color: {{ highlightNavigation(['packages/new*']) ? 'white': '' }}"></span>&nbsp;
                      <span class="sidenav-normal" style="color: {{ highlightNavigation(['packages/new*']) ? 'white': '' }}"> New package </span>
                    </a>
                  </li>
                  @endif
                  <li class="nav-item" style="background: {{ highlightNavigation(['packages/all*']) ? 'lightblue': '' }}">
                    <a href="{{route('packages.all')}}" class="nav-link">
                      <span class="fas fa-bars" style="color: {{ highlightNavigation(['packages/all*']) ? 'white': '' }}"></span>&nbsp;
                      <span class="sidenav-normal" style="color: {{ highlightNavigation(['packages/all*']) ? 'white': '' }}"> view packages </span>
                    </a>
                  </li>
                  @if(Auth::user()->role_id==1)
                  <li class="nav-item" style="background: {{ highlightNavigation(['packages/prices*']) ? 'lightblue': '' }}">
                    <a href="{{route('package.price')}}" class="nav-link">
                      <span class="fas fa-bars" style="color: {{ highlightNavigation(['packages/prices*']) ? 'white': '' }}"></span>&nbsp;
                      <span class="sidenav-normal" style="color: {{ highlightNavigation(['packages/prices*']) ? 'white': '' }}"> package pricing</span>
                    </a>
                  </li>
                  @endif
                </ul>
              </div>
            </li>
            
            <li class="nav-item  {{ highlightNavigation(['user/change*','users/all*','users/new*','users/online*','user/accounts*','user/customlimits*','bundlebalance*','accounting/user']) ? 'active': '' }}">
              <a class="nav-link" href="#users" data-toggle="collapse" role="button" aria-expanded=" {{ highlightNavigation(['user/change*','users/all*','users/new*','users/online*','user/accounts*','user/customlimits*','bundlebalance*','accounting/user']) ? 'true': 'false' }}" aria-controls="navbar-examples">
                <i class="fas fa-users {{ highlightNavigation(['user/change*','users/all*','users/new*','users/online*','user/accounts*','user/customlimits*','bundlebalance*','accounting/user']) ? 'text-white': 'text-orange' }}"></i>
                <span class="nav-link-text">Users</span>
              </a>
              <div class="collapse" id="users" style="toggle: {{ highlightNavigation(['user/change*','users/all*','users/new*','users/online*','user/accounts*','user/customlimits*','bundlebalance*','accounting/user']) ? 'true': 'false' }};display: {{ highlightNavigation(['user/change*','users/all*','users/new*','users/online*','user/accounts*','user/customlimits*','bundlebalance*','accounting/user']) ? 'inline': '' }};">
                <ul class="nav nav-sm flex-column">
                  
                  <li class="nav-item" style="background: {{ highlightNavigation(['user/change*','users/all*']) ? 'lightblue': '' }}">
                    <a href="{{ route('user.all')}}" class="nav-link">
                      <span class="fas fa-users" style="color: {{ highlightNavigation(['user/change*','users/all*']) ? 'white': '' }}"></span>&nbsp;
                      <span class="sidenav-normal" style="color: {{ highlightNavigation(['user/change*','users/all*']) ? 'white': '' }}"> All users </span>
                    </a>
                  </li>
                  <li class="nav-item" style="background: {{ highlightNavigation(['users/new*']) ? 'lightblue': '' }}">
                    <a href="{{route('user.new')}}" class="nav-link">
                      <span class="fas fa-plus-circle" style="color: {{ highlightNavigation(['users/new*']) ? 'white': '' }}"></span>&nbsp;
                      <span class="sidenav-normal" style="color: {{ highlightNavigation(['users/new*']) ? 'white': '' }}"> New User </span>
                    </a>
                  </li>
                  <li class="nav-item" style="background: {{ highlightNavigation(['users/online*']) ? 'lightblue': '' }}">
                    <a href="{{route('user.online')}}" class="nav-link">
                      <span class="fas fa-circle text-green" style="color: {{ highlightNavigation(['users/online*']) ? 'white': '' }}"></span>&nbsp;
                      <span class="sidenav-normal" style="color: {{ highlightNavigation(['users/online*']) ? 'white': '' }}"> Online users </span>
                    </a>
                  </li>
                  <li class="nav-item" style="background: {{ highlightNavigation(['user/accounts*']) ? 'lightblue': '' }}">
                    <a href="{{route('customer.accounts')}}" class="nav-link">
                      <span class="fas fa-edit text-success" style="color: {{ highlightNavigation(['user/accounts*']) ? 'white': '' }}"></span>&nbsp;
                      <span class="sidenav-normal" style="color: {{ highlightNavigation(['user/accounts*']) ? 'white': '' }}"> User Accounts </span>
                    </a>
                  </li>
                  <li class="nav-item" style="background: {{ highlightNavigation(['user/customlimits*']) ? 'lightblue': '' }}">
                    <a href="{{ route('getuserlimits') }}" class="nav-link">
                      <span class="fas fa-edit text-success" style="color: {{ highlightNavigation(['user/customlimits*']) ? 'white': '' }}"></span>&nbsp;
                      <span class="sidenav-normal" style="color: {{ highlightNavigation(['user/customlimits*']) ? 'white': '' }}"> User Limits</span>
                    </a>
                  </li>
                  <li class="nav-item" style="background: {{ highlightNavigation(['bundlebalance*']) ? 'lightblue': '' }}">
                    <a href="{{route('user.balance')}}" class="nav-link">
                      <span class="fas fa-circle text-success" style="color: {{ highlightNavigation(['bundlebalance*']) ? 'white': '' }}"></span>&nbsp;
                      <span class="sidenav-normal" style="color: {{ highlightNavigation(['bundlebalance*']) ? 'white': '' }}"> Bundle Balance</span>
                    </a>
                  </li>
                  {{-- <li class="nav-item">
                    <a href="{{route('user.unpaid')}}" class="nav-link">
                      <span class="fas fa-circle text-danger"></span>&nbsp;
                      <span class="sidenav-normal"> Unpaid users </span>
                    </a>
                  </li> --}}
                  <li class="nav-item" style="background: {{ highlightNavigation(['accounting/user']) ? 'lightblue': '' }}">
                    <a href="{{route('user.accounting')}}" class="nav-link">
                      <span class="fas fa-circle text-danger" style="color: {{ highlightNavigation(['accounting/user']) ? 'white': '' }}"></span>&nbsp;
                      <span class="sidenav-normal" style="color: {{ highlightNavigation(['accounting/user']) ? 'white': '' }}"> User traffic </span>
                    </a>
                  </li>
                </ul>
              </div>
            </li>
            
            
            
            <li class="nav-item  {{ highlightNavigation(['managers/new*','manager/all*']) ? 'active': '' }}">
              <a class="nav-link" href="#navbar-examples" data-toggle="collapse" role="button" aria-expanded=" {{ highlightNavigation(['managers/new*','manager/all*']) ? 'true': 'false' }}" aria-controls="navbar-examples">
                <i class="ni ni-ungroup {{ highlightNavigation(['managers/new*','manager/all*']) ? 'text-white': 'text-orange' }}"></i>
                <span class="nav-link-text">Managers</span>
              </a>
              <div class="collapse" id="navbar-examples" style="toggle: {{ highlightNavigation(['managers/new*','manager/all*']) ? 'true': 'false' }};display: {{ highlightNavigation(['managers/new*','manager/all*']) ? 'inline': '' }};">
                <ul class="nav nav-sm flex-column">
                  <li class="nav-item" style="background: {{ highlightNavigation(['managers/new*']) ? 'lightblue': '' }}">
                    <a href="{{ route('manager.new.get') }}" class="nav-link">
                      <span class="fas fa-plus" style="color: {{ highlightNavigation(['managers/new*']) ? 'white': '' }}"></span>&nbsp;
                      <span class="sidenav-normal" style="color: {{ highlightNavigation(['managers/new*']) ? 'white': '' }}"> New Manager </span>
                    </a>
                  </li>
                  <li class="nav-item" style="background: {{ highlightNavigation(['manager/all*']) ? 'lightblue': '' }}">
                    <a href="{{ route('managers.all') }}" class="nav-link">
                      <span class="fas fa-bars" style="color: {{ highlightNavigation(['manager/all*']) ? 'white': '' }}"></span>&nbsp;
                      <span class="sidenav-normal" style="color: {{ highlightNavigation(['manager/all*']) ? 'white': '' }}"> All Managers </span>
                    </a>
                  </li>
                </ul>
              </div>
            </li>



            <li class="nav-item  {{ highlightNavigation(['tickets/new*','tickets/open']) ? 'active': '' }}">
              <a class="nav-link" href="#tickets" data-toggle="collapse" role="button" aria-expanded=" {{ highlightNavigation(['tickets/new*','tickets/open']) ? 'true': 'false' }}" aria-controls="navbar-examples">
                <i class="fas fa-address-card {{ highlightNavigation(['tickets/new*','tickets/open']) ? 'text-white': 'text-orange' }}"></i>
                <span class="nav-link-text">&nbsp;Tickets</span>
              </a>
              <div class="collapse" id="tickets" style="toggle: {{ highlightNavigation(['tickets/new*','tickets/open']) ? 'true': 'false' }};display: {{ highlightNavigation(['tickets/new*','tickets/open']) ? 'inline': '' }};">
                <ul class="nav nav-sm flex-column">
                  @if(Auth::user()->role_id==1)
                  <li class="nav-item" style="background: {{ highlightNavigation(['tickets/new*']) ? 'lightblue': '' }}">
                    <a href="{{route('tickets.new')}}" class="nav-link">
                      <span class="fas fa-plus-circle" style="color: {{ highlightNavigation(['tickets/new*']) ? 'white': '' }}"></span>&nbsp;
                      <span class="sidenav-normal" style="color: {{ highlightNavigation(['tickets/new*']) ? 'white': '' }}"> New ticket </span>
                    </a>
                  </li>
                  @endif
                  <li class="nav-item" style="background: {{ highlightNavigation(['tickets/open*']) ? 'lightblue': '' }}">
                    <a href="{{route('tickets.open')}}" class="nav-link">
                      <span class="fas fa-bars" style="color: {{ highlightNavigation(['tickets/open*']) ? 'white': '' }}"></span>&nbsp;
                      <span class="sidenav-normal" style="color: {{ highlightNavigation(['tickets/open*']) ? 'white': '' }}"> open tickets </span>
                    </a>
                  </li>
                  {{-- <li class="nav-item" style="background: {{ highlightNavigation(['accounting/user**']) ? 'lightblue': '' }}">
                    <a href="#" class="nav-link">
                      <span class="fas fa-plus-circle" style="color: {{ highlightNavigation(['zones/all*']) ? 'white': '' }}"></span>&nbsp;
                      <span class="sidenav-normal" style="color: {{ highlightNavigation(['zones/all*']) ? 'white': '' }}"> closed tickets</span>
                    </a>
                  </li> --}}
                </ul>
              </div>
            </li>
            @if(Auth::user()->role_id==1)
            <li class="nav-item  {{ highlightNavigation(['payments*','invoices/new*','Manager/payments*']) ? 'active': '' }}">
              <a class="nav-link" href="#finance" data-toggle="collapse" role="button" aria-expanded=" {{ highlightNavigation(['payments*','invoices/new*','Manager/payments*']) ? 'true': 'false' }}" aria-controls="navbar-examples">
                <i class="fas fa-money-bill {{ highlightNavigation(['payments*','invoices/new*','Manager/payments*']) ? 'text-white': 'text-orange' }}"></i>
                <span class="nav-link-text">&nbsp;Finance</span>
              </a>
              <div class="collapse" id="finance" style="toggle: {{ highlightNavigation(['payments*','invoices/new*','Manager/payments*']) ? 'true': 'false' }};display: {{ highlightNavigation(['payments*','invoices/new*','Manager/payments*']) ? 'inline': '' }};">
                <ul class="nav nav-sm flex-column">

                  <li class="nav-item" style="background: {{ highlightNavigation(['payments*']) ? 'lightblue': '' }}">
                    <a href="{{route('payment.all')}}" class="nav-link">
                      <span class="fas fa-plus-circle" style="color: {{ highlightNavigation(['payments*']) ? 'white': '' }}"></span>&nbsp;
                      <span class="sidenav-normal" style="color: {{ highlightNavigation(['payments*']) ? 'white': '' }}"> Sales </span>
                    </a>
                  </li>
                  <li class="nav-item" style="background: {{ highlightNavigation(['invoices/new*']) ? 'lightblue': '' }}">
                    <a href="{{route('new.invoice')}}" class="nav-link">
                      <span class="fas fa-plus-circle" style="color: {{ highlightNavigation(['invoices/new*']) ? 'white': '' }}"></span>&nbsp;
                      <span class="sidenav-normal" style="color: {{ highlightNavigation(['invoices/new*']) ? 'white': '' }}"> New Invoice </span>
                    </a>
                  </li>

                  <li class="nav-item" style="background: {{ highlightNavigation(['Manager/payments*']) ? 'lightblue': '' }}">
                    <a href="{{route('manager.payment')}}" class="nav-link">
                      <span class="fas fa-bars" style="color: {{ highlightNavigation(['Manager/payments*']) ? 'white': '' }}"></span>&nbsp;
                      <span class="sidenav-normal" style="color: {{ highlightNavigation(['Manager/payments*']) ? 'white': '' }}"> Manager Payments </span>
                    </a>
                  </li>

                </ul>
              </div>
            </li>
             @endif
             <li class="nav-item  {{ highlightNavigation(['accounting/user1','accounting/nas1','accounting/ip']) ? 'active': '' }}">
              <a class="nav-link" href="#account" data-toggle="collapse" role="button" aria-expanded=" {{ highlightNavigation(['accounting/user1','accounting/nas1','accounting/ip']) ? 'true': 'false' }}" aria-controls="navbar-examples">
                <i class="fas fa-chart-line {{ highlightNavigation(['accounting/user1','accounting/nas1','accounting/ip']) ? 'text-white': 'text-orange' }}"></i>
                <span class="nav-link-text">&nbsp;Traffic Accounting</span>
              </a>
              <div class="collapse" id="account" style="toggle: {{ highlightNavigation(['accounting/user1','accounting/nas1','accounting/ip']) ? 'true': 'false' }};display: {{ highlightNavigation(['accounting/user1','accounting/nas1','accounting/ip']) ? 'inline': '' }};">
                <ul class="nav nav-sm flex-column">

                  <li class="nav-item" style="background: {{ highlightNavigation(['accounting/user1']) ? 'lightblue': '' }}">
                    <a href="{{route('user.accounting1')}}" class="nav-link">
                      <span class="fas fa-plus-circle" style="color: {{ highlightNavigation(['accounting/user1']) ? 'white': '' }}"></span>&nbsp;
                      <span class="sidenav-normal" style="color: {{ highlightNavigation(['accounting/user1']) ? 'white': '' }}"> User accounting </span>
                    </a>
                  </li>

                  <li class="nav-item" style="background: {{ highlightNavigation(['accounting/nas1']) ? 'lightblue': '' }}">
                    <a href="{{route('nas.accounting1')}}" class="nav-link">
                      <span class="fas fa-bars" style="color: {{ highlightNavigation(['accounting/nas1']) ? 'white': '' }}"></span>&nbsp;
                      <span class="sidenav-normal" style="color: {{ highlightNavigation(['accounting/nas1']) ? 'white': '' }}"> Nas accounting </span>
                    </a>
                  </li>
                  <li class="nav-item" style="background: {{ highlightNavigation(['accounting/ip*']) ? 'lightblue': '' }}">
                    <a href="{{route('ip.accounting')}}" class="nav-link">
                      <span class="fas fa-bars" style="color: {{ highlightNavigation(['accounting/ip*']) ? 'white': '' }}"></span>&nbsp;
                      <span class="sidenav-normal" style="color: {{ highlightNavigation(['accounting/ip*']) ? 'white': '' }}"> Ip accounting </span>
                    </a>
                  </li>
                </ul>
              </div>
            </li>
          </ul>
          @if(Auth::user()->role_id==1)
         
          <ul class="navbar-nav">
            <li class="nav-item  {{ highlightNavigation(['inventory/categories','inventory/sub_categories','inventory/items/new','inventory/items','inventory/suppliers','inventory/vendors']) ? 'active': '' }}">
              <a class="nav-link" href="#inventory" data-toggle="collapse" role="button" aria-expanded=" {{ highlightNavigation(['inventory/categories','inventory/sub_categories','inventory/items/new','inventory/items','inventory/suppliers','inventory/vendors']) ? 'true': 'false' }}" aria-controls="navbar-examples">
                <i class="fas fa-globe {{ highlightNavigation(['inventory/categories','inventory/sub_categories','inventory/items/new','inventory/items','inventory/suppliers','inventory/vendors']) ? 'text-white': 'text-orange' }}"></i>
                <span class="nav-link-text">&nbsp;Inventory</span>
              </a>
              <div class="collapse" id="inventory" style="toggle: {{ highlightNavigation(['inventory/categories','inventory/sub_categories','inventory/items/new','inventory/items','inventory/suppliers','inventory/vendors']) ? 'true': 'false' }};display: {{ highlightNavigation(['inventory/categories','inventory/sub_categories','inventory/items/new','inventory/items','inventory/suppliers','inventory/vendors']) ? 'inline': '' }};">
                <ul class="nav nav-sm flex-column">
                  <li class="nav-item" style="background: {{ highlightNavigation(['inventory/categories']) ? 'lightblue': '' }}">
                    <a href="{{route('inventory.categories')}}" class="nav-link">
                      <span class="fas fa-bars" style="color: {{ highlightNavigation(['inventory/categories']) ? 'white': '' }}"></span>&nbsp;
                      <span class="sidenav-normal" style="color: {{ highlightNavigation(['inventory/categories']) ? 'white': '' }}"> Item Categories</span>
                    </a>
                  </li>
                  <li class="nav-item" style="background: {{ highlightNavigation(['inventory/sub_categories']) ? 'lightblue': '' }}">
                    <a href="{{route('inventory.sub_categories.get')}}" class="nav-link">
                      <span class="fas fa-bars" style="color: {{ highlightNavigation(['inventory/sub_categories']) ? 'white': '' }}"></span>&nbsp;
                      <span class="sidenav-normal" style="color: {{ highlightNavigation(['inventory/sub_categories']) ? 'white': '' }}"> Item Sub Categories</span>
                    </a>
                  </li>
                  <li class="nav-item" style="background: {{ highlightNavigation(['inventory/items/new']) ? 'lightblue': '' }}">
                  <a href="{{route('inventory.item.new')}}" class="nav-link">
                      <span class="fas fa-plus-circle" style="color: {{ highlightNavigation(['inventory/items/new']) ? 'white': '' }}"></span>&nbsp;
                      <span class="sidenav-normal" style="color: {{ highlightNavigation(['inventory/items/new']) ? 'white': '' }}"> New item </span>
                    </a>
                  </li>
                  <li class="nav-item" style="background: {{ highlightNavigation(['inventory/items']) ? 'lightblue': '' }}">
                    <a href="{{route('inventory.items')}}" class="nav-link">
                      <span class="fas fa-bars" style="color: {{ highlightNavigation(['inventory/items']) ? 'white': '' }}"></span>&nbsp;
                      <span class="sidenav-normal" style="color: {{ highlightNavigation(['inventory/items']) ? 'white': '' }}"> view items </span>
                    </a>
                  </li>
                
                  <li class="nav-item" style="background: {{ highlightNavigation(['inventory/suppliers']) ? 'lightblue': '' }}">
                    <a href="{{route('inventory.suppliers')}}" class="nav-link">
                      <span class="fas fa-bars" style="color: {{ highlightNavigation(['inventory/suppliers']) ? 'white': '' }}"></span>&nbsp;
                      <span class="sidenav-normal" style="color: {{ highlightNavigation(['inventory/suppliers']) ? 'white': '' }}"> Suppliers </span>
                    </a>
                  </li>
                  <li class="nav-item" style="background: {{ highlightNavigation(['inventory/vendors']) ? 'lightblue': '' }}">
                    <a href="{{route('inventory.vendors')}}" class="nav-link">
                      <span class="fas fa-bars" style="color: {{ highlightNavigation(['inventory/vendors']) ? 'white': '' }}"></span>&nbsp;
                      <span class="sidenav-normal" style="color: {{ highlightNavigation(['inventory/vendors']) ? 'white': '' }}"> Vendors </span>
                    </a>
                  </li>
                </ul>

              </div>
            </li>

          </ul>
          
          <ul class="navbar-nav">

            <li class="nav-item" style="background: {{ highlightNavigation(['settings/system']) ? 'lightblue': '' }}">
              <a href="{{route('settings.index')}}" class="nav-link">
                <i class="fas fa-cog {{ highlightNavigation(['settings/system']) ? 'text-white': 'text-orange' }}" style="color: {{ highlightNavigation(['settings/system']) ? 'white': '' }}"></i>
                <span class="nav-link-text" style="color: {{ highlightNavigation(['settings/system']) ? 'white': '' }}">&nbsp;General settings</span>
              </a>
              
            </li>
            <li class="nav-item" style="background: {{ highlightNavigation(['company/details']) ? 'lightblue': '' }}">
              <a href="{{ route('company.details') }}" class="nav-link">
                <i class="fas fa-user {{ highlightNavigation(['company/details']) ? 'text-white': 'text-orange' }}" style="color: {{ highlightNavigation(['company/details']) ? 'white': '' }}" style="color: {{ highlightNavigation(['company/details']) ? 'white': '' }}"></i>
                <span class="nav-link-text" style="color: {{ highlightNavigation(['company/details']) ? 'white': '' }}">Company Details</span>
              </a>
            </li>

          </ul>
          @endif
          <ul class="navbar-nav">
                  <li class="nav-item" style="background: {{ highlightNavigation(['stale/connections']) ? 'lightblue': '' }}">
                  <a href="{{route('stale.conn')}}" class="nav-link">
                      <i class="fas fa-plus-circle {{ highlightNavigation(['stale/connections']) ? 'text-white': 'text-orange' }}" style="color: {{ highlightNavigation(['stale/connections']) ? 'white': '' }}"></i>
                      <span class="sidenav-normal" style="color: {{ highlightNavigation(['stale/connections']) ? 'white': '' }}"> Clean stale connections </span>
                    </a>
                  </li>
                  <li class="nav-item" style="background: {{ highlightNavigation(['services/testconnectivity']) ? 'lightblue': '' }}">
                    <a href="{{route('services.testconnectivity')}}" class="nav-link">
                      <i class="fas fa-bars {{ highlightNavigation(['services/testconnectivity']) ? 'text-white': 'text-orange' }}" style="color: {{ highlightNavigation(['services/testconnectivity']) ? 'white': '' }}"></i>
                      <span class="sidenav-normal" style="color: {{ highlightNavigation(['services/testconnectivity']) ? 'white': '' }}"> Test connectivity </span>
                    </a>
                  </li>
                  <li class="nav-item" style="background: {{ highlightNavigation(['services/status']) ? 'lightblue': '' }}">
                    <a href="{{route('services.status')}}" class="nav-link">
                      <i class="fas fa-plus-circle {{ highlightNavigation(['services/status']) ? 'text-white': 'text-orange' }}" style="color: {{ highlightNavigation(['services/status']) ? 'white': '' }}"></i>
                      <span class="sidenav-normal" style="color: {{ highlightNavigation(['services/status']) ? 'white': '' }}"> Services status</span>
                    </a>
                  </li>
                  <li class="nav-item" style="background: {{ highlightNavigation(['services/last-connections']) ? 'lightblue': '' }}">
                    <a href="{{route('last.conn.attempts')}}" class="nav-link">
                      <i class="fas fa-plus-circle {{ highlightNavigation(['services/last-connections']) ? 'text-white': 'text-orange' }}" style="color: {{ highlightNavigation(['services/last-connections']) ? 'white': '' }}"></i>
                      <span class="sidenav-normal" style="color: {{ highlightNavigation(['services/last-connections']) ? 'white': '' }}">Last-Connection attempts</span>
                    </a>
                  </li>
                  <li class="nav-item" style="background: {{ highlightNavigation(['system/logs']) ? 'lightblue': '' }}">
                    <a href="{{route('service.logs')}}" class="nav-link">
                      <i class="fas fa-plus-circle {{ highlightNavigation(['system/logs']) ? 'text-white': 'text-orange' }}" style="color: {{ highlightNavigation(['system/logs']) ? 'white': '' }}"></i>
                      <span class="sidenav-normal" style="color: {{ highlightNavigation(['system/logs']) ? 'white': '' }}">System Logs</span>
                    </a>
                  </li>

                </ul>
      </div>
    </div>
  </nav>
  <!-- Main content -->
  <div class="main-content" id="panel">
    <!-- Topnav -->
    <nav class="navbar navbar-top navbar-expand navbar-white bg-white border-bottom fixed-top">
      <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <!-- Navbar links -->
          <ul class="navbar-nav align-items-center  ml-md-auto ">
            <li class="nav-item d-xl-none">
              <!-- Sidenav toggler -->

              <div class="pr-3 sidenav-toggler sidenav-toggler-dark text-dark" data-action="sidenav-pin" data-target="#sidenav-main">
                <div class="sidenav-toggler-inner">
                  <i class="fas fa-bars"></i>
                </div>
              </div>
            </li>
           {{--  <li class="nav-item d-sm-none">
              <a class="nav-link" href="#" data-action="search-show" data-target="#navbar-search-main">
                <i class="ni ni-zoom-split-in"></i>
              </a>
            </li> --}}
            <li class="nav-item dropdown">
              <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="ni ni-bell-55"></i>
              </a>
              <div class="dropdown-menu dropdown-menu-xl  dropdown-menu-right  py-0 overflow-hidden">
                <!-- Dropdown header -->
                <div class="px-3 py-3">
                  <h6 class="text-sm text-muted m-0">You have <strong class="text-primary">13</strong> notifications.</h6>
                </div>
                <!-- List group -->
                <div class="list-group list-group-flush">
                  <a href="#!" class="list-group-item list-group-item-action">
                    <div class="row align-items-center">
                      <div class="col-auto">
                        <!-- Avatar -->
                        <img alt="Image placeholder" src="assets/img/theme/team-1.jpg" class="avatar rounded-circle">
                      </div>
                      <div class="col ml--2">
                        <div class="d-flex justify-content-between align-items-center">
                          <div>
                            <h4 class="mb-0 text-sm">John Snow</h4>
                          </div>
                          <div class="text-right text-muted">
                            <small>2 hrs ago</small>
                          </div>
                        </div>
                        <p class="text-sm mb-0">Let's meet at Starbucks at 11:30. Wdyt?</p>
                      </div>
                    </div>
                  </a>
                </div>
                <!-- View all -->
                <a href="#!" class="dropdown-item text-center text-primary font-weight-bold py-3">View all</a>
              </div>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded=" {{ highlightNavigation(['zones/all*']) ? 'true': 'false' }}">
                <i class="ni ni-ungroup"></i>
              </a>
              <div class="dropdown-menu dropdown-menu-lg dropdown-menu-dark bg-default  dropdown-menu-right ">
                <div class="row shortcuts px-4">
                  <a href="#!" class="col-4 shortcut-item">
                    <span class="shortcut-media avatar rounded-circle bg-gradient-orange">
                      <i class="ni ni-email-83"></i>
                    </span>
                    <small>Email</small>
                  </a>
                  <a href="{{ route('pay.option') }}" class="col-4 shortcut-item">
                    <span class="shortcut-media avatar rounded-circle bg-gradient-info">
                      <i class="ni ni-credit-card"></i>
                    </span>
                    <small>Payments</small>
                  </a>
                  <a href="#!" class="col-4 shortcut-item">
                    <span class="shortcut-media avatar rounded-circle bg-gradient-green">
                      <i class="ni ni-books"></i>
                    </span>
                    <small>Reports</small>
                  </a>

                </div>
              </div>
            </li>
          </ul>
          <ul class="navbar-nav align-items-center  ml-auto ml-md-0 ">
            <li class="nav-item dropdown">
              <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <div class="media align-items-center">
                  <span class="avatar avatar-sm rounded-circle">
                    <img alt="Image placeholder" src="{{asset('images/u1.png')}}">
                  </span>
                  <div class="media-body  ml-2  d-none d-lg-block">
                    <span class="mb-0 text-sm  font-weight-bold">{{Auth::user()->name}}</span>
                  </div>
                </div>
              </a>
              <div class="dropdown-menu  dropdown-menu-right ">
                <div class="dropdown-header noti-title">
                  <h6 class="text-overflow m-0">Welcome {{Auth::user()->name}}!</h6>
                </div>
                <a href="{{route('manager.profile')}}" class="dropdown-item">
                  <i class="ni ni-single-02"></i>
                  <span>My profile</span>
                </a>
                <a href="{{route('settings.index')}}" class="dropdown-item">
                  <i class="ni ni-settings-gear-65"></i>
                  <span>Settings</span>
                </a>
                {{-- <a href="#!" class="dropdown-item">
                  <i class="ni ni-calendar-grid-58"></i>
                  <span>Activity</span>
                </a>
                <a href="#!" class="dropdown-item">
                  <i class="ni ni-support-16"></i>
                  <span>Support</span>
                </a> --}}
                <div class="dropdown-divider"></div>
                <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">

                  <i class="ni ni-user-run"></i>
                  <span>Logout</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- Header -->
    <!-- Header -->
    {{-- <div class="header">
      <div class="container-fluid">
        <div class="header-body">
          <div class="row align-items-center py-4">
          <div class="col-lg-6 col-7">
              <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-0">
                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                  <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="fas fa-home"></i></a></li>
                  <li class="breadcrumb-item">@yield('content_header')</li>
                </ol>
              </nav>
            </div> 
            @yield('buttons')
          </div>
          <!-- Card stats -->

        </div>
      </div>
    </div> --}}
    <div class="container-fluid mt-8">
      @yield('content')
      @include('sweetalert::alert')

  </div>

  <div id="footer">
    <p style="text-align: center"> Copyright &copy; 2021-<script>document.write(new Date().getFullYear())</script> Realcode Kenya Ltd</p>
</div>
    
  <!-- Argon Scripts -->
  <!-- Core -->
  <script src="{{asset('assets/vendor/jquery/dist/jquery.min.js')}}"></script>
  <script src="{{asset('assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{asset('assets/vendor/js-cookie/js.cookie.js')}}"></script>
  <script src="{{asset('assets/vendor/jquery.scrollbar/jquery.scrollbar.min.js')}}"></script>
  <script src="{{asset('assets/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js')}}"></script>
  <!-- Optional JS -->
  <script src="{{asset('assets/vendor/chart.js/dist/Chart.min.js')}}"></script>
  <script src="{{asset('assets/vendor/chart.js/dist/Chart.extension.js')}}"></script>
  <!-- Argon JS -->
  <!-- <script src="{{asset('js/app.js')}}"></script> -->
  <script src="{{asset('assets/js/argon.js')}}"></script>
  <script src="{{ asset('js/custom.js') }}"></script>
  <script src="{{ asset('js/select2.min.js') }}"></script>
  <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
@yield('js')
<script>
  // In your Javascript (external .js resource or <script> tag)
$(document).ready(function() {
    $('.select2').select2();
});

$(document).ready( function () {
    $('.dTable').DataTable({
      responsive: true
    });
});

</script>
</body>

</html>
