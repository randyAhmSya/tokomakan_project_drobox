@extends('admin.admin_dashboard')
@section('admin')

<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">All Banner</h4>
                    <div class="page-title-right">
                        <ol class="m-0 breadcrumb">
                            <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#addBannerModal">Add Banner</button>
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
                                    <th>Sl</th>
                                    <th>Banner Image</th>
                                    <th>Banner Url</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($banner as $key => $item)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td><img src="{{ asset($item->image) }}" alt="Banner Image" style="width: 70px; height: 40px;"></td>
                                    <td>{{ $item->url }}</td>
                                    <td>
                                        <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#editBannerModal" id="{{ $item->id }}" onclick="bannerEdit(this.id)">Edit</button>
                                        <button type="button" class="btn btn-danger waves-effect waves-light delete-banner" data-id="{{ $item->id }}">Delete</button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->

    </div> <!-- container-fluid -->
</div>

<!-- Add Banner Modal -->
<div id="addBannerModal" class="modal fade" tabindex="-1" aria-labelledby="addBannerLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addBannerLabel">Add Banner</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('banner.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="bannerUrl" class="form-label">Banner Url</label>
                        <input class="form-control" type="text" name="url" id="bannerUrl" placeholder="Enter banner URL" required>
                    </div>
                    <div class="mb-3">
                        <label for="bannerImage" class="form-label">Banner Image</label>
                        <input class="form-control" type="file" name="image" id="image" required>
                    </div>
                    <div class="mb-3">
                        <img id="showImage" src="{{ url('upload/no_image.jpg') }}" alt="" class="p-1 rounded-circle bg-primary" width="110">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Banner Modal -->
<div id="editBannerModal" class="modal fade" tabindex="-1" aria-labelledby="editBannerLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Edit Banner</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('banner.update') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="banner_id" id="banner_id">
                    <div class="mb-3">
                        <label for="editBannerUrl" class="form-label">Banner Url</label>
                        <input class="form-control" type="text" name="url" id="editBannerUrl" required>
                    </div>
                    <div class="mb-3">
                        <label for="editBannerImage" class="form-label">Banner Image</label>
                        <input class="form-control" type="file" name="image" id="editBannerImage">
                    </div>
                    <div class="mb-3">
                        <img id="bannerImage" src="" alt="" class="p-1 rounded-circle bg-primary" width="110">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        // Handle delete button click
        $('.delete-banner').on('click', function() {
            var banner_id = $(this).data('id');
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
                    window.location.href = "{{ route('delete.banner', '') }}/" + banner_id;
                }
            });
        });

        // Image preview for add banner
        $('#image').change(function(e) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#showImage').attr('src', e.target.result);
            }
            reader.readAsDataURL(e.target.files[0]);
        });
    });

    // Banner edit function
    function bannerEdit(id) {
        $.ajax({
            type: 'GET',
            url: '/edit/banner/' + id,
            dataType: 'json',
            success: function(data) {
                $('#editBannerUrl').val(data.url);
                $('#bannerImage').attr('src', data.image);
                $('#banner_id').val(data.id);
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to fetch banner data'
                });
            }
        });
    }

    // Display success message
    @if(Session::has('message'))
        Swal.fire({
            icon: 'success',
            title: "{{ Session::get('message') }}",
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });
    @endif
</script>
@endsection
