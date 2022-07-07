@extends('layouts.clientslayout')
@section('content')

<h4>Select Account to Pay For</h4><br>
<div class="card">
	<div class="card-header">Choose Account to Pay For Here</div>
<div class="card-body">
	<form method="POST" action="{{ route('account.payfor') }}">
    @if(count($accounts)>0)
		@foreach($accounts as $acc)
		<input type="hidden" name="package" value="{{ $acc->package_name }}">
		<div class="custom-control custom-radio custom-control p-3">
        <input type="radio" id="customRadioInline" name="account" class="custom-control-input" value="{{ $acc->account_no}}">
        <label class="custom-control-label" for="customRadioInline"><b>({{ $acc->account_name??'' }})</b><small class="badge ml-5 badge-{{ $acc->status=='active'?'success':'danger' }}">{{ $acc->status }}</small></label>
      </div>      
      @endforeach
         <input type="hidden" name="packageid" value="{{$pid??null}}">
         <hr>
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