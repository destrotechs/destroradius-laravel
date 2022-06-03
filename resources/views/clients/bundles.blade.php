@extends('layouts.clientslayout')

@section('content')
		@forelse($packages->chunk(3) as $package)
    <div class="row row-cols-1 row-cols-md-3 mb-3 text-center">
		@foreach($package as $p)
			<div class="col">
		        <div class="card mb-4 rounded-3 shadow-sm">
		          <div class="card-header py-3">
		            <h5 class="my-0 fw-normal">{{ $p->packagename }} valid for ({{ $p->validdays }} {{ $p->durationmeasure }} (s))</h5>
		          </div>
		          <div class="card-body">
		            <h1 class="card-title pricing-card-title">{{ $p->currency }}.{{ $p->amount }}<small class="text-muted fw-light">/{{ $p->durationmeasure }}</small></h1>
		            <ul class="list-unstyled mt-3 mb-4">
		              <li>{{ $p->description }}
				    	<br>
				    	<span class="text-success text-bold"><b>{{ $p->currency }}.{{ $p->amount }}</b></span></li>
		            </ul>
		            <br>
		            <br>
		             <a href="{{ route('user.buybundleplan',['id'=>$p->id]) }}" class="w-100 btn btn-lg btn-primary">Buy Now</a>
		          </div>
		        </div>
		      </div>
			@endforeach
		</div>
		@empty
		<div class="alert alert-danger">No packages available</div>
		@endforelse
@stop

