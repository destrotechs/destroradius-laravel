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
			<div id="err"></div>
				<center>
					<div class="display-5">{{$thispackage->packagename}}</div>
					<small>GET FREE ACCESS FOR {{$thispackage->validdays }} {{$thispackage->durationmeasure}} (s)</small>
				</center>
			<br>

			<center>
				<label>Enter Phone to receive Access Code</label>
				<input type="text" name="phone" class="form-control" placeholder="07....." value="{{Auth::guard('customer')->user()->phone??''}}"></center>
			<input type="hidden" name="account" value="{{$account??null}}">
			<input type="hidden" name="package" value="{{$thispackage->packagename}}">
			<center><button class="btn btn-success btn-md" type="submit">ACTIVATE</button></center>
			{{ csrf_field() }}
		</form>
	</div>
</div>
@endsection
