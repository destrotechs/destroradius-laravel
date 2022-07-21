@extends('layouts.master')
@section('content_header')
New Zone
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
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<a href="{{route('zone.all')}}" class="float-right">
					<span class="fas fa-arrow-left "></span>&nbsp;
					<span class="sidenav-normal">go back</span>
				</a>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="card">
			<div class="card-header"><h5>Add New Zone Here</h5></div>
			<div class="card-body">
				<form method="post" action="{{ route('zones.add.new') }}">
					<div class="form-row">
						<div class="col">
							<label>Zone Name</label>
							<input type="text" name="zonename" class="form-control" placeholder="zone name ...">
						</div>
					</div>
					{{-- <div class="form-row">
						<div class="col">
							<label>Network Type</label>
							<select class="form-control" name="networktype">
								<option value="">select network type...</option>
								<option value="hotspot">Hotspot</option>
								<option value="PPPoE">PPPoE</option>
							</select>
						</div>
					</div> --}}
					<hr>
					<div class="form-row">
						<button type="submit" class="btn btn-success btn-md"><i class="fas fa-save"></i> Add Zone</button>
					</div>
					@csrf
				</form>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="card">
			<div class="card-header"><h5>Assign Zone To a Manager</h5></div>
			<div class="card-body">
				<form method="post" action="{{ route('zones.new.manager') }}">
					<div class="form-row">
						<div class="col">
							<label>Manager</label>
							<select class="form-control" name="managerid">
								<option value="">select manager...</option>
								@forelse($managers as $m)
								<option value="{{ $m->id }}">{{ $m->name }}</option>
								@empty
								<option value="">No managers without a zone</option>
								@endforelse
							</select>
						</div>
						</div>
						<div class="form-row">
						<div class="col">
							<label>Zone</label>
							<select class="form-control" name="zoneid">
								<option value="">select zone ...</option>
								@forelse($zones as $m)
								<option value="{{ $m->id }}">{{ $m->zonename }}</option>
								@empty
								<option value="">No zones without managers</option>
								@endforelse
							</select>
						</div>
					</div>
					<hr>
					<div class="form-row">
						<button type="submit" class="btn btn-success btn-md"><i class="fas fa-save"></i> Assign Manager</button>
					</div>
					@csrf
				</form>
			</div>
		</div>
	</div>
</div>
@endsection