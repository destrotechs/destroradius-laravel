@extends('layouts.master')
@section('content_header')
last connection attempts
@endsection
@section('content')
<div class="card">
	<div class="card-header">last connection attempts</div>
	<div class="card-body">
		<table class="table table-bordered table-sm">
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
				<tr>
					<td>{{ $a->username }}</td>
					<td>{{ $a->pass }}</td>
					<td>{{ $a->reply }}</td>
					<td>{{ $a->authdate }}</td>
				</tr>
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