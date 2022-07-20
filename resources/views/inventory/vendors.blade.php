@extends('layouts.master')
@section('content_header')
Vendors
@endsection
@section('buttons')
<div class="col-lg-6 col-5 text-right">
  <a href="{{ route('inventory.vendors.new') }}" class="btn btn-sm btn-neutral"><i class="fas fa-plus"></i>&nbsp; New item</a>
</div>
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
		  </div>
		  <?php $num=0;?>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example2" class="table table-sm table-responsivetable-bordered table-hover table-sm">
		  		<thead>
		  			<tr>
		  				<th>#</th>
		  				<th>Name</th>
		  				<th>Description</th>
		  				<th>Edit</th>
		  			</tr>
		  		</thead>
		  		<tbody>
		  			@forelse($vendors as $s)
		  			<?php $num++;?>
		  				<tr>
		  					<td><?php echo $num;?></td>
		  					<td>{{ $s->vendor }}</td>
		  					<td>{{ $s->description }}</td>
		  					<td><a href="{{ route('vendor.edit',['id'=>$s->id]) }}"><i class="fas fa-edit text-primary"></i></a>&nbsp;<a href="{{ route('vendor.delete',['id'=>$s->id]) }}"><i class="fas fa-trash text-danger"></i></a></td>
		  				</tr>
		  			@empty
		  			<tr>
		  				<td colspan="7" class="text-danger align-self-center">vendors not added</td>
		  			</tr>
		  			@endforelse
		  		</tbody>
		  		<tfoot>
		  			<tr>
		  				<td colspan="7" class="">{!! $vendors->links() !!}</td>
		  			</tr>
		  		</tfoot>
		  	</table>
		  </div>
		</div>
	</div>
</div>

@endsection