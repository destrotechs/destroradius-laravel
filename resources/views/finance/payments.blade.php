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
    <div class="card card-body">
        <table class="table table-sm table-responsive table-sm">
            <thead>
                <tr><th colspan="8">All Sales</th></tr>
                <?php $num=0;?>
                <tr>
                    <th>#</th>
                    <th>Paid By</th>
                    <th>Phone</th>
                    <th>Paid For</th>
                    <th>Reference</th>
                    <th>Amount</th>
                    <th>Payment Method</th>
                    <th>Date</th>
                    
                </tr>
            </thead>
            <tbody>
                @forelse ($payments as $key=>$m)
                <?php $num++;?>
                    <tr>
                        <td><?php echo $num;?></td>
                        <td>{{ $m->username }}</td>
                        <td>{{ $m->phonenumber }} </td>
                        <td>{{ $m->packagebought }} </td>
                        <td>{{ $m->transactionid }} </td>
                        <td>{{ $m->amount }} </td>
                        <td>{{ 'MPESA' }} </td>
                        <td>{{ $m->transactiondate }} </td>
                        
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="bg-secondary p-2">No payments made yet</td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
            	<tr>
            		<td colspan="8">{!! $payments->links() !!}</td>
            	</tr>
            </tfoot>
        </table>
    </div>
@endsection
