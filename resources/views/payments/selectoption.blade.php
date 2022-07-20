@extends('layouts.master')
@section('content_header')
Payment Option
@endsection
@section('content')

<div class="card">
	<div class="card-header">
		select your payment option here
	</div>
	<div class="card-body">
		<form method="POST" action="{{ route('pay.option.select') }}">
			<div class="custom-control custom-radio custom-control p-3">
                <input type="radio" id="customRadioInline3" name="paytype" class="custom-control-input" value="mpesa">
                <label class="custom-control-label" for="customRadioInline3"><b>M-pesa</b></label>
              </div>
            <div class="custom-control custom-radio custom-control p-3">
			  <input type="radio" id="customRadioInline1" name="paytype" class="custom-control-input" value="paypal">
			  <label class="custom-control-label" for="customRadioInline1"><b>PayPal</b></label>
			</div>
			<div class="custom-control custom-radio custom-control p-3">
			  <input type="radio" id="customRadioInline2" name="paytype" class="custom-control-input" value="stripe">
			  <label class="custom-control-label" for="customRadioInline2"><b>Stripe</b></label>
			</div>
			<div class="dropdown-divider"></div>
			<button class="btn btn-success btn-large">NEXT</button>
			@csrf
		</form>
	</div>

@endsection
