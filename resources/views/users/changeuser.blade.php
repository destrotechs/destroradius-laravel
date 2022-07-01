@extends('layouts.master')
@section('buttons')
<div class="col-lg-6 col-5 text-right">
<a href="#" class="btn btn-white btn-sm" data-toggle="modal" data-target="#exampleModal7"><i class="fas fa-plus"></i>&nbsp;New User Account</a>
</div>
@endsection
@section('content_header')
User Information
@endsection
@section('styles')
<style type="text/css">

.float{
    position:fixed;
    width:60px;
    height:60px;
    top:60px;
    right:40px;
    background-color:skyblue;
    color:#FFF;
    border-radius:50px;
    text-align:center;
    box-shadow: 2px 2px 3px #999;
}

.my-float{
    margin-top:22px;
}
</style>
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

<div class="">
	<div class="">
		<?php
			$username = "";
            $usertype ="";
            $uid="";
		?>
		<div class="row">
			<div class="col-md-12">
                <div class="accordion" id="accordionExample">
                    <div class="card card-sm">
                    <div class="card-header" id="headingTwo">
                          <h2 class="mb-0">
                            <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseTwo">
                              <i class="fa fa-info-circle" aria-hidden="true"></i>
&nbsp;User Details 
                            </button>
                          </h2>
                    </div>
                    <div id="collapseThree" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                        <div class="card-body">

                    <form method="POST" action="{{ route('update.user.details') }}">
                  <ul class="list-group list-group-flush">
                    @foreach($userdetails as $d)
                    <?php
                        $username = $d->username;
                        $usertype = $d->type;
                        $uid = $d->id;

                    ?>
                    <li class="list-group-item"><b>Name</b> <input type="text" name="name" class="form-control" value="{{ $d->name }}"></li>
                    <li class="list-group-item"><b>Username:</b> <input type="text" name="username" class="form-control" readonly value="{{ $d->username }}"></li>
                    <input type="hidden" name="id" value="{{ $d->id }}">
                    <li class="list-group-item"><b>Email</b><input type="email" name="email" class="form-control" value="{{ $d->email }}"></li>
                    <li class="list-group-item"><b>Phone</b> <input type="text" name="phone" class="form-control" value="{{ $d->phone }}"></li>
                    <li class="list-group-item"><b>Zone</b> 
                        <select name="zone" class="form-control">
                            
                            @forelse($zones as $z)
                            <option value="{{  $z->id}}" {{ $z->id==$d->zoneid? 'selected':'' }}>{{ $z->zonename }}</option>
                            @empty
                            <option value="">No Zones available</option>
                            @endforelse
                        </select>
                    </li>
                  @endforeach
                  </ul>
                    <button class="btn btn-success btn-md ml-3" type="submit"> <i class="fas fa-save"></i>&nbsp;Save Changes</button>
                    @csrf
                    </form>
                </div>

            </div>
            </div>
                    <div class="card">
                        <div class="card-header" id="headingTwo">
                          <h2 class="mb-0">
                            <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                              <i class="fa fa-info" aria-hidden="true"></i>&nbsp; User Accounts
                            </button>
                          </h2>
                        </div>
                        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                          <div class="card-body">
                            @if(count($customer_accounts)>0)
                        <table class="table table-sm">
                            <tr>
                                <th>#</th>
                                <th>Account Code</th>
                                <th>Package</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            @foreach($customer_accounts as $k=>$c)
                            <tr>
                                <td>{{ $k+1 }}</td>
                                <td>{{ $c->account_no }}</td>
                                <td>{{ $c->package_name }}</td>
                                <td>
                                    @if($c->status=='active')
                                    <span class="badge badge-success">Active</span>
                                    @else
                                    <span class="badge badge-danger">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    @if($c->status=='active')
                                    <a href="#" id="{{ $c->account_no }}" class="btn btn-sm btn-danger diact">Suspend</a>
                                    <a href="{{ route('services.testconnectivity',['user'=>$c->account_no]) }}" class="btn btn-info btn-sm">Test Connectivity</a>
                                    @else
                                    <a href="#" id="{{ $c->id }}" class="btn btn-primary btn-sm activate" data-toggle="modal" data-target="#exampleModal8">Activate</a>
                                    @endif
                                    {{-- @if($usertype!='hotspot') --}}
                                    <a href="{{ route('customer_form.doc',['account_no'=>$c->account_no]) }}" target="_blank" class="btn btn-sm btn-success"><i class="fas fa-download"></i>&nbsp;Business Form</a>
                                    {{-- @endif --}}
                                    <a href="{{ route('edit.customer.account',['acc'=>$c->account_no]) }}" class="btn btn-sm btn-info"><i class="fas fa-edit"></i></a>

                                </td>
                            </tr>
                            @endforeach
                            
                        </table>                            


                        @else
                    
                        <div class="text-danger text-sm">User has no associated accounts</div>
                                
                        @endif
                          </div>
                        </div>
                      </div>
                {{-- </div> --}}
