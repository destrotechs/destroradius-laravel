@extends('layouts.master')
@section('content_header')
last connection attempts
@endsection
@section('content')
<div class="card">
	<div class="card-header">last connection attempts</div>
	<div class="card-body">
		<table class="table table-sm table-responsivetable-bordered table-sm">
			<thead>
				<tr>
					<th>Username</th>
					<th>Password</th>
					<th>Server Reply</th>
					<th>Date</th>
				</tr>
			</thead>
			<tbody>
				@forelse($attempts as $a)
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
				@empty
				<tr>
					<td colspan="4" class="alert alert-danger">No connections have been tried yet</td>
				</tr>
				@endforelse
			</tbody>
			<tfoot>
				<tr>
					<td colspan="4">{!! $attempts->links() !!}</td>
				</tr>
			</tfoot>
		</table>
	</div>
</div>
@endsection