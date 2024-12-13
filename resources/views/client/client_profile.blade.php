@extends('client.client_dashboard')
@section('client')
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
                                            <img src="{{ (!empty($profileData->photo)) ? url('upload/client_images/'.$profileData->photo) : url('upload/no_image.jpg') }}" alt="" class="img-fluid rounded-circle d-block">
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
                    <form action="{{ route('client.profile.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <div>
                                    <div class="mb-3">
                                        <label for="example-text-input" class="form-label">Name</label>
                                        <input class="form-control" type="text" name="name" value="{{$profileData->name}}" id="example-text-input">
                                    </div>
                                    <div class="mb-3">
                                        <label for="example-text-input" class="form-label">Email</label>
                                        <input class="form-control" name="email" type="email" value="{{$profileData->email}}" id="example-text-input">
                                    </div>
                                    <div class="mb-3">
                                        <label for="example-text-input" class="form-label">phone</label>
                                        <input class="form-control" type="text" name="phone" value="{{$profileData->phone}}" id="example-text-input">
                                    </div>

                                    <div class="mb-3">
                                        <label for="city" class="form-label">City</label>
                                        <select name="city_id" class="form-select" id="city">
                                            <option >Select</option>
                                            @foreach($city as $item)
                                            <option value="{{ $item->id }}" {{ $item->id == $profileData->city_id ? 'selected' : '' }}>{{ $item->city_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="shop_info" class="form-label">Restaurand info</label>
                                        <textarea id="shop_info" name="shop_info" id="" class="form-control" rows="2" placeholder="Enter your Addres">{{ $profileData->shop_info }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="example-text-input" class="form-label">Cover Photo</label>
                                        <input class="form-control" type="file" name="cover_photo" value="{{$profileData->photo}}" id="image">
                                    </div>
                                    <img  id="showImage" src="{{ (!empty($profileData->cover_photo)) ? url('upload/client_images/'.$profileData->cover_photo) : url('upload/no_image.jpg') }}" alt="" class="p-1 bg-primary" height="100" width="210">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="mt-3 mt-lg-0">
                                    <div class="mb-3">
                                        <label for="example-text-input" class="form-label">address</label>
                                        <input class="form-control" type="text" name="address" value="{{$profileData->address}}" id="example-text-input">
                                    </div>
                                    <div class="mb-3">
                                        <label for="example-text-input" class="form-label">Profil Image</label>
                                        <input class="form-control" type="file" name="photo" value="{{$profileData->photo}}" id="image">
                                    </div>
                                    <div class="mb-3">
                                        <img id="showImage" src="{{ (!empty($profileData->photo)) ? url('upload/client_images/'.$profileData->photo) : url('upload/no_image.jpg') }}" alt="" class="p-1 rounded-circle bg-primary" width="110">
                                    </div>
                                    <div class="mb-4">
                                        <button type="submit" class="btn btn-primary waves-effect waves-light">Save Changes</button>
                                    </div>
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

<script type="text/javascript">
    $(document).ready(function(){
        $('#image').change(function(e){
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#showImage').attr('src', e.target.result);
            }
            reader.readAsDataURL(e.target.files[0]);
        })
    })
</script>

@endsection
