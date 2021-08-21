@extends('layouts.master')

@section('content_header')
New Tickets
@endsection
@section('content')
<div class="warn"></div>
<div class="card">
	<div class="card-body">
		<div class="accordion" id="accordionExample">
  <div class="card">
    <div class="card-header" id="headingOne">
      <h2 class="mb-0">
        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          Auto-Tickets
        </button>
      </h2>
    </div>

    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
      <div class="card-body">
        <form method="post" action="{{ route('save.auto.tickets') }}">
        	<div class="form-row">
        		<div class="col">
        			<label for="exampleFormControlSelect1">Select Package</label>
					    <select name="package" class="form-control package" id="exampleFormControlSelect1">
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
        	<div class="row p-2 tickets"></div>
        	<div class="form-row">
        		<button type="submit" class="btn btn-success sub" style="display: none;"><i class="fas fa-save"></i> save tickets</button>
        	</div>
        	@csrf
        </form>
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header" id="headingTwo">
      <h2 class="mb-0">
        <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
          Create Tickets
        </button>
      </h2>
    </div>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
      <div class="card-body">
        <form method="post" action="{{ route('save.auto.tickets') }}">
        	<div class="form-row">
        		<div class="col">
        			<label>Ticket ID</label>
        			<input type="text" name="ticketid" class="form-control" placeholder="ticket id">
        		</div>
        		<div class="col">
        			<label for="validdays">Valid Days</label>
                <input name="validdays" type="digit" class="form-control">
        		</div>
        	</div>
        	{{ csrf_field() }}
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
					cost=data;
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
		function generateTicket(num,package,cost){
			if(num!="" && num!=NaN){
				for (var i=0;i<num;i++){
					var username=generateUsername();
					var password=generatePassword();
					var serialnumber=generateSerialNum();
					var ticket='<div class="card p-2 m-1"><div class="card-header"><h5>Ticket '+parseInt(i+1)+'</h5></div><div class="card-body"><ul class="list-group list-group-flush"><li class="list-group-item">Username : '+username+'</li><li class="list-group-item">Password : '+password+'</li><li class="list-group-item">Serial Number: '+serialnumber+'</li></ul><input name="username[]" type="hidden" value="'+username+'"><input name="password[]" type="hidden" value="'+password+'"><input name="cost[]" type="hidden" value="'+cost+'"><input name="serialnumber[]" type="hidden" value="'+serialnumber+'"><input name="plan[]" type="hidden" value="'+package+'"></div></div>';
					$(".tickets").append(ticket);
					$(".sub").show();
			}
			}else{
				$(".tickets").empty();
			}
			
			
		}
		function generateUsername(){
			var text = "";
			var possible = "ABCDEFGHJKLMNPQRSTUVWXYZabcdefghjklmnpqrstuvwxyz23456789";

		  	for (var i = 0; i < 6; i++)
		    text += possible.charAt(Math.floor(Math.random() * possible.length));

		  	return text;
		}
		function generatePassword(){
			var text = "";
			var possible = "ABCDEFGHJKLMNPQRSTUVWXYZ23456789";

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
	})
</script>
@endsection