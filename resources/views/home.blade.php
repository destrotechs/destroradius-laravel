@extends('layouts.master')
{{-- @section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop --}}
@section('buttons')

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
                      <span class="h2 font-weight-bold mb-0">
                         <?php
                        // $load = sys_getloadavg();
                        $load = [0];
                       
                      ?>
                        <div class="progress" style="height: 14px;">
                          <div class="progress-bar progress-bar-striped bg-info" role="progressbar" style="width: 25%;" aria-valuenow="{{ $load[0] }}" aria-valuemin="0" aria-valuemax="100">{{ $load[0] }}%</div>
                        </div>
                       </span>
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
                      <h5 class="card-title text-uppercase text-muted mb-0">SMS balance</h5>
                      <span class="h2 font-weight-bold mb-0 smsb"></span>
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
@stop
@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
 <script src="https://unpkg.com/echarts/dist/echarts.min.js"></script>
 <script src="https://unpkg.com/@chartisan/echarts/dist/chartisan_echarts.js"></script>
<script>
    const chart = new Chartisan({
      el: '#sales_chart',
      url: "@chart('package_sales_chart')",
      hooks:new ChartisanHooks()
      .legend()
      .colors()
      .datasets([{type:'line',fill:true,color:'green'}])
      .axis(true)
      .tooltip()

    });
    const chart2 = new Chartisan({
      el: '#monthly_sale',
      url: "@chart('monthly_sales')",
      hooks:new ChartisanHooks()
      .colors()
      .legend()
      .datasets([{type:'bar',fill:false,color:'skyblue'}])
      .axis(true)
      .tooltip(),
    });
    const chart3 = new Chartisan({
      el: '#inv_chart',
      url: "@chart('items_chart')",
      hooks:new ChartisanHooks()
      .colors()
      .legend()

      .datasets([{type:'bar',fill:false,color:'skyblue'}])
      .axis(true)

      .tooltip(),
    });
    window.setTimeout( function() {
      window.location.reload();
    }, 60000);
  </script>

  <script type="text/javascript">
    $(document).ready(function(){
      getBalance();

      setInterval(function(){
        getBalance();
      },30000);

      function getBalance(){
        $.ajax({
          method:'GET',
          url:"{{ route('sms.balance') }}",
          success:function(balance){
            if(balance){
              $(".smsb").empty().html(balance);
            }else{
              $(".smsb").html("Loading...");
            }
          }
        })
      }
    })
  </script>
@stop
