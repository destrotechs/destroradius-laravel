@extends('layouts.master')
@section('content_header')
Edit item
@endsection
@section('content')
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
<div class="card" style="width:40em;">
	<div class="card-header"><h6>Edit</h6></div>
	<div class="card-body">
		<form class="card-body" method="post" action="{{ route('item.post.edit') }}">
				@csrf
				<div class="row">
  					<div class="col">
						<label>Item Name</label>
						<input type="text" class="form-control sm" placeholder="item name ..." name="itemname" value="{{ $item->name }}">
					</div>
					<div class="col">
						<label>Item Type</label>
						<input type="text" name="itemtype" class="form-control sm" placeholder="item type ..." value="{{ $item->type }}">
					</div>
					<input type="hidden" name="id" value="{{ $item->id }}">
				</div>
				<div class="row">
					<div class="col">
						<label>Item Model</label>
						<input type="text" name="itemmodel" class="form-control sm" placeholder="model ..." value="{{ $item->model }}">
					</div>
					<div class="col">
						<label>Item Serial#</label>
						<input type="text" name="itemserial" class="form-control sm" placeholder="serial of all same items separated by commas ..." value="{{ $item->serial }}">
					</div>
				</div>
				<div class="row">
					<div class="col">
						<label>Supplier</label>
						<select class="form-control sm" name="supplierid">
							<option value="">select supplier</option>
						</select>
					</div>
					<div class="col">
						<label>Quantity</label>
						<input type="text" name="itemquantity" class="form-control sm" placeholder="e.g 20" value="{{ $item->quantity }}">
					</div>
				</div>
				
				<label>Cost</label>
				<input type="text" name="cost" class="form-control sm" placeholder="e.g 20" value="{{ $item->cost }}">
				<label>Description</label>
				<textarea type="text" class="form-control sm" name="description">{{ $item->description }} </textarea>
				<hr>
				<button class="btn btn-success"><i class="fas fa-save"></i>&nbsp;save changes</button>
			</form>
	</div>
</div>
@endsection