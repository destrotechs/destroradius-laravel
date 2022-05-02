{{-- @extends('adminlte::page') --}}
@extends('layouts.master')
@section('content_header')
 Services Status
@endsection
@section('content')
    <div class="card card-body">
        @if (session('message'))
			    <div class="alert alert-success">
			        {{ session('message') }}
			    </div>
			@endif
			@if (session('error'))
			    <div class="alert alert-danger">
			        {{ session('error') }}
			    </div>
			@endif
<?php
function check_service($sname) {
	if ($sname != '') {
		system("pgrep ".escapeshellarg($sname)." >/dev/null 2>&1", $ret_service);
		if ($ret_service == 0) {
			return "Enabled";
		} else {
			return "Disabled";
		}
	} else {
		return "no service name";
	}
}

?>
	<table class="table table-responsivetable-bordered table-striped">
		<thead>
			<tr>
				<th>Service</th>
				<th>Status</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<form method="post" action="#">
			<tr>
				<td>Radius</td>
				<td><?php echo check_service('radius');?></td>
				<td>
					@if(Auth::user()->role_id==1)
					<a href="{{ route('restart.service',['service'=>'freeradius']) }}" class="btn btn-sm btn-outline-danger">Restart Service</a>
					@endif
				</td>
			</tr>
			<tr>
				<td>Apache/Web Server</td>
				<td><?php echo check_service('apache2');?></td>
				<td>
					@if(Auth::user()->role_id==1)

					<a href="{{ route('restart.service',['service'=>'apache2']) }}" class="btn btn-sm btn-outline-danger">Restart Service</a>
					@endif
				</td>
			</tr>
			<tr>
				<td>Mysql</td>
				<td><?php echo check_service('mysql');?></td>
				<td>
					@if(Auth::user()->role_id==1)
					<a href="{{ route('restart.service',['service'=>'mysql']) }}" class="btn btn-sm btn-outline-danger">Restart Service</a>
					@endif
				</td>
			</tr>
		</form>
		</tbody>
	</table>
</div>
@endsection