<a href="#" class="float" data-bs-toggle="tooltip" data-bs-placement="left" title="Customer available funds">
<b class="my-float">
    <?php
echo "KSH ".CustomerHelper::availableFunds($username);
?>
</b>
</a>
                <div class="card card-sm">
                    <div class="card-header" id="headingTwo">
                          <h2 class="mb-0">
                            <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseTwo">
                              <i class="fa fa-list" aria-hidden="true"></i>&nbsp; User Items
                            </button>
                          </h2>
                    </div>
                    <div id="collapseFour" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                        <div class="card-body">

                    <form>
                       @if(count($useritems)>0)
                       <table class="table table-sm table-responsive table-striped">
                           <thead>
                           <tr>
                               <th>#</th>
                               <th>Item</th>
                               <th>Account</th>
                               <th>Quantity Allocated</th>
                               <th>Allocation Date</th>
                               <th>Status</th>
                               <th>Quantity Returned</th>
                               <th>Return Date</th>
                               <th>Action</th>
                           </tr>
                            </thead>
                           <tbody>                               
                                @foreach($useritems as $key=>$i)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>
                                        {{ $i->name }}
                                    </td>
                                    <td>{{ $i->account_no??'' }}</td>
                                    <td>{{ $i->quantity }}</td>
                                    <td>{{ $i->allocation_date }}
                                    </td>
                                    <td class="{{ $i->status=='RETURNED'? 'text-success':'text-info' }}">{{ $i->status }}
                                    </td>
                                    <td>
                                        {{ $i->quantity_returned??'N/A' }}
                                    </td>
                                    <td>
                                        {{ $i->date_returned??'N/A' }}
                                    </td>
                                    <td>
                                        @if($i->status=='LEASED' || $i->status=='LEASED')
                                        <a href="#" id="{{ $i->alloc_id }}" class="btn btn-sm btn-danger mt-2 remove_allocation"><i class="fas fa-trash"></i></a>
                                        @endif
                                        @if($i->status=='LEASED')
                                        <a href="#" id="{{ $i->alloc_id }}" class="btn btn-sm btn-success mt-2 return_item" data-toggle="modal" data-target="#exampleModal5"><i class="fas fa-edit"></i>&nbsp;return item</a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                           </tbody>
                       </table>
                       @else
                       <div class="alert alert-warning">The user has not been allocated Equipments/Items</div>  
                       @endif                 
                    </form>
                </div>

            </div>
            </div>

        </div>
			</div>

		</div>
		<div class="row">
			<div class="col-md-12">
                <a href="#" class="btn btn-outline-danger btn-md" data-toggle="modal" data-target="#exampleModal2"><i class="fas fa-trash"></i> Delete user</a> 
                @if($usertype!='hotspot')  
                <a href="#" class="btn btn-outline-primary btn-md" data-toggle="modal" data-target="#exampleModal4"><i class="fa fa-hashtag"></i>&nbsp;Allocate Equipment</a>
                @endif             
            </div>
		</div>
	</div>
</div>

  <!-- Modal 6-->
  <div class="modal fade" id="exampleModal6" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Reactivate User Package</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form method="POST" action="{{ route('reactivate_pppoeuser') }}">
                    <p class="card-text">This action reactivates the customer on his/package for period equal to package valid days.</p>
                    <div class="form-check">
                      <input class="form-check-input" name="deduct" value="yes" type="checkbox" value="" id="flexCheckChecked" checked>
                      <label class="form-check-label" for="flexCheckChecked">
                        Deduct Customer Available Funds
                      </label>
                    </div>
                    <input type="hidden" id="username" name="username" value="<?php echo $username;?>">
                    @csrf

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
  <!--end of modal 6-->
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
{{-- modal 4 --}}
<div class="modal fade" id="exampleModal4" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">New Equipment Allocation</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form method="POST" action="{{ route('post.new.equipment') }}">
                <label>Account</label>
                <select name="account_no" class="form-control account_type">
                    <option value="">select ...</option>
                    @forelse($customer_accounts as $ac)
                    <option value="{{ $ac->account_no }}">{{ $ac->account_no }}</option>
                    @empty
                    <option value="">No accounts available</option>
                    @endforelse
                </select>
                <label>Item/Equipment</label>
                <select class="form-control" name="item_id" id="item_id">

                    <option value="">Select ... </option>
                    @forelse($items as $i)
                    <option value="{{ $i->id }}">{{ $i->item_code.' | '.$i->name }}</option>
                    @empty
                    <option value="">No items available</option>
                    @endforelse
                </select>
                    <input type="hidden" id="username" name="userid" value="<?php echo $uid;?>">
                    <label>Lease Type</label>
                    <select name="status" class="form-control" id="leasetype">
                        <option value="">Select ...</option>
                        <option value="PERMANENT">PERMANENT/BOUGHT</option>
                        <option value="LEASED">LEASED</option>
                    </select>
                    <label>Quantity Allocated</label>
                    <input type="digit" name="quantity" class="form-control" placeholder="e.g 1">
                    <label class="return_date" style="display: none;">Expected Return Date</label>
                    <input type="date" name="return_date" class="form-control return_date" style="display:none;">

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Allocate</button>
        </div>
        @csrf
    </form>
      </div>
    </div>
  </div>
{{-- end of modal 4 --}}
{{-- modal 5 --}}
<div class="modal fade" id="exampleModal5" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Return Equipment</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form method="POST" action="{{ route('return.equipment') }}">
                    <label>Quantity Returned</label>
                    <input type="digit" name="quantity_returned" class="form-control" placeholder="e.g 1" required>
                    <input type="hidden" name="allocation_id" id="alloc_id">
                    

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Return</button>
        </div>
        @csrf
    </form>
      </div>
    </div>
  </div>
{{-- end of modal 5 --}}



