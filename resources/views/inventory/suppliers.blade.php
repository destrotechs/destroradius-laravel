@extends('layouts.master')
@section('content_header')
Suppliers
@endsection
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="card">
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
		  <div class="card-header">
		    Supliers <a class="btn btn-primary float-right" href="{{ route('inventory.supplier.new') }}"><i class="fas fa-plus"></i> &nbsp;New Supplier</a>
		  </div>
		  <?php $num=0;?>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example2" class="table table-responsivetable-bordered table-hover table-sm">
		  		<thead>
		  			<tr>
		  				<th>#</th>
		  				<th>Name</th>
		  				<th>Contact</th>
		  				<th>Address</th>
		  				<th>Phone</th>
		  				<th>Email</th>
		  				<th>Edit</th>
		  			</tr>
		  		</thead>
		  		<tbody>
		  			@forelse($suppliers as $s)
		  			<?php $num++;?>
		  				<tr>
		  					<td><?php echo $num;?></td>
		  					<td>{{ $s->supplier_name }}</td>
		  					<td>{{ $s->contact }}</td>
		  					<td>{{ $s->address }}</td>
		  					<td>{{ $s->phone }}</td>
		  					<td>{{ $s->email }}</td>
		  					<td><a href="{{ route('supplier.edit',['id'=>$s->id]) }}"><i class="fas fa-edit text-primary"></i></a>&nbsp;<a href="{{ route('supplier.delete',['id'=>$s->id]) }}"><i class="fas fa-trash text-danger"></i></a></td>
		  				</tr>
		  			@empty
		  			<tr>
		  				<td colspan="7" class="text-danger align-self-center">suppliers not added</td>
		  			</tr>
		  			@endforelse
		  		</tbody>
		  		<tfoot>
		  			<tr>
		  				<td colspan="7" class="">{!! $suppliers->links() !!}</td>
		  			</tr>
		  		</tfoot>
		  	</table>
		  </div>
		</div>
	</div>
</div>

@endsection