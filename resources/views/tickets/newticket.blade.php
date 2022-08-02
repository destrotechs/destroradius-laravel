@extends('layouts.master')

@section('content_header')
New Tickets
@endsection
@section('content')
<div class="warn"></div>
<div class="card">
	<div class="card-body">
		<div class="" id="accordionExample">
  <div class="card">
    <div class="card-header" id="headingOne">
      <h2 class="mb-0">
        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          Auto-Tickets
        </button>
		<button type="button" class="btn btn-info btn-sm mt-3 pull-right" name="print" id="print1" style="display:none;"><i class="fas fa-print"></i> Save and Print</button>
      </h2>

    </div>

    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
      <div class="card-body">
        <form method="post" action="{{ route('save.auto.tickets') }}">
        	<div class="form-row">
        		<div class="col">
        			<label for="exampleFormControlSelect1">Select Package</label>
					    <select name="package" class="form-control package select2" id="exampleFormControlSelect1">
					      <option>choose package ...</option>
					      @forelse($packages as $p)
					      <option value="{{ $p->packagename }}">{{ $p->packagename }}</option>
					      @empty
					      <option value="">No packages available</option>
					      @endforelse
					    </select>
        		</div>
        		<div class="col">
        			<label>Number of Tickets</label>
        			<input type="text" name="ticketsnum" class="form-control total" placeholder="ticket number">
        		</div>

        	</div>
        	<hr>
			<div class="printable">
        		<div class="row p-1 tickets"></div>
			</div>
        	<div class="form-row">
        		<button type="submit" class="btn btn-success sub" style="display: none;"><i class="fas fa-save"></i> save tickets</button>
        	</div>
        	@csrf
        </form>
      </div>
    </div>
  </div>

</div>
	</div>
</div>
@endsection
@section('js')
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/jquery.PrintArea.js') }}"></script>
<script type="text/javascript">
	$(document).ready(function(){
		var cost=0;
		var package="";
		//listen to plan change and fetch the plan cost
		$(".package").change(function(){
			$('.tickets').empty();
			package=$(this).val();
			var _token=$("input[name='_token']").val();
			var req = $.ajax({
				method:"post",
				url:"{{ route('get.package.cost') }}",
				data:{package:package,_token:_token},
			});
			req.done(function(data){
				if(data==0){
					$(".warn").html("You have not priced the selected package, please go to package pricing if its not free. <a class='text-primary' href='{{ route('package.price') }}'>package pricing</a>").addClass("alert alert-warning");
				}else{
					$(".warn").empty().removeClass("alert alert-warning");
					cost=data[0];
				}

			})

			// alert();
		})
		//listen for input in number of tickets desired
		$(".total").on("keyup",function(){
				var num=parseInt($(this).val());
				if(package!="" && num!=0 && num!=""){
				//generate tickets
				generateTicket(num,package,cost);
				}else{
					$(".tickets").empty();
					alert("please select a package first");
				}
			})
		//

		$("#print1").click(function(){
			var mode = 'iframe';
			var close = mode =="popup";
			var options = {mode:mode,popClose:close};
			$(".tickets").printArea(options);
			$("#saveticketsform").submit();


		})
		function generateTicket(num,package,cost){
			if(num!="" && num!=NaN){
				for (var i=0;i<num;i++){
					var username=generateUsername();
					var password=username;
					var serialnumber=generateSerialNum();
					var ticket='<div class="card m-1"><div class="card-header"><h5>Ticket '+parseInt(i+1)+'</h5></div><div class="card-body"><ul class="list-group list-group-flush"><li class="list-group-item">Access Code : '+username+'</li><li class="list-group-item d-none">Password : '+password+'</li><li class="list-group-item">Serial Number: '+serialnumber+'</li></ul><input name="username[]" type="hidden" value="'+username+'"><input name="password[]" type="hidden" value="'+password+'"><input name="cost[]" type="hidden" value="'+cost+'"><input name="serialnumber[]" type="hidden" value="'+serialnumber+'"><input name="plan[]" type="hidden" value="'+package+'"></div></div>';
					$(".tickets").append(ticket);
					$(".sub").show();
					$("#print1").show();
			}
			}else{
				$(".tickets").empty();
			}


		}
		function generateUsername(){
			var text = "";
			var possible = "0123456789";

		  	for (var i = 0; i < 6; i++)
		    text += possible.charAt(Math.floor(Math.random() * possible.length));

		  	return text;
		}
		function generatePassword(){
			var text = "";
			var possible = "0123456789";

		  	for (var i = 0; i < 5; i++)
		    text += possible.charAt(Math.floor(Math.random() * possible.length));

		  	return text;
		}
		function generateSerialNum(){
			var text = "";
			var possible = "0123456789";

		  	for (var i = 0; i < 12; i++)
		    text += possible.charAt(Math.floor(Math.random() * possible.length));

		  	return text;
		}

		function printTickets(){
			$(".tickets").print({

				globalStyles : true,

				mediaPrint : false,

				iframe : false,
			});
		}
	})
</script>
@endsection
