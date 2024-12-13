@extends('client.client_dashboard')
@section('client')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Edit Product</h4>

                    <div class="page-title-right">
                        <ol class="m-0 breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                            <li class="breadcrumb-item active">Edit Product</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <div class="card">
                    <div class="p-4 card-body">
                        <form id="myForm" action="{{ route('product.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{ $product->id }}" >
                            <div class="row">
                                <!-- Column 1 -->
                                <div class="col-xl-4 col-md-6">
                                    <div class="mb-3 form-group">
                                        <label for="category" class="form-label">Category Name</label>
                                        <select name="category_id" class="form-select" id="category">
                                            <option value="Select">Select</option>
                                            @foreach($category as $item)
                                            <option value="{{$item->id}}" {{ $item->id == $product->category_id ? 'selected' : '' }} >{{ $item->category_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Column 2 -->
                                <div class="col-xl-4 col-md-6">
                                    <div class="mb-3 form-group">
                                        <label for="menu" class="form-label">Menu Name</label>
                                        <select name="menu_id" class="form-select" id="menu">
                                            <option value="Select">Select</option>
                                            @foreach($menu as $item)
                                            <option value="{{$item->id}}" {{ $item->id == $product->menu_id ? 'selected' : '' }}>{{ $item->menu_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Column 3 -->
                                <div class="col-xl-4 col-md-6">
                                    <div class="mb-3 form-group">
                                        <label for="city" class="form-label">City</label>
                                        <select name="city_id" class="form-select" id="city">
                                            <option value="Select">Select</option>
                                            @foreach($city as $item)
                                            <option value="{{$item->id}}" {{ $item->id == $product->city_id ? 'selected' : '' }}>{{ $item->city_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-md-6">
                                    <div class="mb-3 form-group">
                                        <label for="menu_description" class="form-label">Product name</label>
                                        <input class="form-control" type="text" value="{{ $product->name }}" name="name" id="menu_description">
                                    </div>
                                </div>
                                <div class="col-xl-4 col-md-6">
                                    <div class="mb-3 form-group">
                                        <label for="menu_description" class="form-label">Price</label>
                                        <input class="form-control" value="{{ $product->price }}" type="text" name="price" id="menu_description">
                                    </div>
                                </div>
                                <div class="col-xl-4 col-md-6">
                                    <div class="mb-3 form-group">
                                        <label for="menu_description" class="form-label">Discount Price</label>
                                        <input class="form-control" value="{{ $product->discount_price }}" type="text" name="discount_price" id="menu_description">
                                    </div>
                                </div>
                                <div class="col-xl-6 col-md-6">
                                    <div class="mb-3 form-group">
                                        <label for="menu_description" class="form-label">Size</label>
                                        <input class="form-control" value="{{ $product->size }}" type="text" name="size" id="menu_description">
                                    </div>
                                </div>
                                <div class="col-xl-6 col-md-6">
                                    <div class="mb-3 form-group">
                                        <label for="menu_description" class="form-label">Product QTY</label>
                                        <input type="number" name="qty" class="form-control" value="{{ old('qty', $product->qty) }}">

                                    </div>
                                </div>
                                <div class="col-xl-6 col-md-6">
                                    <div class="mb-3 form-group">
                                        <label for="menu_description" class="form-label">Product Image</label>
                                        <input class="form-control" type="file" name="image"   id="image">
                                    </div>
                                </div>
                                <div class="col-xl-6 col-md-6">
                                    <div class="mb-3 form-group">
                                        <img id="showImage" src="{{ asset($product->image)}}" alt="" class="p-1 rounded-circle bg-primary" width="110">
                                    </div>
                                </div>
                                <div class="mb-3 form-check ">
                                    <input value="1" {{ $product->best_seller == 1 ? 'checked' : '' }} class="form-check-input" name="best_seller" type="checkbox" id="exampleCheck1">
                                    <label class="form-check-label" for="exampleCheck1">Best Seller</label>
                                </div>
                                <div class="mb-3 form-check ">
                                    <input value="1" {{ $product->most_populer == 1 ? 'checked' : '' }} class="form-check-input" name="most_populer" type="checkbox" id="exampleCheck2">
                                    <label class="form-check-label" for="exampleCheck2">Special Offers</label>
                                </div>
                                <div class="mb-4">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light">Save Changes</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
    });

    $(document).ready(function (){
        $('#myForm').validate({
            rules: {
                name: {
                    required : true,
                },
                category_id: {
                    required : true,
                },
            },
            messages :{
                name: {
                    required : 'Please Enter  Name',
                },
                category_id: {
                    required : 'Please Upload a  category',
                },
            },
            errorElement : 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight : function(element, errorClass, validClass){
                $(element).addClass('is-invalid');
            },
            unhighlight : function(element, errorClass, validClass){
                $(element).removeClass('is-invalid');
            },
        });
    });
</script>

@endsection
