@extends('layouts.master')
@section('buttons')
<div class="col-lg-6 col-5 text-right">
  <div class="button-group">
  <a href="{{ route('inventory.item.new') }}" class="btn btn-sm btn-neutral"><i class="fas fa-plus"></i>&nbsp; New item</a>
  <a href="{{ route('inventory.item.new') }}" class="btn btn-sm btn-neutral"><i class="fas fa-plus"></i>&nbsp; New item</a>
</div>
</div>
@endsection
@section('content_header')
Items
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
              <h3 class="card-title">Available Items</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example2" class="table table-responsivetable-bordered table-hover">
                <thead>
                  <?php $num=0;?>
                  <tr>
                    <th>#</th>
                    <th>Category Code</th>
                    <th>Description</th>
                    
                  </tr>
                </thead>
                <tbody>
                  @forelse($items as $key=>$i)
                    <tr>
                      <td>{{ $key+1 }}</td>
                      <td>{{ $i->category_code }}</td>
                      <td>{{ $i->description }}</td>
                      <td><a href="{{ route('edit.item',['id'=>$i->id]) }}"><i class="fas fa-edit"></i>&nbsp;</a>&nbsp;<a href="{{ route('item.delete',['id'=>$i->id]) }}"><i class="fas fa-trash text-danger"></i>&nbsp;</a></td>
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
@endsection