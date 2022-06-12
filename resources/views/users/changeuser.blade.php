@extends('layouts.master')
@section('content_header')
User Information
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
	<div class="card-header">User Details</div>
	<div class="card-body">
		<?php
			$username = "";
		?>
		<div class="row">
			<div class="col-md-4">
				<div class="card card-sm">
					<div class="card-header"><h3>Personal Details</h3></div>
				  <ul class="list-group list-group-flush">
				  	@foreach($userdetails as $d)
				  	<?php
				  		$username = $d->username;

				  	?>
				    <li class="list-group-item"><b>Name :</b> {{ $d->name }}</li>
				    <li class="list-group-item"><b>Username:</b> {{ $d->username }}</li>
				    <li class="list-group-item"><b>Email: </b>{{ $d->email }}</li>
				    <li class="list-group-item"><b>Phone:</b> {{ $d->phone }}</li>
				    <li class="list-group-item"><b>Zone:</b> {{ $d->zonename }}</li>
				  @endforeach
				  </ul>
				</div>

			</div>
			<div class="col-md-8">
                <div class="accordion" id="accordionExample">
                    <div class="card">
                      <div class="card-header" id="headingOne">
                        <h2 class="mb-0">
                          <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Per user limits
                          </button>
                        </h2>
                      </div>

                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                        <div class="card-body">
                            @if(count($preplyattributes)>0 || count($pcheckattributes)>0)
                            <table class="table table-sm table-responsivetable-sm table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Limit Name</th>
                                        <th>Value</th>
                                        <th>Edit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($preplyattributes as $ra)
                                    <form method="post" action="{{ route('edit_attr.post') }}">
                                    <tr>
                                        <input name="table" value="reply" type="hidden">
                                        <input type="hidden" name="attr_id" value="{{ $ra->id }}">
                                        <td><input class="form-control" type="text" name="limit" value="{{ $ra->attribute }}" readonly></td>
                                        <td><input class="form-control" type="text" name="limitvalue" value="{{ $ra->value }}"></td>
                                        <td><button type="submit" class="btn btn-sm btn-success"><i class="fas fa-save"></i></button><a href="#" id="{{ $ra->id }}" class="btn btn-sm btn-danger trashr"><i class="fas fa-trash"></i></a></td>
                                    </tr>
                                    @csrf
                                    </form>
                                    @endforeach
                                    @foreach($pcheckattributes as $ca)
                                    <form method="post" action="{{ route('edit_attr.post') }}">
                                    @csrf
                                    <tr>
                                        @if($ca->attribute=='Cleartext-Password')

                                        <?php
                                            $pass = $ca->value;
                                        ?>
                                        @endif
                                        <input name="table" value="check" type="hidden">
                                        <input type="hidden" name="attr_id" value="{{ $ca->id }}">
                                        <td><input class="form-control" type="text" name="limit" value="{{ $ca->attribute }}" readonly></td>
                                        <td><input class="form-control" type="text" name="limitvalue" value="{{ $ca->value }}"></td>
                                        <td><button type="submit" class="btn btn-sm btn-success"><i class="fas fa-save"></i></button>
                                            <a href="#" id="{{ $ca->id }}" class="btn btn-sm btn-danger trashc"><i class="fas fa-trash"></i></a></td>

                                    </tr>
                                    </form>
                                    @endforeach
                                </tbody>
                            </table>
                            @else
                            <div class="alert alert-warning">No user specific attributes</div>
                            @endif
                        </div>
                      </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingTwo">
                          <h2 class="mb-0">
                            <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                              Package Details
                            </button>
                          </h2>
                        </div>
                        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                          <div class="card-body">
                            @if(count($packagedetails)>0)
                            <div class="card">
                                <div class="card-header"><h3>Package Details ({{ $userpackage[0] }})</h3></div>
                              <ul class="list-group list-group-flush">
                                  @foreach($packagedetails as $d)
                                <li class="list-group-item"><b>Down Speed :</b> {{ $d->downloadspeed/(1024*1024) }} mbps</li>
                                <li class="list-group-item"><b>Up Speed:</b> {{ $d->uploadspeed/(1024*1024) }} mbps</li>
                                <li class="list-group-item"><b>Max time: </b>{{ $d->validdays }}{{ $d->durationmeasure }}</li>
                                <li class="list-group-item"><b>Quota:</b> 
                                    @if($d->quota!=0)
                                    {{ $d->quota/(1024*1024) }}MBs
                                    @else
                                    {{ 'UNLIMITED' }}
                                    @endif
                                </li>
                                <li class="list-group-item"><b>Time Spent  Online:</b> {{ $usertimespent/3600 }} Hours</li>
                                <li class="list-group-item"><b>Used Bundles :</b> {{ $userquotaspent/(1024*1024) }}(MBs)</li>
                              @endforeach
                              </ul>
                            </div>
                            @else
                            <div class="alert alert-warning">User has no package allocated</div>
                            @endif
                          </div>
                        </div>
                      </div>
                </div>


			</div>

		</div>
		<div class="row">
			<div class="col-md-12">
				<button class="btn btn-outline-primary btn-md" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-link" aria-hidden="true"></i>Change package</button>
				
                <a href="#" class="btn btn-outline-warning btn-md" data-toggle="modal" data-target="#exampleModal3"><i class="fas fa-exclamation-triangle"></i> Per user limits</a>
                <a href="{{ route('services.testconnectivity',['user'=>$username,'cleart'=>$pass]) }}" class="btn btn-outline-success btn-md"><i class="fas fa-globe"></i> Test User Connectivity</a>
                <a href="#" class="btn btn-outline-danger btn-md" data-toggle="modal" data-target="#exampleModal2"><i class="fas fa-trash"></i> Delete user</a>
                <a href="#" id="{{ $username }}" class="btn btn-outline-warning btn-md trashrec"><i class="fas fa-close"></i> Remove Accounting records</a>

            </div>
		</div>
	</div>
