@extends('layouts.master')
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
            <div class="dropdown-divider mt-2"></div>
            <div class="card-body row">
                <div class="col-md-4 mt-5">
                <img height="250" width="250" src="{{ asset('images/mp.png') }}" class="rounded-circle">
                </div>
                <div class="col-md-8 border p-3 br-2">
                <form>
                    <label>Package</label>
                    <select class="form-control select2" name="package" id="package">
                        <option value="">Choose Package to purchase...</option>
                        @forelse($packages as $p)
                            <option value="{{ $p->packagename }}">{{ $p->packagename }}</option>

                        @empty

                        <option value="">No package is available</option>
                        @endforelse
                        </select>
                        <br>
                    <label>Phone Number</label>
                    <input type="text" name="phone" class="form-control">
                    <br>
                    <label>Amount</label>
                    <input name="amount" readonly class="form-control amnt" type="text">
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
            var phone=$("input[name='phone']").val();
            var _token=$("input[name='_token']").val();
            if(phone!=''){
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
                        data:{phone:phone,package:package,amount:amount,_token:_token},
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
                        }

                    })
                }
                }

            }else{
                $(".err").html("Enter a valid phone number and select a bundle plan").addClass("alert alert-danger");
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
    })
</script>
@endsection

