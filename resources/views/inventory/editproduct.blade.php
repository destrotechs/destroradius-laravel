@extends('layouts.master')
@section('content_header')
Edit Product
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
			<div class="card-header sm"><h5>Edit</h5></div>
			<form class="card-body" method="post" action="{{ route('product.post.edit') }}">
				@csrf
				<div class="row">
  					<div class="col">
						<label>Product Name</label>
						<input type="text" class="form-control sm" placeholder="product name ..." name="productname" value="{{ $product->name }}">
					</div>
					<div class="col">
						<label>Product Type</label>
						<input type="text" name="producttype" class="form-control sm" placeholder="Type ..." value="{{ $product->producttype }}">
					</div>
				</div>
				<div class="row">
					<div class="col">
						<label>Product Vendor</label>
						<input type="text" name="vendor" class="form-control sm" placeholder="vendor ..." value="{{ $product->vendor }}">
					</div>
					<input type="hidden" name="id" value="{{ $product->id }}">
					<div class="col">
						<label>Product Price</label>
						<input type="text" name="price" class="form-control sm" value="{{ $product->price }}" placeholder="e.g 500">
					</div>
				</div>
				<hr>
				<button class="btn btn-success"><i class="fas fa-save"></i>&nbsp;save changes</button>
			</form>
		</div>
	</div>
	@endsection