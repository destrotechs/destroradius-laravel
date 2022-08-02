@extends('layouts.master')
@section('content_header')
Sales
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
    <div class="card-header"><h4>Item Allocations</h4></div>
    <div class="card-body table-responsive p-0">
        <table class="dTable table table-head-fixed text-nowrap table-sm">
            <thead style="color: black">
                <tr>
                    <th>#</th>
                    <th>Item</th>
                    <th>Allocated to</th>
                    <th>Allocation Date</th>
                    <th>Purpose</th>
                    <th>Status</th>
                    <th>Return Date</th>
                </tr>
            </thead>
            <tbody>
               {{--  @forelse($allocation as $key=>$al)
                <tr>
                    
                </tr>
                @empty
                <tr><td colspan="7">There are item allocation</td></tr>
                @endforelse --}}
            </tbody>
        </table>
    </div>
    
</div>
@endsection
@section('js')

@endsection
