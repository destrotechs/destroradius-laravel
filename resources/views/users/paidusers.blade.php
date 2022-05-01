@extends('layouts.master')
@section('content_header')
Paid users
@endsection
@section('content')
<div class="card">
	<div class="card-header">Paid Users</div>
	<div class="card-body">
		<?php $num=0;?>
		<table class="table table-responsivetable-bordered table-md">
			<thead>
				<tr>
					<th colspan="4">Paid Users</th>
				</tr>
				<tr>
					<th>#</th>
					<th>Username</th>
					<th>Remaining Time</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				@forelse($paidusers as $p)
				<?php $num++;?>
				<tr>
					<td><?php echo $num;?></td>
					<td>{{ $p->username }}</td>
					<td></td>
					<td></td>
				</tr>
				@empty
				<tr>
					<td colspan="4" class="alert alert-danger">No Paid Users</td>
				</tr>
				@endforelse
			</tbody>
		</table>
	</div>
</div>
@endsection