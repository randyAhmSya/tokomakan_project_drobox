@extends('frontend.dashboard.dashboard')
@section('dashboard')

@php
    $id = Auth::user()->id;
    $profileData = App\Models\User::find($id);
@endphp
<section class="pt-4 pb-4 section osahan-account-page">
    <div class="container">
       <div class="row">

        @include('frontend.dashboard.sidebar')
<div class="col-md-9">
    <div class="p-4 bg-white rounded shadow-sm osahan-account-page-right h-100">
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="orders" role="tabpanel" aria-labelledby="orders-tab">
            <h4 class="mt-0 mb-4 font-weight-bold">Order List   </h4>


    <div class="mb-4 bg-white shadow-sm card order-list">
        <div class="p-4 gold-members">

            <table class="table table-bordered dt-responsive nowrap w-100">
                <thead>
                <tr>
                    <th>Sl</th>
                    <th>Date</th>
                    <th>Invoice</th>
                    <th>Amount</th>
                    <th>Payment</th>
                    <th>Status</th>
                    <th>Action </th>
                </tr>
                </thead>


                <tbody>
               @foreach ($allUserOrder as $key=> $item)
                <tr>
                    <td>{{ $key+1 }}</td>
                    <td>{{ $item->order_date }}</td>
                    <td>{{ $item->invoice_no }}</td>
                    <td>${{ $item->amount }}</td>
                    <td>{{ $item->payment_method }}</td>
                    <td>
                    @if ($item->status == 'Pending')
                    <span class="badge bg-info">Pending</span>
                    @elseif ($item->status == 'confirm')
                    <span class="badge bg-primary">Confirm</span>
                    @elseif ($item->status == 'processing')
                    <span class="badge bg-warning">Processing</span>
                    @elseif ($item->status == 'deliverd')
                    <span class="badge bg-success">Deliverd</span>
                    @endif
                    </td>


            <td class="d-flex">
            <a href="{{ route('user.order.details',$item->id) }}" class="btn-small d-block text-primary"> <i class="fas fa-eye"></i> View</a>
            <a href="{{ route('user.invoice.download',$item->id) }}" class="btn-small d-block text-danger"> <i class="fa fa-download"></i> Invoice</a>


                    </td>
                </tr>
                @endforeach

                </tbody>
            </table>


        </div>
    </div>

        </div>




    </div>
    </div>
</div>
       </div>
    </div>
 </section>
@endsection
