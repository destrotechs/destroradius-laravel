@extends('layouts.master')
@section('content_header')
nas accounting
@stop
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<a href="{{route('nas.view')}}" class="float-right">
					<span class="fas fa-arrow-left "></span>&nbsp;
					<span class="sidenav-normal">go back</span>
				</a>
			</div>
		</div>
        
	</div>
</div>
<div class="card">
	<div class="card-header"></div>
	<div class="card-body">
		<form id="useraccounting">
			<div class="form-row">
				<div class="col">
					<select class="form-control nas">
						<option value="">Choose nas ...</option>
						@forelse($nas as $n)
						<option value="{{ $n->nasname }}">{{ $n->nasname }}</option>
						@empty
						<option>No nas is available</option>
						@endforelse
					</select>
				</div>
				<div class="col">
					<button class="btn btn-md btn-primary" type="submit">Search</button>
				</div>
			</div>
			@csrf
		</form>
		<div class="dropdown-divider"></div>
		<div class="output"></div>
	</div>
</div>
@stop
@section('js')
<script type="text/javascript">
	$(document).ready(function(){
		$(".nas").on('change',function(){
			var nas=$(this).val();
			var _token=$("input[name='_token']").val();

			if(nas!=""){
				fetchAccounts(nas,_token);
			}else{
				$(".output").empty();
			}
		})

		$("#useraccounting").on('submit',function(){
			var nas=$(".nas").val();
			var _token=$("input[name='_token']").val();

			if(nas!=""){
				fetchAccounts(nas,_token);
			}else{
				$(".output").empty();
			}
		})

		function fetchAccounts(nas,_token){
			var req = $.ajax({
				method:"POST",
				url:"{{ route('nasaccounting') }}",
				data:{nas:nas,_token:_token},
			})

			req.done(function(result){
				$(".output").html(result);
			})
		}
	})
	
</script>
@stop