<!-- Modal -->
<div class="modal fade" id="exampleModal7" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New Customer Account</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{ route('customer.accounts.post') }}">
            <label>User </label>
            <input type="hidden" name="owner" id="ownerf" value="{{ $username }}">

            <label>Account Type</label>
            <select name="account_name" class="form-control account_type">
                <option value="">select ...</option>
                <option value="pppoe"> PPPoE</option>
                <option value="hotspot">HOTSPOT</option>
            </select>
            <label>Select Package</label>
            <select name="package" required class="form-control">
                <option value="">select ...</option>
                @forelse($packages as $p)
                <option value="{{ $p->packagename }}">{{ $p->packagename }}</option>
                @empty
                <option value="">No Packages available</option>
                @endforelse
            </select>
            <label>Account No</label>
            <input type="text" required name="account_no" class="form-control num" placeholder="Account No ...">
            <hr><button class="btn btn-primary btn-sm gen" type="button">Generate</button>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Add New Account</button>
      </div>
      @csrf
      </form>
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModal8" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Activate Account</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{ route('customer.changepackage.post') }}">
        <input type="hidden" name="username" id="ausername">
        <input type="hidden" name="account_no" id="aaccount_no">
        <input type="hidden" name="package" id="apackage">
        <h3>Are you sure you want to Activate this account?</h3>        

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">NOPE</button>
        <button type="submit" class="btn btn-success">YES!</button>
      </div>
      @csrf
      </form>
    </div>
  </div>
</div>
@endsection
@section('js')
<script type="text/javascript">
$(document).ready(function(){
    var account_no = null;
    $(".usac").change(function(){
        alert();
        account_no = $(this).val();
        console.log(account_no);
    });
    $("#changepackage").submit(function(event){
        var package = $("#package").val();
        var username = $("#username").val();
        var _token = $("input[name='_token']").val();

        if(package!= "" && username!="" && account_no!=""){
            var request = $.ajax({
                url: "{{ route('customer.changepackage.post') }}",
                method:"post",
                data:{username:username,package:package,_token:_token,account_no:account_no},
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
    $("#leasetype").change(function(){
        var leasetype = $(this).val();
        if(leasetype!=='PERMANENT'){
            $(".return_date").show();
        }else{
            $(".return_date").hide();
        }
    })
    $(".remove_allocation").click(function(){
        var id = $(this).attr('id');
        if (confirm("Are you sure you want to delete this record?")){
            $.ajax({
                method:'GET',
                url:'/del/'+id,
                success:function(res){
                    alert(res);
                    window.location.reload();
                }
            })
        }

    })

    $(".return_item").click(function(){
        $("#alloc_id").val($(this).attr('id'));
    })

    $(".gen").click(function(){
            var account = generateNumber();
            $(".num").val(account);
        })

        $(".activate").click(function(){
            var account_id = $(this).attr('id');
            $.ajax({
                method:'GET',
                url:'/user/accounts/'+account_id,
                success:function(data){
                    $("#ausername").val(data[0]['owner']);
                    $("#aaccount_no").val(data[0]['account_no']);
                    $("#apackage").val(data[0]['package_name']);
                    console.log(data[0]['package_name'])
                }
            })
        });

        $(".diact").click(function(){
            var account = $(this).attr('id');
            if(account){
                if(confirm("Are you sure you want to deactivate this account?")){
                    $.ajax({
                        method:'GET',
                        url:'/client/account/suspend/'+account,
                        success:function(data){
                            alert(data);
                        }
                    })
                }
                
            }
        })

        $(".account_type").change(function(){
            var type = $(this).val();
            if(type=='hotspot'){
                var account = $("#ownerf").val();
                $(".num").val(account).addAttr('disabled');
            }else{
                $(".num").val("")
            }
        })

        function generateNumber(){
            return Math.floor((Math.random() * 10000) + 1);
        }
})
</script>
@endsection
