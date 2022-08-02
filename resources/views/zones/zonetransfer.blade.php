@extends('layouts.master')
@section('content_header')
Transfer Zone
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
			<div class="card-header"><h5>Transfer {{ $zone->zonename }} to another manager</h5></div>
			<div class="card-body">
				<form method="post" action="{{ route('transfer.zone.save') }}">
					<div class="form-row">
						<div class="col">
							<label>Manager</label>
							<select class="form-control select2" name="managerid">
								<option value="">select manager...</option>
								@forelse($managers as $m)
								<option value="{{ $m->id }}">{{ $m->name }}</option>
								@empty
								<option value="">No managers without a zone</option>
								@endforelse
							</select>
						</div>
						</div>
						<input type="hidden" name="id" value="{{ $zone->id }}">
					<hr>
					<div class="form-row">
						<button type="submit" class="btn btn-success btn-md"><i class="fas fa-save"></i>Transfer to Manager</button>
					</div>
					@csrf
				</form>
			</div>
		</div>
	</div>
</div>
@endsection