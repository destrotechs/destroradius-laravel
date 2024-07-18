@extends('layouts.clientslayout')
@section('content')

<h4>Select Account to Pay For</h4><br>
<div class="card">
	<div class="card-header">Choose Account to Pay For Here</div>
<div class="card-body">
	
    @if(count($accounts)>0)
    <form method="POST" action="{{ route('account.payfor') }}">
      <input type="hidden" name="package" class="package">
		@foreach($accounts as $acc)
         <input type="radio" name="account" class="acc" id="{{$acc->package_name}}" value="{{$acc->account_no}}">
         <label>{{$acc->account_name??$acc->account_no}} &nbsp;<span class="badge badge-{{$acc->status=='active'?'success':'danger'}}">{{$acc->status}}</label>
         <br>
      @endforeach
         <hr>
         <input type="hidden" name="packageid" value="{{$pid??null}}">

			<button type="submit" class="btn btn-success btn-large">CONTINUE&nbsp;<i class="fa fa-angle-double-right" aria-hidden="true"></i></button>
			@else
      <div class="alert alert-danger">You Have no linked accounts, Please contact administrator!</div>
      <br>
      @endif
      @csrf

		</form>
</div>
</div>
@endsection
@section('js')
<script type="text/javascript">
$(document).ready(function(){
   $(".acc").click(function(){
      $(".package").val($(this).attr('id'));
   })
})
</script>
@endsection