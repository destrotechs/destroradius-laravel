@extends('layouts.master')
@section('content_header')
Package pricing
@endsection
@section('content')
@if (session('success'))
   <div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>{{ session('success') }}</strong>
  {{-- <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> --}}
</div>
@endif
@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong>{{ session('error') }}</strong> 
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
<div cl

<?php $num=0; ?>
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<a href="{{route('packages.all')}}" class="float-right">
					<span class="fas fa-arrow-left "></span>&nbsp;
					<span class="sidenav-normal">go back</span>
				</a>
			</div>
		</div>
        
	</div>
</div>
<div class="row">
	<div class="col-md-5">
		<div class="card card-body">
			<h5>New Package Price</h5><hr>
	<form action="{{ route('package.price.save') }}" method="POST">
		 @csrf
		
		<label>Package</label>
		<select name="packageid" class="form-control select2">
			<option value="">Select Package...</option>
			@forelse($packages as $p)
			<option value="{{ $p->id }}">{{ $p->packagename }}</option>
			@empty
			<option value="">No packages available</option>
			@endforelse
		</select>
		<label>Currency</label>
		<select name="currency" class="form-control select2">
			<option value="USD($)">USD ($)</option>
			<option value="KSH">KSH</option>
		</select>
		<label>Amount</label>
		<input type="text" name="amount" class="form-control" placeholder="amount">
		<hr>
		<button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Save</button>
	</form>
</div>
	</div>
	<div class="card col-md-7">
		<h5>Priced Packages</h5><hr>
		<div class="card-body table-responsive p-0">
			<table class="dTable table table-head-fixed text-nowrap table-sm">
				<thead style="color: black">
				<tr>
					<th>#</th>
					<th>Package</th>
					<th>Currency</th>
					<th>Price</th>
				</tr>
			</thead>
			
			<tbody>
				@foreach($pricedpackages as $p)
				<?php $num++;?>
				<tr>
					<td><?php echo $num;?></td>
					<td>{{ $p->packagename }}</td>
					<td>{{ $p->currency }}</td>
					<td>{{ $p->amount }}</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
	</div>

@endsection