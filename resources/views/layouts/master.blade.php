<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="author" content="Morris Mbae Destro">
  <title>DestroRadius</title>
  <!-- Favicon -->
  <link rel="icon" href="{{asset('images/u2.png')}}" type="image/png">
  <!-- Fonts -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
  <!-- Icons -->
  <link rel="stylesheet" href="{{asset('assets/vendor/nucleo/css/nucleo.css')}}" type="text/css">
  <link rel="stylesheet" href="{{asset('assets/vendor/@fortawesome/fontawesome-free/css/all.min.css')}}" type="text/css">
  <!-- Page plugins -->
  <!-- Argon CSS -->
  <link rel="stylesheet" type="text/css" href="{{asset('css/app.css')}}">

  <link rel="stylesheet" href="{{asset('assets/css/argon.css')}}" type="text/css">
  <script src="https://unpkg.com/chart.js@^2.9.3/dist/Chart.min.js"></script>
  <!-- Chartisan -->
  <script src="https://unpkg.com/@chartisan/chartjs@^2.1.0/dist/chartisan_chartjs.umd.js"></script>
</head>

<body>
  <!-- Sidenav -->
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
          <!-- Nav items -->
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" href="{{route('home')}}">
                <i class="ni ni-tv-2 text-white"></i>
                <span class="nav-link-text">Dashboard</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#navbar-examples" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-examples">
                <i class="ni ni-ungroup text-orange"></i>
                <span class="nav-link-text">Managers</span>
              </a>
              <div class="collapse" id="navbar-examples">
                <ul class="nav nav-sm flex-column">
                  <li class="nav-item">
                    <a href="{{ route('manager.new.get') }}" class="nav-link">
                      <span class="fas fa-plus"></span>&nbsp;
                      <span class="sidenav-normal"> New Manager </span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route('managers.all') }}" class="nav-link">
                      <span class="fas fa-bars"></span>&nbsp;
                      <span class="sidenav-normal"> All Managers </span>
                    </a>
                  </li>
                </ul>
              </div>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#users" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-examples">
                <i class="fas fa-users text-orange"></i>
                <span class="nav-link-text">Users</span>
              </a>
              <div class="collapse p-2" id="users">
                <ul class="nav nav-sm flex-column">
                  <li class="nav-item">
                    <a href="{{route('user.new')}}" class="nav-link">
                      <span class="fas fa-plus-circle"></span>&nbsp;
                      <span class="sidenav-normal"> New User </span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route('user.all')}}" class="nav-link">
                      <span class="fas fa-users"></span>&nbsp;
                      <span class="sidenav-normal"> All users </span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{route('user.online')}}" class="nav-link">
                      <span class="fas fa-circle text-green"></span>&nbsp;
                      <span class="sidenav-normal"> Online users </span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{route('geteditcustomer')}}" class="nav-link">
                      <span class="fas fa-edit text-success"></span>&nbsp;
                      <span class="sidenav-normal"> Edit user </span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route('getuserlimits') }}" class="nav-link">
                      <span class="fas fa-edit text-success"></span>&nbsp;
                      <span class="sidenav-normal"> User Limits</span>
                    </a>
                  </li>
                  {{-- <li class="nav-item">
                    <a href="{{route('user.paid')}}" class="nav-link">
                      <span class="fas fa-circle text-success"></span>&nbsp;
                      <span class="sidenav-normal"> Paid users </span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{route('user.unpaid')}}" class="nav-link">
                      <span class="fas fa-circle text-danger"></span>&nbsp;
                      <span class="sidenav-normal"> Unpaid users </span>
                    </a>
                  </li> --}}
                  <li class="nav-item">
                    <a href="{{route('user.accounting')}}" class="nav-link">
                      <span class="fas fa-circle text-danger"></span>&nbsp;
                      <span class="sidenav-normal"> User traffic </span>
                    </a>
                  </li>
                </ul>
              </div>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#nas" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-examples">
                <i class="fas fa-globe text-orange"></i>
                <span class="nav-link-text">&nbsp;Nas</span>
              </a>
              <div class="collapse p-2" id="nas">
                <ul class="nav nav-sm flex-column">
                  @if(Auth::user()->role_id==1)
                  <li class="nav-item">
                    <a href="{{route('nas.new')}}" class="nav-link">
                      <span class="fas fa-plus-circle"></span>&nbsp;
                      <span class="sidenav-normal"> New nas </span>
                    </a>
                  </li>
                  @endif
                  <li class="nav-item">
                    <a href="{{route('nas.view')}}" class="nav-link">
                      <span class="fas fa-bars"></span>&nbsp;
                      <span class="sidenav-normal"> View nas </span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{route('nas.accounting')}}" class="nav-link">
                      <span class="fas fa-bars"></span>&nbsp;
                      <span class="sidenav-normal"> Nas Traffic </span>
                    </a>
                  </li>
                </ul>
              </div>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#network" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-examples">
                <i class="fas fa-wifi text-orange"></i>
                <span class="nav-link-text">&nbsp;Zones</span>
              </a>
              <div class="collapse p-2" id="network">
                <ul class="nav nav-sm flex-column">
                  @if(Auth::user()->role_id==1)
                  <li class="nav-item">
                    <a href="{{route('zone.new')}}" class="nav-link">
                      <span class="fas fa-plus-circle"></span>&nbsp;
                      <span class="sidenav-normal">New zone/zone manager </span>
                    </a>
                  </li>
                  @endif
                  <li class="nav-item">
                    <a href="{{route('zone.all')}}" class="nav-link">
                      <span class="fas fa-bars"></span>&nbsp;
                      <span class="sidenav-normal"> view zones </span>
                    </a>
                  </li>
                </ul>
              </div>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#packages" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-examples">
                <i class="fas fa-receipt text-orange"></i>
                <span class="nav-link-text">&nbsp;Packages</span>
              </a>
              <div class="collapse p-2" id="packages">
                <ul class="nav nav-sm flex-column">
                  @if(Auth::user()->role_id==1)
                  <li class="nav-item">
                    <a href="{{route('packages.new')}}" class="nav-link">
                      <span class="fas fa-plus-circle"></span>&nbsp;
                      <span class="sidenav-normal"> New package </span>
                    </a>
                  </li>
                  @endif
                  <li class="nav-item">
                    <a href="{{route('packages.all')}}" class="nav-link">
                      <span class="fas fa-bars"></span>&nbsp;
                      <span class="sidenav-normal"> view packages </span>
                    </a>
                  </li>
                  @if(Auth::user()->role_id==1)
                  <li class="nav-item">
                    <a href="{{route('package.price')}}" class="nav-link">
                      <span class="fas fa-bars"></span>&nbsp;
                      <span class="sidenav-normal"> package pricing</span>
                    </a>
                  </li>
                  @endif
                </ul>
              </div>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#tickets" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-examples">
                <i class="fas fa-address-card text-orange"></i>
                <span class="nav-link-text">&nbsp;Tickets</span>
              </a>
              <div class="collapse p-2" id="tickets">
                <ul class="nav nav-sm flex-column">
                  @if(Auth::user()->role_id==1)
                  <li class="nav-item">
                    <a href="{{route('tickets.new')}}" class="nav-link">
                      <span class="fas fa-plus-circle"></span>&nbsp;
                      <span class="sidenav-normal"> New ticket </span>
                    </a>
                  </li>
                  @endif
                  <li class="nav-item">
                    <a href="{{route('tickets.open')}}" class="nav-link">
                      <span class="fas fa-bars"></span>&nbsp;
                      <span class="sidenav-normal"> open tickets </span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <span class="fas fa-plus-circle"></span>&nbsp;
                      <span class="sidenav-normal"> closed tickets</span>
                    </a>
                  </li>
                </ul>
              </div>
            </li>
            @if(Auth::user()->role_id==1)
            <li class="nav-item">
              <a class="nav-link" href="#finance" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-examples">
                <i class="fas fa-money-bill text-orange"></i>
                <span class="nav-link-text">&nbsp;Finance</span>
              </a>
              <div class="collapse p-2" id="finance">
                <ul class="nav nav-sm flex-column">

                  <li class="nav-item">
                    <a href="{{route('payment.all')}}" class="nav-link">
                      <span class="fas fa-plus-circle"></span>&nbsp;
                      <span class="sidenav-normal"> Sales </span>
                    </a>
                  </li>

                  <li class="nav-item">
                    <a href="{{route('manager.payment')}}" class="nav-link">
                      <span class="fas fa-bars"></span>&nbsp;
                      <span class="sidenav-normal"> Manager Payments </span>
                    </a>
                  </li>

                </ul>
              </div>
            </li>
             @endif
             <li class="nav-item">
              <a class="nav-link" href="#account" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-examples">
                <i class="fas fa-chart-line text-orange"></i>
                <span class="nav-link-text">&nbsp;Traffic Accounting</span>
              </a>
              <div class="collapse p-2" id="account">
                <ul class="nav nav-sm flex-column">

                  <li class="nav-item">
                    <a href="{{route('user.accounting')}}" class="nav-link">
                      <span class="fas fa-plus-circle"></span>&nbsp;
                      <span class="sidenav-normal"> User accounting </span>
                    </a>
                  </li>

                  <li class="nav-item">
                    <a href="{{route('nas.accounting')}}" class="nav-link">
                      <span class="fas fa-bars"></span>&nbsp;
                      <span class="sidenav-normal"> Nas accounting </span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{route('ip.accounting')}}" class="nav-link">
                      <span class="fas fa-bars"></span>&nbsp;
                      <span class="sidenav-normal"> Ip accounting </span>
                    </a>
                  </li>
                </ul>
              </div>
            </li>
          </ul>
          @if(Auth::user()->role_id==1)
          <!-- Divider -->
          <hr class="my-3">
          <!-- Heading -->
          <h6 class="navbar-heading p-0 text-muted">
            <span class="docs-normal">Store</span>
          </h6>
          <!-- Navigation -->
          <ul class="navbar-nav mb-md-3">

            <li class="nav-item">
              <a class="nav-link" href="#inventory" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-examples">
                <i class="fas fa-globe text-orange"></i>
                <span class="nav-link-text">&nbsp;Inventory</span>
              </a>
              <div class="collapse p-2" id="inventory">
                <ul class="nav nav-sm flex-column">
                  <li class="nav-item">
                    <a href="{{route('inventory.categories')}}" class="nav-link">
                      <span class="fas fa-bars"></span>&nbsp;
                      <span class="sidenav-normal"> Item Categories</span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{route('inventory.sub_categories.get')}}" class="nav-link">
                      <span class="fas fa-bars"></span>&nbsp;
                      <span class="sidenav-normal"> Item Sub Categories</span>
                    </a>
                  </li>
                  <li class="nav-item">
                  <a href="{{route('inventory.item.new')}}" class="nav-link">
                      <span class="fas fa-plus-circle"></span>&nbsp;
                      <span class="sidenav-normal"> New item </span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{route('inventory.items')}}" class="nav-link">
                      <span class="fas fa-bars"></span>&nbsp;
                      <span class="sidenav-normal"> view items </span>
                    </a>
                  </li>
                
                  <li class="nav-item">
                    <a href="{{route('inventory.suppliers')}}" class="nav-link">
                      <span class="fas fa-bars"></span>&nbsp;
                      <span class="sidenav-normal"> Suppliers </span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{route('inventory.vendors')}}" class="nav-link">
                      <span class="fas fa-bars"></span>&nbsp;
                      <span class="sidenav-normal"> Vendors </span>
                    </a>
                  </li>
                </ul>

              </div>
            </li>

          </ul>
          @endif
          <hr class="my-3">
          <!-- Heading -->
          <h6 class="navbar-heading p-0 text-muted">
            <span class="docs-normal">Services</span>
          </h6>
          <!-- Navigation -->
          <ul class="navbar-nav mb-md-3">
                  <li class="nav-item">
                  <a href="{{route('stale.conn')}}" class="nav-link">
                      <span class="fas fa-plus-circle"></span>&nbsp;
                      <span class="sidenav-normal"> Clean stale connections </span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{route('services.testconnectivity')}}" class="nav-link">
                      <span class="fas fa-bars"></span>&nbsp;
                      <span class="sidenav-normal"> Test connectivity </span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{route('services.status')}}" class="nav-link">
                      <span class="fas fa-plus-circle"></span>&nbsp;
                      <span class="sidenav-normal"> Services status</span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{route('last.conn.attempts')}}" class="nav-link">
                      <span class="fas fa-plus-circle"></span>&nbsp;
                      <span class="sidenav-normal">Last-Connection attempts</span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{route('service.logs')}}" class="nav-link">
                      <span class="fas fa-plus-circle"></span>&nbsp;
                      <span class="sidenav-normal">System Logs</span>
                    </a>
                  </li>

                </ul>
      </div>
    </div>
  </nav>
  <!-- Main content -->
  <div class="main-content" id="panel">
    <!-- Topnav -->
    <nav class="navbar navbar-top navbar-expand navbar-white bg-white border-bottom">
      <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <!-- Navbar links -->
          <ul class="navbar-nav align-items-center  ml-md-auto ">
            <li class="nav-item d-xl-none">
              <!-- Sidenav toggler -->

              <div class="pr-3 sidenav-toggler sidenav-toggler-dark text-dark" data-action="sidenav-pin" data-target="#sidenav-main">
                <div class="sidenav-toggler-inner text-dark">
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                </div>
              </div>
            </li>
            <li class="nav-item d-sm-none">
              <a class="nav-link" href="#" data-action="search-show" data-target="#navbar-search-main">
                <i class="ni ni-zoom-split-in"></i>
              </a>
            </li>
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
              <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
    <div class="header pb-5">
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
    </div>
    <div class="container-fluid mt--6">
      @yield('content')
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
@yield('js')
</body>

</html>
