@extends('layouts.master')
@section('content_header')
Manager payments
@endsection
@section('content')
@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
<div class="card">
	<div class="card-header">Pay Manager</div>
	<div class="card-body">
		<form action="{{ route('pay.manager') }}" method="POST">
			@csrf
			<div class="form-row">
				<div class="col">
					<select name="managerid" class="form-control managers">
						<option value="">Choose manager ...</option>
						@forelse($managers as $m)
						<option value="{{ $m->id }}">{{ $m->name }}</option>
						@empty
						<option value="">No managers available</option>
						@endforelse
					</select>
				</div>
				<div class="col">
					<button class="btn btn-primary btn-md" type="submit">Mark Paid</button>
				</div>
			</div>
		</form>
		<div class="dropdown-divider"></div>
			<table class="table table-sm table-bordered">
				<thead>
					<tr>
						<th>#</th>
						<th>Manager</th>
						<th>Commission</th>
					</tr>
				</thead>
				<tbody class="result-container">
					
				</tbody>
			</table>
	</div>
</div>
@endsection
@section('js')
<script type="text/javascript">
	$(document).ready(function(){
		$(".managers").change(function(){
				var managerid=$(this).val();
			 	var _token=$("input[name='_token']").val();
			 	var req = $.ajax({
			 		method:'POST',
			 		url:"{{ route('getManagerTransactions') }}",
			 		data:{managerid:managerid,_token:_token},
			 	});

			 	req.done(function(result){
			 		$(".result-container").html(result);
			 	})

		})
	})
</script>
@endsection