@extends('layouts.master')
@section('content_header')
Products
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
<div class="card">
            <div class="card-header">
              <h3 class="card-title">Available Products</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example2" class="table table-sm table-responsivetable-bordered table-hover">
              	<?php $num=0;?>
                <thead>
					<tr>
						<th>#</th>
						<th>Name</th>
						<th>Vendor</th>
						<th>Type</th>
						<th>Price</th>
						<th>Edit</th>
					</tr>
				</thead>
				<tbody>
					@forelse($products as $i)
					<?php $num++;?>
						<tr>
							<td><?php echo $num;?></td>
							<td>{{ $i->name }}</td>
							<td>{{ $i->vendor }}</td>
							<td>{{ $i->producttype }}</td>
							<td>{{ $i->price }}</td>
							<td><a href="{{ route('edit.product',['id'=>$i->id]) }}"><i class="fas fa-edit"></i>&nbsp;</a>&nbsp;<a href="{{ route('product.delete',['id'=>$i->id]) }}"><i class="fas fa-trash text-danger"></i>&nbsp;</a></td>
						</tr>
					@empty
					<tr>
						<td colspan="5" class="text-danger">products not added</td>
					</tr>
					@endforelse
				</tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
@endsection