@extends('admin.admin_dashboard')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Profile</h4>

                    <div class="page-title-right">
                        <ol class="m-0 breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Contacts</a></li>
                            <li class="breadcrumb-item active">Profile</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-xl-9 col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="order-2 col-sm order-sm-1">
                                <div class="mt-3 d-flex align-items-start mt-sm-0">
                                    <div class="flex-shrink-0">
                                        <div class="avatar-xl me-3">
                                            <img src="{{ (!empty($profileData->photo)) ? url('upload/admin_images/'.$profileData->photo) : url('upload/no_image.jpg') }}" alt="" class="img-fluid rounded-circle d-block">
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div>
                                            <h5 class="mb-1 font-size-16">{{ $profileData->name }}</h5>
                                            <p class="text-muted font-size-13">{{$profileData->email}}</p>

                                            <div class="flex-wrap gap-2 d-flex align-items-start gap-lg-3 text-muted font-size-13">
                                                <div><i class="align-middle mdi mdi-circle-medium me-1 text-success"></i>{{$profileData->phone}}</div>
                                                <div><i class="align-middle mdi mdi-circle-medium me-1 text-success"></i>{{$profileData->address}}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="order-1 col-sm-auto order-sm-2">
                                <div class="gap-2 d-flex align-items-start justify-content-end">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end card body -->
                </div>
                <!-- end card -->



                <div class="p-4 card-body">
                    <form action="{{ route('admin.password.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <div>
                                    <div class="mb-3">
                                        <label for="example-text-input" class="form-label">Old_Password</label>
                                        <input class="form-control @error('old_password')
                                            is-invalid
                                        @enderror"  type="password" name="old_password" id="old_password">
                                        @error('old_password')
                                            <span class="text-danger" >{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="example-text-input" class="form-label">New_Password</label>
                                        <input class="form-control @error('new_password')
                                            is-invalid
                                        @enderror"  type="password" name="new_password" id="new_password">
                                        @error('new_password')
                                            <span class="text-danger" >{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="example-text-input" class="form-label">Confirm New Password</label>
                                        <input class="form-control" type="password" name="new_password_confirmation" id="new_password_confirmation">
                                    </div>
                                    <button type="submit" class="btn btn-primary waves-effect waves-light">Save Changes</button>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>

                <!-- end tab content -->
            </div>
            <!-- end col -->
            <!-- end col -->
        </div>
        <!-- end row -->

    </div> <!-- container-fluid -->
</div>
@endsection
