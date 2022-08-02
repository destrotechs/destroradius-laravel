@extends('layouts.master')
@section('content_header')
last connection attempts
@endsection
@section('content')
<div class="card">
	<div class="card-header">last connection attempts</div>
	<div class="card-body table-responsive p-0">
		<table class="dTable table table-head-fixed text-nowrap table-sm">
			<thead style="color: black">
				<tr>
					<th>Username</th>
					<th>Password</th>
					<th>Server Reply</th>
					<th>Date</th>
				</tr>
			</thead>
			<tbody>
				@foreach($attempts as $a)
				@if($a->reply=='Access-Accept')
				<tr class="bg-success text-white fw-bold p-2">
					<td>{{ $a->username }}</td>
					<td>{{ $a->pass }}</td>
					<td>{{ $a->reply }}</td>
					<td>{{ $a->authdate }}</td>
				</tr>
				@else
				<tr class="bg-danger fw-bold text-white p-2">
					<td>{{ $a->username }}</td>
					<td>{{ $a->pass }}</td>
					<td>{{ $a->reply }}</td>
					<td>{{ $a->authdate }}</td>
				</tr>
				@endif
				@endforeach
			</tbody>
		</table>
	</div>
</div>
</div>
@endsection