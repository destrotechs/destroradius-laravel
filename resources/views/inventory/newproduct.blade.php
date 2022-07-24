@extends('layouts.master')
@section('content_header')
New product
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
			<div class="card-header"><h5>Add product</h5></div>
			<form class="card-body" method="post" action="{{ route('product.post') }}">
				@csrf
				<div class="row">
  					<div class="col">
						<label>Product Name</label>
						<input type="text" class="form-control sm" placeholder="product name ..." name="productname">
					</div>
					<div class="col">
						<label>Product Type</label>
						<input type="text" name="producttype" class="form-control sm" placeholder="Type ...">
					</div>
				</div>
				<div class="row">
					<div class="col">
						<label>Product Vendor</label>
						<input type="text" name="vendor" class="form-control sm" placeholder="vendor ...">
					</div>
					<div class="col">
						<label>Product Price</label>
						<input type="text" name="price" class="form-control sm" placeholder="e.g 500">
					</div>
				</div>
				<hr>
				<button class="btn btn-success"><i class="fas fa-save"></i>&nbsp;save</button>
			</form>
		</div>
	</div>
	<?php $num=0;?>
	<div class="col-md-5">
		<div class="card">
			<div class="card-body table-responsive p-0">
				<table class="dTable table table-head-fixed text-nowrap table-sm">
					<thead style="color: black">
					<tr>
						<th>#</th>
						<th>Name</th>
						<th>Vendor</th>
						<th>Type</th>
						<th>Price</th>
					</tr>
				</thead>
				<tbody>
					@foreach($products as $i)
					<?php $num++;?>
						<tr>
							<td><?php echo $num;?></td>
							<td>{{ $i->name }}</td>
							<td>{{ $i->vendor }}</td>
							<td>{{ $i->producttype }}</td>
							<td>{{ $i->price }}</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		</div>
	</div>
</div>
@endsection