@extends('layouts.clientslayout')
@section('page_info')
<nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{route('client.bundles')}}">Home</a></li>
    <li class="breadcrumb-item active" aria-current="page">FREE Package</li>
  </ol>
</nav>
@endsection
@section('content')
<div class="card">
	<div class="card-body">
		<form action="{{ route('buybundle.post') }} " method="post">
			<hr>
			<div id="err"></div>
				<center>
					<div class="display-5">{{$thispackage->packagename}}</div>
					<small>GET FREE ACCESS FOR {{$thispackage->validdays }} {{$thispackage->durationmeasure}} (s)</small>
				</center>
			<br>

			<center>
				<label>Enter Phone to receive Access Code</label>
				<div class="ml-5 mr-5 row col-md-4 col-sm-12">					
<<<<<<< HEAD
				<input type="text" required name="phone" class="form-control phn" placeholder="07....." value="{{Auth::guard('customer')->user()->phone??''}}"></center>
=======
				<input type="text" required name="phone" class="form-control phn" placeholder="0......" value="{{Auth::guard('customer')->user()->phone??''}}"></center>
>>>>>>> feede6987acc94ec406849e2b8af3a4543003eae
				<hr>
			<input type="hidden" name="account" value="{{$account??null}}">
			<input type="hidden" name="package" value="{{$thispackage->packagename}}">
			<center><button class="btn btn-success btn-md pb-2 act" type="submit">ACTIVATE</button></center>
			{{ csrf_field() }}
			</div>
		</form>
	</div>
</div>
@endsection
@section('js')
<script type="text/javascript">
	$(document).ready(function(){
		$(".act").click(function(){
			var phone = $(".phn").val();
			if(phone!=""){
				setTimeout(function(){
					$(".act").attr('disabled','disabled');
				},2000);

			}
			
		})
		setTimeout(function(){
				$(".act").removeAttr('disabled');
			},10000);
	})
</script>
@endsection