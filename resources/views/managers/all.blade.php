@extends('layouts.master')
@section('buttons')
<div class="col-lg-6 col-5 text-right">
  <a href="{{ route('manager.new.get') }}" class="btn btn-sm btn-neutral"><i class="fas fa-plus"></i>&nbsp; New Manager</a>
</div>
@endsection
@section('content_header')
    All Managers
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
    <div class="card card-body">
        <table class="table table-sm table-responsivetable-sm">
            <thead>
                <tr>All managers</tr>
                <?php $num=0;?>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Super Admin</th>
                    <th>City</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($managers as $key=>$m)
                <?php $num++;?>
                    <tr>
                        <td><?php echo $num;?></td>
                        <td>{{ $m->name }}</td>
                        <td>{{ $m->phone }} </td>
                        <td>{{ $m->address }}</td>
                        <td>
                            {{ $m->role_id==1?'YES':'NO' }}
                        </td>
                        <td>{{ $m->city }}</td>
                        
                        <td><a href="{{ route('manager.edit',['id'=>$m->id]) }}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a><a href="#" id="{{ $m->id }}" class="btn btn-danger btn-sm trash"><i class="fas fa-trash"></i></a></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="bg-secondary p-2">you have no managers available</td>
                    </tr>
                @endforelse
            </tbody>

        </table>
    </div>
@endsection
@section('js')
<script type="text/javascript">
    $(document).ready(function(){
        $(".trash").click(function(){
            var id = $(this).attr("id");
            if (confirm("Are you sure you want to delete this manager?")){
                $.ajax({
                    method:'GET',
                    url:'delete/'+id,
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