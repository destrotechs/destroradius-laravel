@extends('layouts.master')
@section('content_header')
System Logs
@endsection
@section('content')
<div class="card">
	<div class="card-header"><h5>Logs</h5></div>
	<div class="card-body">
		@forelse($logs as $log)
		<p><i class="fas fa-circle text-danger"></i>&nbsp;{{ $log }}</p>
		@empty
		''
		@endforelse
	</div>
</div>
@endsection