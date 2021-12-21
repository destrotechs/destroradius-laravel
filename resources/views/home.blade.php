@extends('layouts.master')
{{-- @section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop --}}
@section('buttons')
<div class="col-lg-6 col-5 text-right">
  <a href="#" class="btn btn-sm btn-neutral">New</a>
  <a href="#" class="btn btn-sm btn-neutral">Filters</a>
</div>
@endsection
@section('content')
      <div class="row">
            <div class="col-xl-3 col-md-6">
              <div class="card card-stats">
                <!-- Card body -->
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">CPU traffic</h5>
                      <span class="h2 font-weight-bold mb-0"><?php
                        $load = sys_getloadavg();
                        echo $load[0]."%";
                      ?></span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-gradient-red text-white rounded-circle shadow">
                        <i class="ni ni-active-40"></i>
                      </div>
                    </div>
                  </div>

                </div>
              </div>
            </div>
            <div class="col-xl-3 col-md-6">
              <div class="card card-stats">
                <!-- Card body -->
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">New users</h5>
                      <span class="h2 font-weight-bold mb-0">{{$total_users}}</span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-gradient-orange text-white rounded-circle shadow">
                        <i class="fa fa-users"></i>
                      </div>
                    </div>
                  </div>

                </div>
              </div>
            </div>
            <div class="col-xl-3 col-md-6">
              <div class="card card-stats">
                <!-- Card body -->
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Sales</h5>
                      <span class="h2 font-weight-bold mb-0">{{ $total_sales }}</span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-gradient-green text-white rounded-circle shadow">
                        <i class="ni ni-money-coins"></i>
                      </div>
                    </div>
                  </div>

                </div>
              </div>
            </div>
            <div class="col-xl-3 col-md-6">
              <div class="card card-stats">
                <!-- Card body -->
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Online users</h5>
                      <span class="h2 font-weight-bold mb-0">{{ $total_online_users }}</span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-gradient-info text-white rounded-circle shadow">
                        <i class="ni ni-chart-bar-32"></i>
                      </div>
                    </div>
                  </div>

                </div>
              </div>
            </div>
          </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-center"><h4>Package Sales</h4></div>
                <div class="card-body" id="sales_chart">


                </div>
            </div>
        </div>
    </div>
@stop
@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
<script>
    const chart = new Chartisan({
      el: '#sales_chart',
      url: "@chart('package_sales_chart')",
      hooks:new ChartisanHooks()
      .colors()
      .datasets([{type:'line',fill:false,color:'red'}])
    });
  </script>
@stop
