@extends('layouts.customers')
@section('content')
<div class="procpar" style="display: none;">
	<div class="card" id="proc">
		<div class="card-body">
			<center>
				<h4>Processing...</h4>
				<hr>
				<div class="loader" id="ld">
					<div class="spinner-border" style="width: 3rem; height: 3rem;" role="status">
				  	<span class="visually-hidden">Loading...</span>
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
<div class="myfrm">
@foreach($package as $p)
<h3 class="bg-light p-3">Pay For {{ $p->packagename}}</h3>
<form>
	<div class="err"></div>
<div class="jumbotron">
  <h1 class="display-5">{{ $p->packagename }} /Kes {{ $p->amount }}</h1>
  <p class="text-danger">{{ $p->description }}</p>
  <div class="alert alert-info">you will receive a text message contaning your username and password after a successful payment.</div>
  <input type="hidden" name="package" value="{{ $p->packagename }}">
  <input type="hidden" name="amount" value="{{ $p->amount }}">
  <hr class="my-4">
  @if(isset(Auth::guard('customer')->user()->phone))
  <input type="text" name="phone" class="form-control p-4" value="{{ Auth::guard('customer')->user()->phone }}">
  <small>Mpesa registered number to be charged</small>
  @else
  <input type="text" name="phone" class="form-control p-4" value="" placeholder="Enter Your phone Number to continue">
  <small>Mpesa registered number to be charged</small>
  @endif
  <hr class="my-4">
  {{-- <button class="btn btn-success btn-lg" type="submit">Process Payment</button> --}}
  <input type="button" name="btn" value="Process Payment" class="btn btn-success btn-lg sub">
  <div id="timer"></div>
</div>
{{ csrf_field() }}
</form>
@endforeach
<div class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title font-weight-bold">User Freedom</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Create your own username and password by signing up</p>
        <center><a href="#" class="btn btn-lg btn-primary rounded-pill"><i class="fa fa-rocket"></i>&nbsp;click here to signup</a></center>
      </div>
      <div class="modal-footer">
      	<button type="button" class="btn btn-danger p-3 close" data-dismiss="modal">Dismiss</button>
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
			var package=$("input[name='package']").val();
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
					var req=$.ajax({
						method:'POST',
						url:" {{ route('buybundle.post') }} ",
						data:{phone:phone,package:package,amount:amount,_token:_token},
					});
					// req.done(function(data){
					// 	alert(data);
					// })
                    // setTimeout(function(){
                    //         location.reload();
                    //     },40000);
					req.done(function(data){
						if(data=='error'){

							$("#timer").empty().removeClass('d-block').fadeOut();
						$(".btn-danger").empty().html('Failed!');
						$("#ld").hide();
						$("h4").empty().html("<i class='fa fa-times fa-4x'></i>").addClass('text-danger');
						$("h5").hide();
						$("#retry").show();
						$(".err").html("Your transaction could not be completed, check your phone number and try again").addClass("alert alert-danger p-3");

						}else{
							$("#timer").empty().removeClass('d-block').fadeOut();;
							$(".btn-danger").empty().html('completed').removeClass('btn-danger').addClass("btn-success");
							$("#ld").hide();
							$("h4").empty().html(data).addClass('text-success');
							$(".err").html("<i class='fa fa-check-circle fa-4x'></i>").addClass("text-success p-3");
							// setTimeout(function(){
							// window.location.replace('http://hewanet.wifi/login');
							// },5000);
						}

					})
				}
				}

			}else{
				$(".err").html("Enter a valid phone number and select a bundle plan").addClass("alert alert-danger");
			}
			e.preventDefault();
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
