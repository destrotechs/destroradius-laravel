@extends('layouts.master')
@section('content_header')
Paypal Payment
@stop
@section('content')

<div class="card text-center">
	<div class="card-header"><h4>Pay Via Paypal</h4></div>
  <div class="card-body">
    <form>
    	<div class="form-row">
    		<label>Choose package to pay for</label>
    		<select class="form-control select2" name="package">
    			<option>Choose...</option>
    			<option>Package</option>
    		</select>
    	</div>
    	<hr>
    	<center>
    	<div class="form-row">    		
    		<div id="paypal-button-container"></div>    
    	</div>
    	</center>
    </form>
  </div>
</div>

@stop
@section('js')
<script src="https://www.paypal.com/sdk/js?client-id=AUoeQFDZUHv8UVam4zbpnDTr5kcrryFukTTS496RtKdbv_4rG4dE_owiPpSFs61i_WOab9jEfx_vmw2J"> // Replace YOUR_CLIENT_ID with your sandbox client ID
    </script><script type="text/javascript">
      paypal.Buttons({
        createOrder: function(data, actions) {
          return actions.order.create({
            purchase_units: [{
              amount: {
                value: '0.01'
              }
            }]
          });
        },
        onApprove: function(data, actions) {
          return actions.order.capture().then(function(details) {
            alert('Transaction completed by ' + details.payer.name.given_name);
          });
        }
      }).render('#paypal-button-container'); // Display payment options on your web page
    </script>
@stop