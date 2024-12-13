@extends('admin.admin_dashboard')
@section('admin')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script src="{{ asset('backend/assets/js/code.js') }}"></script>


<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">All Category</h4>

                    <div class="page-title-right">
                        <ol class="m-0 breadcrumb">
                            <a href="{{ route('add.category') }}" type="button" class="btn btn-primary waves-effect waves-light">Add Category</a>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Images</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($category as $key => $item)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $item->category_name }}</td>
                                    <td class="text-center">
                                        <img src="{{ asset($item->image) }}" alt="Category Image" style="width: 80px; height: 50px;">
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('edit.category',$item->id) }}" type="button" class="btn btn-info btn-sm waves-effect waves-light">
                                            <i class="mdi mdi-pencil d-block font-size-20"></i>
                                        </a>
                                        <a href="{{ route('category.delete', $item->id) }}" id="delete" type="button" class="ml-2 btn btn-danger btn-sm waves-effect waves-light">
                                            <i class="mdi mdi-trash-can d-block font-size-20"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
                <!-- end card -->
            </div> <!-- end col -->
        </div> <!-- end row -->

    </div> <!-- container-fluid -->
</div>
<script type="text/javascript">
    $(function() {

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
