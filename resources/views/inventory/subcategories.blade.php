@extends('layouts.master')
@section('buttons')
<div class="col-lg-6 col-5 text-right">
  <button class="btn btn-white btn-sm" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-plus-circle"></i> New</button>
</div>
@endsection
@section('content_header')
Sub Categories
@endsection
@section('content')
  @if (session('success'))
   <div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>{{ session('success') }}</strong>
</div>
@endif
@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong>{{ session('error') }}</strong> 
</div>
@endif
<div class="card">
            <div class="card-header">
              <h3 class="card-title">Item Sub Categories</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="card-body table-responsive p-0">
                <table class="dTable table table-head-fixed text-nowrap table-sm">
                  <thead style="color: black">
                  <?php $num=0;?>
                  <tr>
                    <th>#</th>
                    <th>Category Code</th>
                    <th>Sub Category Code</th>
                    <th>Description</th>
                    <th>Actions</th>
                    
                  </tr>
                </thead>
                <tbody>
                  @foreach($sub_cat as $key=>$c)
                    <tr>
                      <td>{{ $key+1 }}</td>
                      <td>{{ $c->category_code }}</td>
                      <td>{{ $c->sub_category_code }}</td>
                      <td>{{ $c->description }}</td>
                      <td><a href="#"><i class="fas fa-edit"></i>&nbsp;</a>&nbsp;<a href="#"><i class="fas fa-trash text-danger"></i>&nbsp;</a>
                        {{-- <a href="{{ route('inventory.categories.get',['category'=>$c->category_code]) }}" class="btn btn-primary btn-sm" type="button" id="{{ $c->category_code }}">sub-categories</a> --}}
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            </div>
            <!-- /.card-body -->
</div>
<!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel">Create New SubCategory</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
            <form id="changepackage" method="post" action="{{ route('sub_category.new') }}">
               <label>Category Code</label>
               <input type="text" name="category_code" class="form-control" required value="{{ $cat!=""?$cat:'' }}">
               <label>Sub Category Code</label>
               <input type="text" name="sub_category_code" class="form-control" required>
               <label>Description</label>
               <input type="text" name="description" class="form-control" required>
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

  })
</script>
@endsection