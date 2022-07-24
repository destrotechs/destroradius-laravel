@extends('layouts.clientslayout')

@section('content_header')
Pay Via Mpesa
@endsection
@section('content')
<div class="row d-flex justify-content-center">
    <div class="col-md-12">
        <div class="procpar" style="display: none;">
    <div class="card" id="proc">
        <div class="card-body">
            <center>
                <h4>Processing...</h4>
                <hr>
                <div class="loader" id="ld">
                    <div class="spinner-border" style="width: 3rem; height: 3rem;" role="status">
                    <!-- <span class="visually-hidden">Loading...</span> -->
                    </div>
                <div class="spinner-grow" style="width: 3rem; height: 3rem;" role="status">
                  <span class="visually-hidden">Loading...</span>
                </div>
                </div>
                <div class="err"></div>
                <p id="timer"></p>
                <hr>
                <h5>You will be redirected to login page once the transaction completes, please wait...</h5>
                <button class="btn btn-primary" id="retry" style="display: none;">retry</button>
            </center>
        </div>
    </div>
    
</div>
        <div class="card mn">
            <div class="card-header">Paying for account <b>{{ $account_name->account_name??''}}</b>, Please select Package Here</div>
            <div class="card-body row">
                <div class="col-md-4 mt-5">
                <img height="250" width="250" src="{{ asset('images/mp.png') }}" class="rounded-circle">
                <center><h3 class="text-bold amount"></h3></center>
                </div>
                <div class="col-md-8 border p-3">
                    <div class="err"></div>
                <form>
                    <label>Package<small class="text-danger">*</small></label>
                    <select class="form-control select2" required name="package" id="package">
                        <option value="">Choose Package to purchase...</option>
                        @forelse($packages as $p)
                            <option value="{{ $p->packagename }}" {{ isset($packageid)?($packageid==$p->id? 'selected':null):null }}>{{ $p->packagename }}</option>

                        @empty

                        <option value="">No package is available</option>
                        @endforelse
                        </select>
                        <br>
                        {{-- <input type="hidden" name="username" value="{{ $account??'' }}"> --}}
                        <input type="hidden" id="account" name="account" value="{{ $account??'' }}">
                        <input type="hidden" id="account_name" name="account_name" value="{{ $account_name->account_name??'' }}">

                    <label>Phone Number<small class="text-danger">*</small></label>
                    <input type="text" required name="phone" class="form-control">
                    <br>
                    <label>Amount <small class="text-danger">*</small></label>
                    <input name="amount" required class="form-control amnt" type="text">
                    <br>
                    <button type="button" class="btn btn-primary btn-md sub" name="submit">Process Payment</button>
                    {{ csrf_field() }}
                </form>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script type="text/javascript">
    $(document).ready(function(){
        $(".sub").click(function(e){
            var package=$("#package").val();
            var amount=$("input[name='amount']").val();
            var account=$("input[name='account']").val();
            var account_name=$("input[name='account_name']").val();

            var phone=$("input[name='phone']").val();
            var _token=$("input[name='_token']").val();
            if(phone!='' && amount!=''){
                if (confirm("Are you sure you want to purchase "+package+ " at "+amount)) {
                    if(confirm("A prompt will be sent to your phone,input your M-Pesa pin to proceed")){
                    $(".btn-success").empty().html('processing, please wait...').addClass('btn-danger');
                    $("#timer").html( 0 + ":" + 45);
                    startTimer();
                    $("#timer").addClass("d-block");
                    $(".myfrm").hide();
                    $(".procpar").show();
                    $(".mn").hide();
                    var req=$.ajax({
                        method:'POST',
                        url:" {{ route('buybundle.post') }} ",
                        data:{phone:phone,package:package,amount:amount,_token:_token,account:account,account_name:account_name},
                    });
                
                    req.done(function(data){
                        if(data=='error'){
                            $("#timer").empty().removeClass('d-block').fadeOut();
                            $(".btn-danger").empty().html('Failed!');
                            $(".mn").hide();
                            $("h4").empty().html("<i class='fa fa-times fa-4x'></i>").addClass('text-danger');
                            $("h5").hide();
                            $("#retry").show();
                            $("#ld").hide();
                            $(".err").html("Your transaction could not be completed, check your phone number and try again").addClass("alert alert-danger p-3");

                        }else{
                            $("#timer").empty().removeClass('d-block').fadeOut();;
                            $(".btn-danger").empty().html('completed').removeClass('btn-danger').addClass("btn-success");
                            $(".mn").hide();
                            $(".loader").hide();
                            $("h4").empty().html(data).addClass('text-success');
                            $(".err").html("<i class='fa fa-check-circle fa-4x'></i>").addClass("text-success p-3");
                           setTimeout(function(){
                                window.location.replace('http://familywifi.net/login');

                            },5000);
                        }

                    })
                }
                }

            }else{
                $(".err").html("All Fields are Required!").addClass("alert alert-danger");
            }
            e.preventDefault();
        })
        $("#package").change(function(){
            var package = $(this).val();
            var _token=$("input[name='_token']").val();

            if(package){
                $.ajax({
                    method:'POST',
                    url:"{{ route('get.package.cost') }}",
                    data:{package:package,_token:_token},
                    success:function(data){
                        $(".amnt").val(data[0]);
                        $(".amount").html('KES. '+data[0]);
                        if(data[1]=='hotspot'){
                           $(".amnt").attr('readonly','readonly'); 
                        }else{
                           $(".amnt").removeAttr('readonly'); 

                        }
                    }
                })
            }else{
                $(".amnt").val('');
            }
        })
        function startTimer() {
          var presentTime = document.getElementById('timer').innerHTML;
          var timeArray = presentTime.split(/[:]+/);
          var m = timeArray[0];
          var s = checkSecond((timeArray[1] - 1));
          if(s==59){m=m-1}
          //if(m<0){alert('timer completed')}

          document.getElementById('timer').innerHTML =
            m + ":" + s;
          console.log(m)
          setTimeout(startTimer, 1000);
        }

        function checkSecond(sec) {
          if (sec < 10 && sec >= 0) {sec = "0" + sec}; // add zero in front of numbers < 10
          if (sec < 0) {sec = "59"};
          return sec;
        }
        $("#retry").click(function(){
            location.reload();
        })
        $(".amnt").on("keyup",function(){
            var amount = $(this).val();
            $(".amount").html("KES. "+amount);
        })
    })
</script>
@endsection

