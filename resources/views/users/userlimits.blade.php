@extends('layouts.master')
@section('content_header')
Custom/User Limits
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
	<div class="card-body">
        <table class="table table-sm table-bordered">
            <thead>
                <tr>
                    <th colspan="5">Available Limits</th>
                    <th>
                        <a href="#" class="btn btn-info btn-sm" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-plus"></i> New Limit</a>
                    </th>
                </tr>
                <tr>
                    <th>#</th>
                    <th>Limit name</th>
                    <th>Limit Measure</th>
                    <th>Prefered Table</th>
                    <th>Operand</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($limits as $key=>$l)
                    <tr style="display: none;" class="edit{{ $l->id}}">
                    <form method="post" action="{{ route('postuserlimits') }}">

                        <td>{{ $key+1 }}</td>
                        <td>
                            <input type="text" name="limitname" value="{{ $l->limitname }}">
                        </td>
                        <td>
                            <input type="text" name="limitmeasure" value="{{ $l->limitmeasure }}">
                        </td>
                        <td>
                            <select name="pref_table" value="{{ $l->pref_table }}">

                                <option value="{{ $l->pref_table }}">{{ $l->pref_table }}</option>
                                <option value="check">Check</option>
                                <option value="reply">Reply</option>
                            </select>
                            {{-- <input type="text" name="pref_table" value="{{ $l->pref_table }}"> --}}
                        </td>
                        <td>
                            <input type="text" readonly name="op" value="{{ $l->op }}">
                        </td>
                        <td>
                            <button id="edit{{ $l->id }}" class="btn btn-success btn-sm check" type="submit"><i class="fas fa-check"></i> save</button>
                        </td>
                        @csrf
                        
                    </form>
                    </tr>
                    <tr>
                    <td>
                        {{ $key+1 }}
                    </td>
                    <td>{{ $l->limitname }}</td>
                    <td>{{ $l->limitmeasure }}</td>
                    <td>{{ $l->pref_table }}</td>
                    <td>{{ $l->op }}</td>
                    <td>
                        <a href="#" id="{{ $l->id }}" class="btn btn-sm btn-danger trash"><i class="fas fa-trash"></i></a>
                        <a href="#" id="edit{{ $l->id }}" class="btn btn-sm btn-info edit"><i class="fas fa-edit"></i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
  <!-- Modal3 -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
	  <div class="modal-content">
		<div class="modal-header">
		  <h5 class="modal-title" id="exampleModalLabel">Add Limits</h5>
		  <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
		</div>
		<div class="modal-body">
            <form method="post" action="{{ route('postuserlimits') }}">
                <div class="form-row" id="addrow">
                    <div class="col">
                        <label>Name</label>
                        <input type="text" name="limitname" class="form-control" placeholder="Limit Name">
                    </div>
                    <div class="col">
                        <label>Measure</label>
                        <small>(The value to be applied, e.g 1024 to mean 1MB)</small>
                        <input type="text" name="limitmeasure" class="form-control" placeholder="Limit Measure e.g 1024">
                    </div>
                </div>
                <div class="form-row" id="addrow">
                    <div class="col">
                        <label>Prefered Table</label>
                        <select class="form-control" name="pref_table" required>
                            <option value="">select prefered table ...</option>
                            <option value="check">Check</option>
                            <option value="reply">Reply</option>
                        </select>
                    </div>
                    <div class="col">
                        <label>Operand Type</label>
                        <input name="op" class="form-control" type="text" value=":=" readonly>
                    </div>

                </div>

		</div>
		<div class="modal-footer">
		  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		  <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save</button>
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
    $(".trash").click(function(){
        var id = $(this).attr('id');
        if (confirm("Are you sure you want to delete this limit")){
            $.ajax({
                url:'/user/customlimits/'+id,
                method:'GET',
                success:function(){
                    location.reload();
                }
            })
        }
        
    })
    $(".edit").click(function(){
        var id = $(this).attr('id');
        $("."+id).css("background-color","silver");
        $("."+id).toggle();
    })
    // $(".check").click(function(){
    //     var parentid = $(this).attr('id');
    // })
})
</script>
@endsection
