@extends('layouts.clientslayout')
@section('buttons')
<div class="col-lg-6 col-5 text-right">
<a href="#" class="btn btn-white btn-sm" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-plus"></i>&nbsp;New User Account</a>
</div>
@endsection
@section('content_header')
User accounts
@endsection
@section('content')
<div class="card">
	{{-- <div class="card-header"><h5>Logs</h5></div> --}}
	<div class="card-body">
		
						@if(count($accounts)>0)
                        <table class="table table-sm">
                            <tr>
                                <th>#</th>
                                <th>Account Code</th>
                                <th>Package</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            @foreach($accounts as $k=>$c)
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
                                    <a href="#" class="btn btn-sm btn-success"><i class="fas fa-download"></i>&nbsp;Business Form</a>
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
<!-- Modal -->
<div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Activate Account</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      	<form method="POST" action="{{ route('customer.changepackage.post') }}">
        <input type="hidden" name="username" id="username">
        <input type="hidden" name="account_no" id="account_no">
        <input type="hidden" name="package" id="package">
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
