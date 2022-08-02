@extends('layouts.master')
@section('content_header')
Paid users
@endsection
@section('content')
<div class="card">
	<div class="card-header">Paid Users</div>
	<div class="card-body table-responsive p-0">
		<?php $num=0;?>
			<table class="dTable table table-head-fixed text-nowrap table-sm">
				<thead style="color: black">
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
				@foreach($paidusers as $p)
				<?php $num++;?>
				<tr>
					<td><?php echo $num;?></td>
					<td>{{ $p->username }}</td>
					<td></td>
					<td></td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>
@endsection