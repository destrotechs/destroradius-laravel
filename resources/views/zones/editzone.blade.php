@extends('layouts.master')
@section('content_header')
Edit Zone
@endsection
@section('content')
@if (session('success'))
   <div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>{{ session('success') }}</strong>
</div>
@endif
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="row">
	<div class="col-md-6">
		<div class="card">
			<div class="card-header"><h5>Edit Zone Here</h5></div>
			<div class="card-body">
				<form method="post" action="{{ route('save.edit.zone') }}">
					<div class="form-row">
						<div class="col">
							<label>Zone Name</label>
							<input type="text" name="zonename" class="form-control" value="{{ $zone->zonename }}">
							<input type="hidden" name="id" value="{{ $zone->id }}">
						</div>
					</div>
					<div class="form-row">
						<div class="col">
							<label>Network Type</label>
							<select class="form-control" name="networktype">
								<option value="{{ $zone->networktype }}">{{ $zone->networktype }}</option>
								<option value="hotspot">Hotspot</option>
								<option value="PPPoE">PPPoE</option>
							</select>
						</div>
					</div>
					<hr>
					<div class="form-row">
						<button type="submit" class="btn btn-success btn-md"><i class="fas fa-save"></i> save changes</button>
					</div>
					@csrf
				</form>
			</div>
		</div>
	</div>
</div>
@endsection