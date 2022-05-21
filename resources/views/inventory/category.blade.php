@extends('layouts.master')
@section('buttons')
<div class="col-lg-6 col-5 text-right">
  <button class="btn btn-white btn-sm" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-plus-circle"></i> New</button>
</div>
@endsection
@section('content_header')
Categories
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
              <h3 class="card-title">Item Categories</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example2" class="table table-sm table-responsivetable-bordered table-hover">
                <thead>
                  <?php $num=0;?>
                  <tr>
                    <th>#</th>
                    <th>Category Code</th>
                    <th>Description</th>
                    <th>Actions</th>
                    
                  </tr>
                </thead>
                <tbody>
                  @forelse($items as $key=>$c)
                    <tr>
                      <td>{{ $key+1 }}</td>
                      <td>{{ $c->category_code }}</td>
                      <td>{{ $c->description }}</td>
                      <td><a href="#"><i class="fas fa-edit"></i>&nbsp;</a>&nbsp;<a href="#"><i class="fas fa-trash text-danger"></i>&nbsp;</a>
                        <a href="{{ route('inventory.sub_categories.get',['category'=>$c->category_code]) }}" class="btn btn-primary btn-sm" type="button" id="{{ $c->category_code }}">sub-categories</a>
                      </td>
                    </tr>
                  @empty
                  <tr>
                    <td colspan="6" class="text-danger">item categories not added</td>
                  </tr>
                  @endforelse
                </tbody>
                <tfoot>
                  <tr>
                    <td colspan="7">{{ $items->links() }}</td>
                  </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.card-body -->
</div>
<!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel">Create New Category</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
            <form id="changepackage" method="post" action="{{ route('category.new') }}">
               <label>Category Code</label>
               <input type="text" name="category_code" class="form-control" required>
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