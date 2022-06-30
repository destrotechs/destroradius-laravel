@extends('layouts.clientslayout')
@section('content')

<h4>Select Account to Pay For</h4><br>
<div class="card">
<div class="card-body">
	<form method="POST" action="{{ route('account.payfor') }}">
		@forelse($accounts as $acc)
		<input type="hidden" name="package" value="{{ $acc->package_name }}">
			<div class="custom-control custom-radio custom-control p-3">
                <input type="radio" id="customRadioInline3" name="account" class="custom-control-input" value="{{ $acc->account_no}}">
                <label class="custom-control-label" for="customRadioInline3"><b>{{ $acc->account_no}}</b></label>
              </div>
         @empty
         <div class="alert alert-danger">You Have no linked accounts, Please wait as your are being redirected!</div>
         <br>

         @endforelse
         <input type="hidden" name="packageid" value="<?php
         $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
			// Append Host Name and requested resource location
			$url .= $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
          $parts = explode("/", $url);
			echo end($parts);?>">
			<button type="submit" class="btn btn-success btn-large">NEXT</button>
			@csrf
		</form>
</div>
</div>
@endsection