@extends('layouts.customers')
@section('content')
<div class="card">
	<div class="card-header">
		<h4>Internet Access Plans</h4>
	</div>
	<div class="card-body">
		@forelse($packages->chunk(3) as $package)
		<div class="row">
			@foreach($package as $p)
			<div class="col-md-4">
				<div class="card text-center">
				  <div class="card-header">
				   {{ $p->packagename }} valid for ({{ $p->validdays }} {{ $p->durationmeasure }} (s))
				  </div>
				  <div class="card-body">
				    <p class="card-text">{{ $p->description }}
				    	<br>
				    	<span class="text-success text-bold"><b>{{ $p->currency }}.{{ $p->amount }}</b></span>
				    </p>

				  </div>
				  <div class="card-footer ">

				    <a href="{{ route('user.buybundleplan',['id'=>$p->id]) }}" class="btn btn-primary">Buy Now</a>
				  </div>
				</div>
			</div>
			@endforeach
		</div>
		@empty
		<div class="alert alert-danger">No packages available</div>
		@endforelse
	</div>
</div>
@stop

