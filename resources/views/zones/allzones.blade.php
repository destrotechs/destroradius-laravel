@extends('layouts.master')
@section('content_header')
All Zones
@endsection
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header"><h5>Added Zones</h5></div>
			<div class="card-body">
				<table class="table table-bordered table-striped">
					<thead>
						<tr>
							<th>#</th>
							<th>Zone Name</th>
							<th>Network Type</th>
							<th>Manager</th>
							@if(Auth::user()->role_id==1)
							<th>edit</th>
							@endif
						</tr>
					</thead>
					<?php $num=0;?>
					<tbody>
						@forelse($zones as $z)
						<?php $num++;?>
						<tr>
							<td><?php echo $num;?></td>
							<td>{{ $z->zonename }}</td>
							<td>{{ $z->networktype }}</td>
							<td>{{ $z->name }}</td>
							@if(Auth::user()->role_id==1)
							<td><a href="{{ route('zone.edit',['id'=>$z->id]) }}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>&nbsp;<a href="{{ route('delete.zone',['id'=>$z->id]) }}" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>&nbsp;<a href="{{ route('zone.transfer',['id'=>$z->id]) }}" class="btn btn-info btn-sm"><i class="fas fa-bolt"></i>&nbsp;transfer</a></td>
							@endif
						</tr>
						@empty
						<tr>
							<td colspan="5" class="text-danger">No zones added yet</td>
						</tr>
						@endforelse
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@endsection