@extends('admin.admin_dashboard')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">all Product</h4>
                    <div class="page-title-right">
                        <ol class="m-0 breadcrumb">
                            <a href="{{ route('admin.add.product') }}" class="btn btn-primary waves-effect waves-light">Add Product</a>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Restaurant</th>
                                    <th>QTY</th>
                                    <th>Price</th>
                                    <th>Discount</th>
                                    <th>status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($product as $key=> $item)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td><img src="{{ asset($item->image) }}" alt="" style="width: 70px; height:40px;"></td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item['client']['name'] }}</td>
                                    <td>{{ $item->qty}}</td>
                                    <td>{{ $item->price }}</td>
                                    <td>
                                        @if ($item->discount_price == NULL)
                                            <span class="badge bg-danger">NO DISCOUNT</span>
                                        @else
                                            @php
                                                $amount = $item->price - $item->discount_price;
                                                $discount = ($amount / $item->price) * 100;
                                            @endphp
                                            <span class="badge bg-danger">{{ round($discount) }}%</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item->status == 1)
                                            <span class="text-success"><b>Active</b></span>
                                        @else
                                            <span class="text-danger"><b>InActive</b></span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.edit.product', $item->id) }}" class="btn btn-info waves-effect waves-light">Edit</a>
                                        <a href="#" class="btn btn-danger waves-effect waves-light delete-product" data-id="{{ $item->id }}">Hapus</a>
                                        <input data-id="{{ $item->id }}" class="toggle-class" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="InActive" type="checkbox" name="" id="" {{ $item->status ? 'checked' : '' }}>
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

<script type="text/javascript">
    $(function() {
        // Toggle Status Change
        $('.toggle-class').change(function() {
            var status = $(this).prop('checked') ? 0 : 1;
            var product_id = $(this).data('id');

            $.ajax({
                type: "GET",
                dataType: "json",
                url: '/changeStatus',
                data: { 'status': status, 'product_id': product_id },
                success: function(data) {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 3000
                    });

                    if (data.success) {
                        Toast.fire({
                            icon: 'success',
                            title: data.success,
                        });
                    } else if (data.error) {
                        Toast.fire({
                            icon: 'error',
                            title: data.error,
                        });
                    }
                },
                error: function(xhr) {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        icon: 'error',
                        showConfirmButton: false,
                        timer: 3000
                    });

                    Toast.fire({
                        icon: 'error',
                        title: 'An error occurred. Please try again.',
                    });
                }
            });
        });

        // Delete Product
        $('.delete-product').click(function(e) {
            e.preventDefault();
            var product_id = $(this).data('id');

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ url('admin/delete/product') }}/" + product_id;
                }
            });
        });
    });

    // Display success message after deletion (add this at the bottom)
    @if(Session::has('message'))
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            icon: 'success',
            showConfirmButton: false,
            timer: 3000
        });

        Toast.fire({
            icon: 'success',
            title: "{{ Session::get('message') }}"
        });
    @endif
</script>
@endsection
