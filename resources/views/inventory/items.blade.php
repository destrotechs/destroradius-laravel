@extends('layouts.master')
@section('buttons')
<div class="col-lg-6 col-5 text-right">
  <a href="{{ route('inventory.item.new') }}" class="btn btn-sm btn-neutral"><i class="fas fa-plus"></i>&nbsp; New item</a>
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
              <h4 class="card-title">Inventory Items</h4>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
              <table class="dTable table table-head-fixed text-nowrap table-sm">
                  <thead style="color: black">
                  <?php $num=0;?>
                  <tr>
                    <th>#</th>
                    <th>Category</th>
                    <th>Sub-Cateory</th>
                    <th>Name</th>
                    <th>Model</th>
                    <th>Type</th>
                    <th>Serial</th>
                    <th>Stock In</th>
                    <th>Allocated Items</th>
                    <th>Available Stock</th>
                    <th>Edit</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($items as $key=>$i)
                  <?php $num++;?>
                    <tr>
                      <td><?php echo $num;?></td>
                      <td>{{ $i->cat_desc }}</td>
                      <td>{{ $i->sub_desc }}</td>
                      <td>{{ $i->name }}</td>
                      <td>{{ $i->model }}</td>
                      <td>{{ $i->type }}</td>
                      <td>{{ $i->serial }}</td>
                      <td>{{ $i->quantity }}</td>
                      <td>{{ str_replace('-','',(strval($leased_items[$key]+$stock_items[$key]))) }}</td>
                      <td>{{ $i->quantity+($leased_items[$key]+$stock_items[$key]) }}</td>
                      <td><a href="{{ route('edit.item',['id'=>$i->id]) }}" class="btn btn-info btn-sm"><i class="fas fa-edit"></i>&nbsp;</a>&nbsp;<a href="#" class="btn btn-danger btn-sm trash" id="{{ $i->id }}"><i class="fas fa-trash text-white"></i>&nbsp;</a></td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
</div>
@endsection
@section('js')
<script type="text/javascript">
    $(document).ready(function(){
        $(".trash").click(function(){
            var id = $(this).attr("id");
            if (confirm("Are you sure you want to delete this item?")){
                $.ajax({
                    method:'GET',
                    url:'items/delete/'+id,
                    success:function(res){
                        alert(res);
                        window.location.reload();
                    }
                })
            }
        })
    })
</script>
@endsection