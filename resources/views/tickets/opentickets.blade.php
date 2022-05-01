@extends('layouts.master')
@section('content_header')
Open Tickets
@endsection
@section('content')
@if (session('success'))
   <div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>{{ session('success') }}</strong>
</div>
@endif
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header"><h5>Available Tickets</h5></div>
			<div class="card-body">
				<table class="table table-responsivetable-bordered">
					<thead>
						<tr>
							<td>#</td>
							<td>subject</td>
							<td>Customer</td>
							<td>Priority</td>
							<td>Status</td>
							<td>Package</td>
							<th>Price</th>
							<td>Assigned To</td>
							<td>Edit</td>
						</tr>
					</thead>
					<tbody>
						<?php $num=0;?>
						@forelse($tickets as $t)
						<?php $num++;?>
							<tr>
								<td><?php echo $num;?></td>
								<td>{{ $t->subject }}</td>
								<td>{{ $t->customer_username }}</td>
								<td>{{ $t->priority }}</td>
								<td>{{ $t->status }}</td>
								<td>{{ $t->package }}</td>
								<td>{{ $t->cost }}</td>
								<td>{{ $t->assignedto }}</td>
								<td><a href="{{ route('delete.ticket',['id'=>$t->id]) }}" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>&nbsp;<a href="{{ route('sell.ticket',['id'=>$t->id]) }}" class="btn btn-success btn-sm"><i class="fas fa-check text-white"></i>&nbsp;sell</a></td>
							</tr>
						@empty
							<tr>
								<td colspan="8">no tickets available</td>
							</tr>
						@endforelse
					</tbody>
                    <tfoot>
                        <tr>
                        <td colspan="9">{!! $tickets->links() !!}</td>
                        </tr>
                    </tfoot>
				</table>
			</div>
		</div>

	</div>
	{{-- <div class="col-md-5"></div> --}}
</div>
@endsection