</div>

  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
	  <div class="modal-content">
		<div class="modal-header">
		  <h5 class="modal-title" id="exampleModalLabel">Change User Package</h5>
		  <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
		</div>
		<div class="modal-body">
            <form id="changepackage">
                <select class="form-control" name="package" id="package">
                    <option value="">Choose New Package</option>
                    <option value="nopackage">Non-regulated (no package)</option>
                    @forelse($packages as $p)
                        <option value="{{ $p->packagename }}">{{ $p->packagename }}</option>

                    @empty

                    <option value="">No package is available</option>
                    @endforelse
                    <input type="hidden" id="username" name="username" value="<?php echo $username;?>">
                </select>

		</div>
		<div class="modal-footer">
		  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		  <button type="submit" class="btn btn-primary">Save changes</button>
		</div>
        @csrf
    </form>
	  </div>
	</div>
  </div>
  <!-- Modal2 -->
  <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
	  <div class="modal-content">
		<div class="modal-header">
		  <h5 class="modal-title" id="exampleModalLabel">Delete User Records</h5>
		  <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
		</div>
		<div class="modal-body">
            <form method="post" action="{{ route('removeuser') }}">
                <label>Remove Accounting records?</label>
                <select class="form-control" name="del_acc" id="package">

                    <option value="no">No</option>
                    <option value="yes">Yes</option>
                    <input type="hidden" id="username" name="username" value="<?php echo $username;?>">
                </select>

		</div>
		<div class="modal-footer">
		  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		  <button type="submit" class="btn btn-primary">Delete user</button>
		</div>
        @csrf
    </form>
	  </div>
	</div>
  </div>
  <!-- Modal3 -->
  <div class="modal fade" id="exampleModal3" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
	  <div class="modal-content">
		<div class="modal-header">
		  <h5 class="modal-title" id="exampleModalLabel">Per User Limits</h5>
		  <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
		</div>
		<div class="modal-body">
            <a href="#" class="btn btn-primary btn-sm float-right" id="add"><i class="fa fa-plus"></i></a>
            <form method="post" action="{{ route('peruserlimit.post') }}">
                <label>Add limits</label>
                <div class="form-row" id="addrow">
                    <div class="col">
                        <select name="limit[]" class="form-control limit">
                            <option value="">Choose limit...</option>
                            @forelse($customlimits as $cl)
                            <option value="{{ $cl->id }}">{{ $cl->limitname }} | {{ $cl->limitmeasure }} |{{ $cl->pref_table }}</option>
                            @empty
                            <option value="">No limits available</option>
                            @endforelse
                        </select>
                        <input type="hidden" id="username" name="username" value="<?php echo $username;?>">

                    </div>
                    <div class="col">
                        <input name="limitvalue[]" class="form-control limitvalue" type="text" placeholder="limit value...">
                    </div>

                </div>
                <br>
                <div class="rowsfield">

                </div>

		</div>
		<div class="modal-footer">
		  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		  <button type="submit" class="btn btn-primary">Apply Limits</button>
		</div>
        @csrf
    </form>
	  </div>
	</div>
  </div>

<div class="position-relative top-0 end-0 p-3">
  <div class="toast" id="liveToast" role="alert" aria-live="assertive" aria-atomic="true">
  <div class="toast-header">
    <strong class="me-auto">Bootstrap</strong>
    <small>11 mins ago</small>
    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
  </div>
  <div class="toast-body">
    Hello, world! This is a toast message.
  </div>
</div>
</div>
@endsection
@section('js')
<script type="text/javascript">
$(document).ready(function(){
    $("#changepackage").submit(function(event){
        var package = $("#package").val();
        var username = $("#username").val();
        var _token = $("input[name='_token']").val();

        if(package!= "" && username!=""){
            var request = $.ajax({
                url: "{{ route('customer.changepackage.post') }}",
                method:"post",
                data:{username:username,package:package,_token:_token},
            });

            request.done(function(response){
                if(response){
                    alert(response);
                    location.reload();                   

                }
                

                // location.reload();
            });
        }else{
            alert("Please choose a package");
        }

        event.preventDefault()
    })

    function showToast(){
            var toastLiveExample = document.getElementById('liveToast');
            var toast = new bootstrap.Toast(toastLiveExample,{delay:2000});

            toast.show();
    }


    $("#add").click(()=>{
        var inp = $("#addrow").clone();
        $(".rowsfield").append(inp);
        $(".rowsfield").append("<br>");
    })
    $(".trashc").click(function(){
        var id = $(this).attr("id");
        if (confirm("Are you sure you want to delete this limit?")){
            $.ajax({
                method:'GET',
                url:'checkattr/del/'+id,
                success:function(res){
                    alert(res);
                    window.location.reload();
                }
            })
        }
    })
    $(".trashr").click(function(){
        var id = $(this).attr("id");
        if (confirm("Are you sure you want to delete this limit?")){
            $.ajax({
                method:'GET',
                url:'replyattr/del/'+id,
                success:function(res){
                    alert(res);
                    window.location.reload();
                }
            })
        }
    })
    $(".trashrec").click(function(){
        var user = $(this).attr("id");
        if (confirm("Are you sure you want to delete user accounting records?")){
            $.ajax({
                method:'GET',
                url:'accounting/del/'+user,
                success:function(res){
                    alert(res);
                    // window.location.reload();
                }
            })
        }
    })
})
</script>
@endsection
