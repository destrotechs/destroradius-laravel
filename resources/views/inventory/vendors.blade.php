@extends('layouts.master')
@section('content_header')
Vendors
@endsection
@section('buttons')

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
		    Vendors 
			<div class="col-lg-6 col-5 text-right float-right">
				<a href="{{ route('inventory.vendors.new') }}" class="btn btn-sm btn-primary"><i class="fas fa-plus"></i>&nbsp; New item</a>
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
								<th>Description</th>
								<th>Edit</th>
							</tr>
						</thead>
		  		<tbody>
		  			@foreach($vendors as $s)
		  			<?php $num++;?>
		  				<tr>
		  					<td><?php echo $num;?></td>
		  					<td>{{ $s->vendor }}</td>
		  					<td>{{ $s->description }}</td>
		  					<td><a href="{{ route('vendor.edit',['id'=>$s->id]) }}"><i class="fas fa-edit text-primary"></i></a>&nbsp;<a href="{{ route('vendor.delete',['id'=>$s->id]) }}"><i class="fas fa-trash text-danger"></i></a></td>
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