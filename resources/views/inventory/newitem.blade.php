@extends('layouts.master')
@section('content_header')
New item
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
			<div class="card-header sm"><h5>Add item</h5></div>
			<form class="card-body" method="post" action="{{ route('item.post') }}">
				@csrf
				<div class="row">
  					<div class="col">
						<label>Category</label>
						<select name="category_code" class="form-control" required id="category">
							<option>Select sub category</option>
							@forelse($categories as $c)
							<option value="{{ $c->category_code }}">{{ $c->description }}</option>
							@empty
							<option value="">No categories available</option>
							@endforelse
						</select>
					</div>
					<div class="col">
						<label>SubCategory</label>
						<select id="subcategories" name="sub_category_code" class="form-control" required>
							
						</select>
					</div>
				</div>
				<div class="row">
  					<div class="col">
						<label>Item Code</label>
						<input type="text" class="form-control sm" placeholder="item Code ..." name="item_code" required>
					</div>
					<div class="col">
						<label>Item Name</label>
						<input type="text" class="form-control sm" placeholder="item name ..." name="itemname" required>
					</div>
					
				</div>
				<div class="row">
					<div class="col">
						<label>Item Type</label>
						<input type="text" name="itemtype" class="form-control sm" placeholder="item type ...">
					</div>
					<div class="col">
						<label>Item Model</label>
						<input type="text" name="itemmodel" class="form-control sm" placeholder="model ...">
					</div>
					
				</div>
				<div class="row">
					<div class="col">
						<label>Item Serial#</label>
						<input type="text" name="itemserial" class="form-control sm" placeholder="serial of all same items separated by commas ...">
					</div>
					<div class="col">
						<label>Supplier</label>
						<select class="form-control sm" name="supplierid">
							<option value="">select supplier</option>
						</select>
					</div>
				</div>
				<div class="row">
					<div class="col">
						<label>Quantity</label>
						<input type="text" name="itemquantity" class="form-control sm" placeholder="e.g 20" required>
					</div>
				<div class="col">
					<label>Cost</label>
					<input type="text" name="cost" class="form-control sm" placeholder="e.g 20">
				</div>
				</div>
				<label>Description</label>
				<textarea type="text" class="form-control sm" name="description"></textarea>
				<hr>
				<button class="btn btn-success"><i class="fas fa-save"></i>&nbsp;save</button>
			</form>
		</div>
	</div>
	<?php $num=0;?>
	<div class="col-md-5">
		<div class="card">
			<table class="table table-sm table-responsivetable-sm table-responsive">
				<thead>
					<tr>
						<th>#</th>
						<th>Name</th>
						<th>Model</th>
						<th>Type</th>
						<th>Serial</th>
						<th>Quantity</th>
					</tr>
				</thead>
				<tbody>
					@forelse($items as $i)
					<?php $num++;?>
						<tr>
							<td><?php echo $num;?></td>
							<td>{{ $i->name }}</td>
							<td>{{ $i->model }}</td>
							<td>{{ $i->type }}</td>
							<td>{{ $i->serial }}</td>
							<td>{{ $i->quantity }}</td>
						</tr>
					@empty
					<tr>
						<td colspan="6" class="text-danger">items not added</td>
					</tr>
					@endforelse
				</tbody>
				<tfoot>
					<tr>
						<td colspan="6"><a href="{{ route('inventory.items') }}" class="btn btn-primary btn-sm">More ...</a></td>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
</div>
@endsection
@section('js')
<script type="text/javascript">
	$(document).ready(function(){
		$("#category").change(function(){
			let category = $(this).val()
			if (category!=""){
				$.ajax({
					url:"/inventory/sub_categories/"+category,
					method:'GET',
					success:function(data){
						if (data.length>0){
							data.map(function(sub_cat){
								$("#subcategories").append("<option value="+ sub_cat['sub_category_code'] +">"+sub_cat['description']+"</option>")
								// alert(sub_cat['sub_category_code']);
							})
						}else{
							$("#subcategories").empty();
						}
					}
				})
			}
		})
		function createOption(sub_cat){

		}
	})
</script>
@endsection