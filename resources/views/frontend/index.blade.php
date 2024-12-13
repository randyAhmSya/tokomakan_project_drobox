@extends('frontend.master')
@section('content')
<section class="pt-5 pb-5 section products-section">
    <div class="container">
        <div class="text-center section-header">
            <h2>Popular Brands</h2>
            <p>Top restaurants, cafes, pubs, and bars in Ludhiana, based on trends</p>
            <span class="line"></span>
        </div>

        <div class="row">

            @php
                $client = App\Models\Client::latest()->where('status','1')->get();
            @endphp

            @foreach($client as $cli)

            @php
                $products = App\Models\Product::where('client_id',$cli->id)->limit(3)->get();
                $menuNames = $products->map(function($product){
                return $product->menu->menu_name;
                })->toArray();
                $menuNamesString = implode(' . ',$menuNames);
                $coupons = App\Models\Coupon::where('client_id',$cli->id)->where('status','1')->first();
            @endphp
            <div class="col-md-3">
                <div class="pb-3 item">
                    <div class="overflow-hidden bg-white rounded shadow-sm list-card h-100 position-relative">
                        <!-- Card Image Section -->
                        <div class="list-card-image">
                            <div class="star position-absolute">
                                <span class="badge badge-success">
                                    <i class="icofont-star"></i> 3.1 (300+)
                                </span>
                            </div>
                            <div class="favourite-heart text-danger position-absolute">
                                <a aria-label="Add to Wishlist" class="cursor-pointer" onclick="addWishList({{$cli->id}})">
                                    <i class="icofont-heart"></i>
                                </a>
                            </div>

                            @if ($coupons)
                            <div class="member-plan position-absolute">
                                <span class="badge badge-dark">Promoted</span>
                            </div>
                            @else
                            @endif
                            <a href="{{ route('res_detail',$cli->id) }}">
                                <img src="{{ asset('upload/client_images/' . $cli->photo) }}" class="img-fluid item-img" alt="Restaurant Image" style="width: 300px; height: 200px;">
                            </a>
                        </div>

                        <!-- Card Content Section -->
                        <div class="p-3 position-relative">
                            <div class="list-card-body">
                                <h6 class="mb-1">
                                    <a href="{{ route('res_detail',$cli->id) }}" class="text-black">{{ $cli->name }}</a>
                                </h6>
                                <p class="mb-3 text-gray">{{ $menuNamesString  }}</p>
                                <p class="mb-3 text-gray time">
                                    <span class="pt-1 pb-1 pl-2 pr-2 rounded-sm bg-light text-dark">
                                        <i class="icofont-wall-clock"></i> 20–25 min
                                    </span>
                                </p>
                            </div>

                            <div class="list-card-badge d-flex align-items-center">
                                <span class="badge badge-success me-1">OFFER</span>
                                <small class="text-truncate" style="max-width: calc(100% - 60px);">
                                    @if ($coupons)
                                        {{ $coupons->discount }}% off | Use Coupon {{ $coupons->coupon_name }}
                                    @else
                                        Right Now There Have No Coupon
                                    @endif
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
