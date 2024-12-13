@extends('frontend.dashboard.dashboard')
@section('dashboard')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" >

<section class="section pt-4 pb-4 osahan-account-page">
    <div class="container">
       <div class="row">

@include('frontend.dashboard.sidebar')
<div class="col-md-9">
    <div class="osahan-account-page-right rounded shadow-sm bg-white p-4 h-100">
        <div class="tab-pane" >
            <h4 class="font-weight-bold mt-0 mb-4">Favourites</h4>
            <div class="row">

    @foreach ($wishlist as $wis)


    <div class="col-md-4 col-sm-6 mb-4 pb-2">
        <div class="list-card bg-white h-100 rounded overflow-hidden position-relative shadow-sm">
            <div class="list-card-image">
            <div class="star position-absolute"><span class="badge badge-success"><i class="icofont-star"></i> 3.1 (300+)</span></div>
            <div class="favourite-heart text-danger position-absolute"><a href="detail.html"><i class="icofont-heart"></i></a></div>
            <div class="member-plan position-absolute"><span class="badge badge-dark">Promoted</span></div>
            <a href="{{ route('res_detail',$wis->client_id) }}">
            <img src="{{ asset('upload/client_images/' .$wis['client']['photo']) }}" class="img-fluid item-img" style="width: 300px; height:200px">
            </a>
            </div>
            <div class="p-3 position-relative">
                <div class="list-card-body">
                    <h6 class="mb-1">
                        <a href="{{ route('res_detail',$wis->client_id) }}" class="text-black">
                            {{$wis['client']['name']}}
                        </a>
                    </h6>
                    <div style="float:right; margin-bottom:5px">
                        <a href="{{ route('remove.wishlist', $wis->id) }}" class="badge badge-danger">
                            <i class="icofont-ui-delete" style="font-size: 24px;"></i>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
    @endforeach
            </div>
         </div>

    </div>
</div>
       </div>
    </div>
 </section>


@endsection
