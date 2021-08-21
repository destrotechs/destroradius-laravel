@extends('layouts.master')
@section('content_header')
New supplier
@endsection
@section('content')
<div class="row">
	<div class="col-md-7">
		@if (session('success'))
   <div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>{{ session('success') }}</strong>
</div>
@endif
@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong>{{ session('error') }}</strong> 
</div>
@endif
		<div class="card">
			<div class="card-header">
		    Add new supplier
		  </div>
		  <div class="card-body">
			<form method="post" action="{{ route('supplier.post.new') }}">
				@csrf
				<div class="row">
					<div class="col">
						<label>Name</label>
						<input type="text" name="name" class="form-control sm" placeholder="supplier name ...">
					</div>
					<div class="col">
						<label>Address</label>
						<input type="text" name="address" class="form-control sm" placeholder="supplier address ...">
					</div>
				</div>
				<div class="row">
					<div class="col">
						<label>Contact</label>
						<input type="text" name="contact" class="form-control sm" placeholder="supplier contact ...">
					</div>
					<div class="col">
						<label>Phone</label>
						<input type="text" name="phone" class="form-control sm" placeholder="supplier phone ...">
					</div>
				</div>
				<div class="row">
					<div class="col">
						<label>Email</label>
						<input type="email" name="email" class="form-control" placeholder="supplier email...">
					</div>
					<div class="col">
						<label>Zip Code</label>
						<input type="text" name="zipcode" class="form-control" placeholder="zip code...">
					</div>
				</div>
				<div class="row col">
					<label>Description</label>
					<textarea class="form-control" name="description"></textarea>
				</div>
				<hr>
				<button class="btn btn-success btn-md"><i class="fas fa-save"></i> Save</button>
			</form>
		</div>
		</div>
	</div>
	<div class="col-md-5">
			<table class="table bg-white table-sm table-bordered">
				<?php $num=0;?>
				<thead>
					<tr>
						<th colspan="6"><h5>Available suppliers</h5></th>
					</tr>
					<tr>
						<th>#</th>
						<th>Name</th>
						<th>Address</th>
						<th>Contact</th>
						<th>Phone</th>
						<th>Email</th>
					</tr>
				</thead>
				<tbody>
					@forelse($suppliers as $i)
					<?php $num++;?>
						<tr>
							<td><?php echo $num;?></td>
							<td>{{ $i->supplier_name }}</td>
							<td>{{ $i->address }}</td>
							<td>{{ $i->contact }}</td>
							<td>{{ $i->phone }}</td>
							<td>{{ $i->email }}</td>
						</tr>
					@empty
					<tr>
						<td colspan="6" class="text-danger">suppliers not added</td>
					</tr>
					@endforelse
				</tbody>
				<tfoot>
					<tr>
						<td colspan="6">
							@if(count($suppliers)>0)
							<a href="{{ route('inventory.suppliers') }}" class="btn btn-primary btn-sm">More ...</a>
							@endif
						</td>
					</tr>
				</tfoot>
			</table>
	</div>
</div>
@endsection