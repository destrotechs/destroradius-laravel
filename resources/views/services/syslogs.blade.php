@extends('layouts.master')
@section('content_header')
System Logs
@endsection
@section('content')
<div class="card">
	<div class="card-header">System Logs</div>
	<div class="card-body table-responsive p-0">
		<?php $num=1;?>
			<table class="dTable table table-head-fixed text-nowrap table-sm">
				<thead style="color: black">
				<tr>
					<th>#</th>
					<th>On Date</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				@foreach($logs as $log)
				<?php 
					$log_d = explode("on", $log);
				?>
				@if (count($log_d)>1)
				<tr>
					<td>{{ $num++ }}</td>
					<td>{{ $log_d[1] }}</td>
					<td>{{ $log_d[0] }}</td>
				</tr>
				@endif
				@endforeach
			</tbody>
		</table>
	</div>
</div>


@endsection