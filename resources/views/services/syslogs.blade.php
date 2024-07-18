@extends('layouts.master')
@section('content_header')
System Logs
@endsection
@section('content')
@if(isset($error))
<div class="card card-body card-sm bg-danger">
<div class="text-white">{{$error}}</div>
</div>
@else
<div class="card">
	<div class="card-header"><h5>Logs</h5></div>
	<div class="card-body">
		@forelse($logs as $log)
		<?php 
		$log_d = explode("on", $log);
	?>
	@if (count($log_d)>1)
	<div class="card card-body card-sm">
		<small class="badge badge-info text-left">ON {{ $log_d[1] }}</small>
		{{ $log_d[0] }}

	</div>
	@endif
		{{-- <p><i class="fas fa-circle text-danger"></i>&nbsp;{{ $log }}</p> --}}
		@empty
		''
		@endforelse
	</div>
</div>
@endif

@endsection