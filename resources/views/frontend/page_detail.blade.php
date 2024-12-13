@extends('frontend.dashboard.dashboard')
@section('dashboard')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

        @php
            $products = App\Models\Product::where('client_id',$client->id)->limit(3)->get();
            $menuNames = $products->map(function($product){
            return $product->menu->menu_name;
            })->toArray();
            $menuNamesString = implode(' . ',$menuNames);
            $coupons = App\Models\Coupon::where('client_id',$client->id)->where('status','1')->first();
        @endphp
      <section class="restaurant-detailed-banner">
         <div class="text-center">
            <img class="img-fluid cover" src="{{ asset('upload/client_images/' . $client->cover_photo ) }}">
         </div>
         <div class="restaurant-detailed-header">
            <div class="container">
               <div class="row d-flex align-items-end">
                  <div class="col-md-8">
                     <div class="restaurant-detailed-header-left">
                        <img class="float-left mr-3 img-fluid" alt="osahan" src="{{ asset('upload/client_images/' . $client->photo ) }}">
                   <h2 class="text-white">{{ $client->name }}</h2>
                   <p class="mb-1 text-white"><i class="icofont-location-pin"></i>{{ $client->address }} <span class="badge badge-success">OPEN</span>
                        </p>
                        <p class="mb-0 text-white"><i class="icofont-food-cart"></i>  {{$menuNamesString}}
                        </p>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="text-right restaurant-detailed-header-right">
                        <button class="btn btn-success" type="button"><i class="icofont-clock-time"></i> 25–35 min
                        </button>
                        <h6 class="mb-0 text-white restaurant-detailed-ratings"><span class="text-white rounded generator-bg"><i class="icofont-star"></i> 3.1</span> 23 Ratings  <i class="ml-3 icofont-speech-comments"></i> 91 reviews</h6>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         </div>
      </section>
      <section class="bg-white shadow-sm offer-dedicated-nav border-top-0">
         <div class="container">
            <div class="row">
               <div class="col-md-12">
                  <span class="float-right restaurant-detailed-action-btn">
                  <button class="btn btn-light btn-sm border-light-btn" type="button"><i class="icofont-heart text-danger"></i> Mark as Favourite</button>
                  <button class="btn btn-light btn-sm border-light-btn" type="button"><i class="icofont-cauli-flower text-success"></i>  Pure Veg</button>
                  <button class="btn btn-outline-danger btn-sm" type="button"><i class="icofont-sale-discount"></i>  OFFERS</button>
                  </span>
                  <ul class="nav" id="pills-tab" role="tablist">
                     <li class="nav-item">
                        <a class="nav-link active" id="pills-order-online-tab" data-toggle="pill" href="#pills-order-online" role="tab" aria-controls="pills-order-online" aria-selected="true">Order Online</a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" id="pills-gallery-tab" data-toggle="pill" href="#pills-gallery" role="tab" aria-controls="pills-gallery" aria-selected="false">Gallery</a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" id="pills-restaurant-info-tab" data-toggle="pill" href="#pills-restaurant-info" role="tab" aria-controls="pills-restaurant-info" aria-selected="false">Restaurant Info</a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" id="pills-book-tab" data-toggle="pill" href="#pills-book" role="tab" aria-controls="pills-book" aria-selected="false">Book A Table</a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" id="pills-reviews-tab" data-toggle="pill" href="#pills-reviews" role="tab" aria-controls="pills-reviews" aria-selected="false">Ratings & Reviews</a>
                     </li>
                  </ul>
               </div>
            </div>
         </div>
      </section>
      <section class="pt-2 pb-2 mt-4 mb-4 offer-dedicated-body">
         <div class="container">
            <div class="row">
               <div class="col-md-8">
                  <div class="offer-dedicated-body-left">
                     <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-order-online" role="tabpanel" aria-labelledby="pills-order-online-tab">
                            @php
                            $populers = App\Models\Product::where('status',1)->where('client_id',$client->id)->where('most_populer',1)->orderBy('id','desc')->limit(5)->get();
                        @endphp
                        <div id="#menu" class="p-4 mb-4 bg-white rounded shadow-sm explore-outlets">
                            <h6 class="mb-3">Most Popular  <span class="badge badge-success"><i class="icofont-tags"></i> 15% Off All Items </span></h6>
                            <div class="mb-3 owl-carousel owl-theme owl-carousel-five offers-interested-carousel">

                           @foreach ($populers as $populer)
                            <div class="item" >
                                <div class="mall-category-item">
                                    <a href="#" >
                                        <img class="card-img-top img-fluid" style="height: 89px; object-fit: cover;" src="{{ asset($populer->image) }}" alt="{{ $populer->name }}">
                                        <h6 class="card-title" style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis; height: 4.5em;">{{ $populer->name }}</h6>
                                        @if ($populer->discount_price == NULL)
                                            ${{$populer->price}}
                                        @else
                                        $<del>{{$populer->price}}</del> ${{$populer->discount_price}}
                                        @endif
                                        <span class="float-right">
                                            @auth
                                            <a class="btn btn-outline-secondary btn-sm"  href="{{ route('add_to_cart', $populer->id) }}">ADD</a>
                                            @else
                                            <a class="btn btn-outline-secondary btn-sm"  href="{{ route('login') }}">Login to Add</a>
                                            @endauth

                                        </span>
                                    </a>
                                </div>
                            </div>
                            @endforeach

                            </div>
                        </div>
                        @php
                            $bestsellers = App\Models\Product::where('status',1)->where('client_id',$client->id)->where('best_seller',1)->orderBy('id','desc')->limit(3)->get();
                        @endphp
                           <div class="row">
                              <h5 class="mt-3 mb-4 col-md-12">Best Sellers</h5>
                              @foreach ($bestsellers as $bestseller)
                              <div class="mb-4 col-md-4 col-sm-6">
                                 <div class="overflow-hidden bg-white rounded shadow-sm list-card h-100 position-relative">
                                    <div class="list-card-image">
                                       <div class="star position-absolute"><span class="badge badge-success"><i class="icofont-star"></i> 3.1 (300+)</span></div>
                                       <div class="favourite-heart text-danger position-absolute"><a href="#"><i class="icofont-heart"></i></a></div>
                                       <div class="member-plan position-absolute"><span class="badge badge-dark">Promoted</span></div>
                                       <a href="#">
                                        <img src="{{ asset($bestseller->image) }}" class="img-fluid item-img">
                                       </a>
                                    </div>
                                    <div class="p-3 position-relative">
                                       <div class="list-card-body">
                                        <h6 class="mb-1"><a href="#" class="text-black">{{$bestseller->name}}</a></h6>
                                        <p class="mb-2 text-gray">
                                            @if ($bestseller->city)
                                                {{ $bestseller->city->city_name }}
                                            @else
                                                Unknown City
                                            @endif
                                        </p>

                                        <p class="mb-0 text-gray time">
                                            @if ($bestseller->discount_price == NULL)
                                            <a class="text-black btn btn-link btn-sm" href="#">${{$bestseller->price}}  </a>
                                        @else
                                        $<del>{{$bestseller->price}}</del>
                                        <a class="text-black btn btn-link btn-sm" href="#">${{$bestseller->discount_price}}  </a>

                                        @endif
                                             <a class="btn btn-outline-secondary btn-sm" href="{{ route('add_to_cart', $bestseller->id) }}">ADD</a>
                                             </span>
                                          </p>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              @endforeach
                           </div>

                            @foreach ($menus as $menu)



                           <div class="row">
                              <h5 class="mt-3 mb-4 col-md-12">{{ $menu->menu_name }} <small class="h6 text-black-50">{{$menu->products->count()}} ITEMS</small></h5>
                              <div class="col-md-12">
                                 <div class="mb-4 bg-white border rounded shadow-sm">
                                    @foreach ($menu->products as $products)


                                    <div class="p-3 menu-list border-bottom">
                                        <a class="float-right btn btn-outline-secondary btn-sm" href="{{ route('add_to_cart', $products->id) }}">ADD</a>
                                       <div class="media">
                                        <img class="mr-3 rounded-pill" src="{{ asset($products->image) }}" alt="Generic placeholder image">
                                          <div class="media-body">
                                             <h6 class="mb-1">{{$products->name}}</h6>
                                             <p class="mb-0 text-gray">${{$products->price}} ({{$products->size ?? ''}}cm)</p>

                                          </div>
                                       </div>
                                    </div>
                                    @endforeach
                                 </div>
                              </div>
                           </div>
                           @endforeach
                        </div>
                        <div class="tab-pane fade" id="pills-gallery" role="tabpanel" aria-labelledby="pills-gallery-tab">
                           <div id="gallery" class="p-4 mb-4 bg-white rounded shadow-sm">
                              <div class="restaurant-slider-main position-relative homepage-great-deals-carousel">
                                 <div class="owl-carousel owl-theme homepage-ad">
                                    @foreach ($galerys as $index => $galery)
                                    <div class="item">
                                       <img class="img-fluid" src="{{asset($galery->gallery_image)}}">
                                       <div class="text-white position-absolute restaurant-slider-pics bg-dark">{{ $index + 1 }} of {{ $galerys->count() }} Photos</div>
                                    </div>
                                    @endforeach
                                 </div>

                              </div>
                           </div>
                        </div>
                        <div class="tab-pane fade" id="pills-restaurant-info" role="tabpanel" aria-labelledby="pills-restaurant-info-tab">
                           <div id="restaurant-info" class="p-4 mb-4 bg-white rounded shadow-sm">
                              <div class="float-right ml-5 address-map">
                                 <div class="mapouter">
                                    <div class="gmap_canvas"><iframe width="300" height="170" id="gmap_canvas" src="https://maps.google.com/maps?q=university%20of%20san%20francisco&t=&z=9&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe></div>
                                 </div>
                              </div>
                              <h5 class="mb-4">Restaurant Info</h5>
                              <p class="mb-3">{{ $client->address }}
                              </p>
                              <p class="mb-2 text-black"><i class="mr-2 icofont-phone-circle text-primary"></i> {{ $client->phone }}</p>
                              <p class="mb-2 text-black"><i class="mr-2 icofont-email text-primary"></i> {{ $client->email}}</p>
                              <p class="mb-2 text-black"><i class="mr-2 icofont-clock-time text-primary"></i> {{ $client->shop_info }}
                                 <span class="badge badge-success"> OPEN NOW </span>
                              </p>
                              <hr class="clearfix">
                              <p class="mb-0 text-black">You can also check the 3D view by using our menue map clicking here &nbsp;&nbsp;&nbsp; <a class="text-info font-weight-bold" href="#">Venue Map</a></p>
                              <hr class="clearfix">
                              <h5 class="mt-4 mb-4">More Info</h5>
                              <p class="mb-3">Dal Makhani, Panneer Butter Masala, Kadhai Paneer, Raita, Veg Thali, Laccha Paratha, Butter Naan</p>
                              <div class="mb-4 border-btn-main">
                                 <a class="mr-2 border-btn text-success" href="#"><i class="icofont-check-circled"></i> Breakfast</a>
                                 <a class="mr-2 border-btn text-danger" href="#"><i class="icofont-close-circled"></i> No Alcohol Available</a>
                                 <a class="mr-2 border-btn text-success" href="#"><i class="icofont-check-circled"></i> Vegetarian Only</a>
                                 <a class="mr-2 border-btn text-success" href="#"><i class="icofont-check-circled"></i> Indoor Seating</a>
                                 <a class="mr-2 border-btn text-success" href="#"><i class="icofont-check-circled"></i> Breakfast</a>
                                 <a class="mr-2 border-btn text-danger" href="#"><i class="icofont-close-circled"></i> No Alcohol Available</a>
                                 <a class="mr-2 border-btn text-success" href="#"><i class="icofont-check-circled"></i> Vegetarian Only</a>
                              </div>
                           </div>
                        </div>
                        <div class="tab-pane fade" id="pills-book" role="tabpanel" aria-labelledby="pills-book-tab">
                           <div id="book-a-table" class="p-4 mb-5 bg-white rounded shadow-sm rating-review-select-page">
                              <h5 class="mb-4">Book A Table</h5>
                              <form>
                                 <div class="row">
                                    <div class="col-sm-6">
                                       <div class="form-group">
                                          <label>Full Name</label>
                                          <input class="form-control" type="text" placeholder="Enter Full Name">
                                       </div>
                                    </div>
                                    <div class="col-sm-6">
                                       <div class="form-group">
                                          <label>Email Address</label>
                                          <input class="form-control" type="text" placeholder="Enter Email address">
                                       </div>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-sm-6">
                                       <div class="form-group">
                                          <label>Mobile number</label>
                                          <input class="form-control" type="text" placeholder="Enter Mobile number">
                                       </div>
                                    </div>
                                    <div class="col-sm-6">
                                       <div class="form-group">
                                          <label>Date And Time</label>
                                          <input class="form-control" type="text" placeholder="Enter Date And Time">
                                       </div>
                                    </div>
                                 </div>
                                 <div class="text-right form-group">
                                    <button class="btn btn-primary" type="button"> Submit </button>
                                 </div>
                              </form>
                           </div>
                        </div>
                        <div class="tab-pane fade" id="pills-reviews" role="tabpanel" aria-labelledby="pills-reviews-tab">
                           <div id="ratings-and-reviews" class="clearfix p-4 mb-4 bg-white rounded shadow-sm restaurant-detailed-star-rating">
                              <span class="float-right star-rating">
                              <a href="#"><i class="icofont-ui-rating icofont-2x active"></i></a>
                              <a href="#"><i class="icofont-ui-rating icofont-2x active"></i></a>
                              <a href="#"><i class="icofont-ui-rating icofont-2x active"></i></a>
                              <a href="#"><i class="icofont-ui-rating icofont-2x active"></i></a>
                              <a href="#"><i class="icofont-ui-rating icofont-2x"></i></a>
                              </span>
                              <h5 class="pt-1 mb-0">Rate this Place</h5>
                           </div>
                           <div class="clearfix p-4 mb-4 bg-white rounded shadow-sm graph-star-rating">
                              <h5 class="mb-1">Ratings and Reviews</h5>
                              <div class="graph-star-rating-header">
                                 <div class="star-rating">
                                    <a href="#"><i class="icofont-ui-rating active"></i></a>
                                    <a href="#"><i class="icofont-ui-rating active"></i></a>
                                    <a href="#"><i class="icofont-ui-rating active"></i></a>
                                    <a href="#"><i class="icofont-ui-rating active"></i></a>
                                    <a href="#"><i class="icofont-ui-rating"></i></a>  <b class="ml-2 text-black">334</b>
                                 </div>
                                 <p class="mt-2 mb-4 text-black">Rated 3.5 out of 5</p>
                              </div>
                              <div class="graph-star-rating-body">
                                 <div class="rating-list">
                                    <div class="text-black rating-list-left">
                                       5 Star
                                    </div>
                                    <div class="rating-list-center">
                                       <div class="progress">
                                          <div style="width: 56%" aria-valuemax="5" aria-valuemin="0" aria-valuenow="5" role="progressbar" class="progress-bar bg-primary">
                                             <span class="sr-only">80% Complete (danger)</span>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="text-black rating-list-right">56%</div>
                                 </div>
                                 <div class="rating-list">
                                    <div class="text-black rating-list-left">
                                       4 Star
                                    </div>
                                    <div class="rating-list-center">
                                       <div class="progress">
                                          <div style="width: 23%" aria-valuemax="5" aria-valuemin="0" aria-valuenow="5" role="progressbar" class="progress-bar bg-primary">
                                             <span class="sr-only">80% Complete (danger)</span>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="text-black rating-list-right">23%</div>
                                 </div>
                                 <div class="rating-list">
                                    <div class="text-black rating-list-left">
                                       3 Star
                                    </div>
                                    <div class="rating-list-center">
                                       <div class="progress">
                                          <div style="width: 11%" aria-valuemax="5" aria-valuemin="0" aria-valuenow="5" role="progressbar" class="progress-bar bg-primary">
                                             <span class="sr-only">80% Complete (danger)</span>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="text-black rating-list-right">11%</div>
                                 </div>
                                 <div class="rating-list">
                                    <div class="text-black rating-list-left">
                                       2 Star
                                    </div>
                                    <div class="rating-list-center">
                                       <div class="progress">
                                          <div style="width: 2%" aria-valuemax="5" aria-valuemin="0" aria-valuenow="5" role="progressbar" class="progress-bar bg-primary">
                                             <span class="sr-only">80% Complete (danger)</span>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="text-black rating-list-right">02%</div>
                                 </div>
                              </div>
                              <div class="mt-3 mb-3 text-center graph-star-rating-footer">
                                 <button type="button" class="btn btn-outline-primary btn-sm">Rate and Review</button>
                              </div>
                           </div>
                           <div class="p-4 mb-4 bg-white rounded shadow-sm restaurant-detailed-ratings-and-reviews">
                              <a href="#" class="float-right btn btn-outline-primary btn-sm">Top Rated</a>
                              <h5 class="mb-1">All Ratings and Reviews</h5>
                              <div class="pt-4 pb-4 reviews-members">
                                 <div class="media">
                                    <a href="#"><img alt="Generic placeholder image" src="img/user/1.png" class="mr-3 rounded-pill"></a>
                                    <div class="media-body">
                                       <div class="reviews-members-header">
                                          <span class="float-right star-rating">
                                          <a href="#"><i class="icofont-ui-rating active"></i></a>
                                          <a href="#"><i class="icofont-ui-rating active"></i></a>
                                          <a href="#"><i class="icofont-ui-rating active"></i></a>
                                          <a href="#"><i class="icofont-ui-rating active"></i></a>
                                          <a href="#"><i class="icofont-ui-rating"></i></a>
                                          </span>
                                          <h6 class="mb-1"><a class="text-black" href="#">Singh Osahan</a></h6>
                                          <p class="text-gray">Tue, 20 Mar 2020</p>
                                       </div>
                                       <div class="reviews-members-body">
                                          <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections </p>
                                       </div>
                                       <div class="reviews-members-footer">
                                          <a class="total-like" href="#"><i class="icofont-thumbs-up"></i> 856M</a> <a class="total-like" href="#"><i class="icofont-thumbs-down"></i> 158K</a>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <hr>
                              <hr>
                              <a class="mt-4 text-center w-100 d-block font-weight-bold" href="#">See All Reviews</a>
                           </div>
                           <div class="p-4 mb-5 bg-white rounded shadow-sm rating-review-select-page">
                              <h5 class="mb-4">Leave Comment</h5>
                              <p class="mb-2">Rate the Place</p>
                              <div class="mb-4">
                                 <span class="star-rating">
                                 <a href="#"><i class="icofont-ui-rating icofont-2x"></i></a>
                                 <a href="#"><i class="icofont-ui-rating icofont-2x"></i></a>
                                 <a href="#"><i class="icofont-ui-rating icofont-2x"></i></a>
                                 <a href="#"><i class="icofont-ui-rating icofont-2x"></i></a>
                                 <a href="#"><i class="icofont-ui-rating icofont-2x"></i></a>
                                 </span>
                              </div>
                              <form>
                                 <div class="form-group">
                                    <label>Your Comment</label>
                                    <textarea class="form-control"></textarea>
                                 </div>
                                 <div class="form-group">
                                    <button class="btn btn-primary btn-sm" type="button"> Submit Comment </button>
                                 </div>
                              </form>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>

            @php
                use Carbon\Carbon;
                $coupon = App\Models\Coupon::where('client_id', $client->id)->where('validity','>=', Carbon::now()->format('Y-m-d'))->latest()->first();
            @endphp

               <div class="col-md-4">
                  <div class="pb-2">
				  <div class="clearfix p-4 mb-4 text-white bg-white rounded shadow-sm restaurant-detailed-earn-pts card-icon-overlap">
                     <img class="float-left mr-3 img-fluid" src="{{ asset('frontend/img/earn-score-icon.png') }}">
                     <h6 class="pt-0 mb-1 text-primary font-weight-bold">OFFER</h6>
                     {{-- <pre>{{ print_r(Session::get('coupon'), true) }}</pre> --}}
                     @if ($coupon == NULL)
                     <p class="mb-0">Coupon is available<span class="text-danger font-weight-bold"></span></p>
                     @else
                     <p class="mb-0">{{ $coupon->discount }} 60% off on orders above $99 | Use coupon  <span class="text-danger font-weight-bold">{{ $coupon->coupon_name }}</span></p>
                     @endif
                     <div class="icon-overlap">
                        <i class="icofont-sale-discount"></i>
                     </div>
                  </div>
				  </div>
                  <div class="p-4 mb-4 rounded shadow-sm generator-bg osahan-cart-item">
                    <h5 class="mb-1 text-white">Your Order</h5>
                    <p class="mb-4 text-white">
                        @auth
                            {{ count((array)session('cart')) }} ITEMS
                        @else
                            0 ITEMS
                        @endauth
                    </p>
                    <div class="mb-2 bg-white rounded shadow-sm">
                        <div class="cart-items">
                            @auth
                                @php
                                    $total = 0;
                                @endphp
                                @if (session('cart'))
                                    @foreach (session('cart') as $id => $details)
                                        @php
                                            $total += $details['price'] * $details['quantity'];
                                        @endphp
                                        <div class="p-2 gold-members border-bottom">
                                            <p class="float-right mb-0 ml-2 text-gray">{{ $details['price'] * $details['quantity'] }}</p>
                                            <span class="float-right count-number">
                                                <button class="btn btn-outline-secondary btn-sm left dec" data-id="{{ $id }}">
                                                    <i class="icofont-minus"></i>
                                                </button>
                                                <input class="count-number-input" type="text" value="{{ $details['quantity'] }}" readonly="">
                                                <button class="btn btn-outline-secondary btn-sm right inc" data-id="{{ $id }}">
                                                    <i class="icofont-plus"></i>
                                                </button>
                                                <button class="btn btn-outline-danger btn-sm right remove" data-id="{{ $id }}">
                                                    <i class="icofont-trash"></i>
                                                </button>
                                            </span>
                                            <div class="media">
                                                <div class="mr-2">
                                                    <img src="{{ asset($details['image']) }}" width="30px">
                                                </div>
                                                <div class="media-body">
                                                    <p class="mt-1 mb-0 text-black">{{ $details['name'] }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            @else
                                <p class="text-center text-muted">Your cart is empty. Please log in to add items.</p>
                            @endauth
                        </div>
                    </div>
                    <div class="clearfix p-2 mb-2 bg-white rounded">
                        <div class="mb-2 input-group input-group-sm">
                            <input type="text" class="form-control" placeholder="Enter promo code" id="coupon_name" @guest disabled @endguest>
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit" id="button-addon2" onclick="ApplyCoupon()" @guest disabled @endguest>
                                    <i class="icofont-sale-discount"></i> APPLY
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix p-2 mb-2 bg-white rounded">
                        <img class="float-left img-fluid" src="{{ asset('frontend/img/wallet-icon.png') }}">
                        <h6 class="mb-2 text-right font-weight-bold">
                            Subtotal : <span class="text-danger">
                                @auth
                                    ${{ $total }}
                                @else
                                    $0
                                @endauth
                            </span>
                        </h6>
                        <p class="mb-1 text-right seven-color">Extra charges may apply</p>
                    </div>
                    <a href="{{ route('checkout') }}" class="btn btn-success btn-block btn-lg" @guest disabled @endguest>
                        Checkout <i class="icofont-long-arrow-right"></i>
                    </a>
                </div>


                    <div class="pt-2 mb-4 text-center">

                    </div>
                    <div class="pt-2 text-center">

                    </div>
               </div>
            </div>
         </div>
      </section>


      <section class="pt-5 pb-5 text-center bg-white section">
         <div class="container">
            <div class="row">
               <div class="col-sm-12">
                  <h5 class="m-0">Operate food store or restaurants? <a href="login.html">Work With Us</a></h5>
               </div>
            </div>
         </div>
      </section>
      <section class="pt-5 pb-5 footer">
         <div class="container">
            <div class="row">
               <div class="col-md-4 col-12 col-sm-12">
                  <h6 class="mb-3">Subscribe to our Newsletter</h6>
                  <form class="mb-1 newsletter-form">
                     <div class="input-group">
                        <input type="text" placeholder="Please enter your email" class="form-control">
                        <div class="input-group-append">
                           <button type="button" class="btn btn-primary">
                           Subscribe
                           </button>
                        </div>
                     </div>
                  </form>
                  <p><a class="text-info" href="register.html">Register now</a> to get updates on <a href="offers.html">Offers and Coupons</a></p>
                  <div class="app">
                     <p class="mb-2">DOWNLOAD APP</p>
                     <a href="#">
                     <img class="img-fluid" src="img/google.png">
                     </a>
                     <a href="#">
                     <img class="img-fluid" src="img/apple.png">
                     </a>
                  </div>
               </div>
               <div class="col-md-1 col-sm-6 mobile-none">
               </div>
               <div class="col-md-2 col-4 col-sm-4">
                  <h6 class="mb-3">About OE</h6>
                  <ul>
                     <li><a href="#">About Us</a></li>
                     <li><a href="#">Culture</a></li>
                     <li><a href="#">Blog</a></li>
                     <li><a href="#">Careers</a></li>
                     <li><a href="#">Contact</a></li>
                  </ul>
               </div>
               <div class="col-md-2 col-4 col-sm-4">
                  <h6 class="mb-3">For Foodies</h6>
                  <ul>
                     <li><a href="#">Community</a></li>
                     <li><a href="#">Developers</a></li>
                     <li><a href="#">Blogger Help</a></li>
                     <li><a href="#">Verified Users</a></li>
                     <li><a href="#">Code of Conduct</a></li>
                  </ul>
               </div>
               <div class="col-md-2 col-4 col-sm-4">
                  <h6 class="mb-3">For Restaurants</h6>
                  <ul>
                     <li><a href="#">Advertise</a></li>
                     <li><a href="#">Add a Restaurant</a></li>
                     <li><a href="#">Claim your Listing</a></li>
                     <li><a href="#">For Businesses</a></li>
                     <li><a href="#">Owner Guidelines</a></li>
                  </ul>
               </div>
            </div>
         </div>
      </section>
      <section class="pt-5 pb-5 bg-white footer-bottom-search">
         <div class="container">
            <div class="row">
               <div class="col-md-12">
                  <p class="text-black">POPULAR COUNTRIES</p>
                  <div class="search-links">
                     <a href="#">Australia</a> |  <a href="#">Brasil</a> | <a href="#">Canada</a> |  <a href="#">Chile</a>  |  <a href="#">Czech Republic</a> |  <a href="#">India</a>  |  <a href="#">Indonesia</a> |  <a href="#">Ireland</a> |  <a href="#">New Zealand</a> | <a href="#">United Kingdom</a> |  <a href="#">Turkey</a>  |  <a href="#">Philippines</a> |  <a href="#">Sri Lanka</a>  |  <a href="#">Australia</a> |  <a href="#">Brasil</a> | <a href="#">Canada</a> |  <a href="#">Chile</a>  |  <a href="#">Czech Republic</a> |  <a href="#">India</a>  |  <a href="#">Indonesia</a> |  <a href="#">Ireland</a> |  <a href="#">New Zealand</a> | <a href="#">United Kingdom</a> |  <a href="#">Turkey</a>  |  <a href="#">Philippines</a> |  <a href="#">Sri Lanka</a><a href="#">Australia</a> |  <a href="#">Brasil</a> | <a href="#">Canada</a> |  <a href="#">Chile</a>  |  <a href="#">Czech Republic</a> |  <a href="#">India</a>  |  <a href="#">Indonesia</a> |  <a href="#">Ireland</a> |  <a href="#">New Zealand</a> | <a href="#">United Kingdom</a> |  <a href="#">Turkey</a>  |  <a href="#">Philippines</a> |  <a href="#">Sri Lanka</a>  |  <a href="#">Australia</a> |  <a href="#">Brasil</a> | <a href="#">Canada</a> |  <a href="#">Chile</a>  |  <a href="#">Czech Republic</a> |  <a href="#">India</a>  |  <a href="#">Indonesia</a> |  <a href="#">Ireland</a> |  <a href="#">New Zealand</a> | <a href="#">United Kingdom</a> |  <a href="#">Turkey</a>  |  <a href="#">Philippines</a> |  <a href="#">Sri Lanka</a>
                  </div>
                  <p class="mt-4 text-black">POPULAR FOOD</p>
                  <div class="search-links">
                     <a href="#">Fast Food</a> |  <a href="#">Chinese</a> | <a href="#">Street Food</a> |  <a href="#">Continental</a>  |  <a href="#">Mithai</a> |  <a href="#">Cafe</a>  |  <a href="#">South Indian</a> |  <a href="#">Punjabi Food</a> |  <a href="#">Fast Food</a> |  <a href="#">Chinese</a> | <a href="#">Street Food</a> |  <a href="#">Continental</a>  |  <a href="#">Mithai</a> |  <a href="#">Cafe</a>  |  <a href="#">South Indian</a> |  <a href="#">Punjabi Food</a><a href="#">Fast Food</a> |  <a href="#">Chinese</a> | <a href="#">Street Food</a> |  <a href="#">Continental</a>  |  <a href="#">Mithai</a> |  <a href="#">Cafe</a>  |  <a href="#">South Indian</a> |  <a href="#">Punjabi Food</a> |  <a href="#">Fast Food</a> |  <a href="#">Chinese</a> | <a href="#">Street Food</a> |  <a href="#">Continental</a>  |  <a href="#">Mithai</a> |  <a href="#">Cafe</a>  |  <a href="#">South Indian</a> |  <a href="#">Punjabi Food</a>
                  </div>
               </div>
            </div>
         </div>
      </section>
      <script src=" {{  asset('frontend/vendor/jquery/jquery-3.3.1.slim.min.js') }}"></script>
      <!-- Bootstrap core JavaScript-->
      <script src="{{  asset('frontend/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
      <!-- Select2 JavaScript-->
      <script src="{{  asset('frontend/vendor/select2/js/select2.min.js') }}"></script>
      <!-- Owl Carousel -->
      <script src="{{  asset('frontend/vendor/owl-carousel/owl.carousel.js') }}"></script>
      <!-- Custom scripts for all pages-->
      <script src="{{  asset('frontend/js/custom.js') }}"></script>
      <script>
        $(document).ready(function() {

            const Toast = Swal.mixin({
         toast: true,
         position: 'top-end',
         showConfirmButton: false,
         timer: 150,
         timerProgressBar: true,
         didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer);
            toast.addEventListener('mouseleave', Swal.resumeTimer);
         }
      });

           $('.inc').on('click', function() {
              var id = $(this).data('id');
              var input = $(this).closest('span').find('input');
              var newQuantity = parseInt(input.val()) + 1;
              updateQuantity(id,newQuantity);
           });
           $('.dec').on('click', function() {
              var id = $(this).data('id');
              var input = $(this).closest('span').find('input');
              var newQuantity = parseInt(input.val()) - 1;
              if (newQuantity >= 1) {
                 updateQuantity(id,newQuantity);
              }
           });
           $('.remove').on('click', function() {
              var id = $(this).data('id');
              removeFromCart(id);
           });
           function updateQuantity(id,quantity){
              $.ajax({
                 url: '{{ route("cart.updateQuantity") }}',
                 method: 'POST',
                 data: {
                    _token: '{{ csrf_token() }}',
                    id: id,
                    quantity: quantity
                 },
                 success: function(response){
                    Toast.fire({
                  icon: 'success',
                  title: 'Quantity Updated'
               }).then(() => {
                  location.reload();
               });
                 }
              })
           }
           function removeFromCart(id) {
            $.ajax({
                url: '{{ route("cart.remove") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: id
                },
                success: function(response) {
                    Toast.fire({
                  icon: 'success',
                  title: 'Cart Remove Successfully'
               }).then(() => {
                  location.reload();
               });
                },
                error: function(xhr) {
                    alert("Failed to remove product. Please try again.");
                }
            });
        }

        })
      </script>
@endsection

