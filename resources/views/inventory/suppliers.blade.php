@extends('layouts.master')
@section('buttons')
@endsection
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
		    Supliers
			<div class="col-lg-6 col-5 text-right float-right">
				<a href="{{ route('inventory.supplier.new') }}" class="btn btn-sm btn-primary"><i class="fas fa-plus-circle"></i>&nbsp; New Supplier</a>
			  </div>
		  </div>
		  <?php $num=0;?>
            <!-- /.card-header -->
            <div class="card-body">
				<div class="card-body table-responsive p-0">
					<table class="dTable table table-head-fixed text-nowrap table-sm">
						<thead style="color: black">
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
		  			@foreach($suppliers as $s)
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
		  			@endforeach
		  		</tbody>
		  	</table>
		  </div>
			</div>
		</div>
	</div>
</div>

@endsection