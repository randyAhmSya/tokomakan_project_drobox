@extends('frontend.dashboard.dashboard')
@section('dashboard')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<section class="pt-2 pb-2 mt-4 mb-4 offer-dedicated-body">
    <div class="container">
       <div class="row">
          <div class="col-md-8">
             <div class="offer-dedicated-body-left">

                @php
                $id = Auth::user()->id;
                $profileData = App\Models\User::find($id);
                @endphp


    <div class="pt-2"></div>
    <div class="p-4 mb-4 bg-white rounded shadow-sm">
        <h4 class="mb-1">Choose a delivery address</h4>
        <h6 class="mb-3 text-black-50">Multiple addresses in this location</h6>
        <div class="row">
            <div class="col-md-6">
                <div class="mb-4 bg-white border card addresses-item border-success">
                <div class="p-4 gold-members" style=" height: 156px;">
                    <div class="media">
                        <div class="mr-3"><i class="icofont-ui-home icofont-3x"></i></div>
                        <div class="media-body">
                            <h6 class="mb-1 text-black">Home</h6>
                            <p class="text-black"> {{ $profileData->address }}
                            </p>
                            <p class="mb-0 text-black font-weight-bold"><a class="mr-2 btn btn-sm btn-success" href="#"> DELIVER HERE</a>
                            <span>30MIN</span>
                            </p>
                        </div>
                    </div>
                </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-4 bg-white card addresses-item">
                <div class="p-4 gold-members">
                    <div class="media">
                        <div class="mr-3"><i class="icofont-briefcase icofont-3x"></i></div>
                        <div class="media-body">
                            <h6 class="mb-1 text-secondary">Work</h6>
                            <p>NCC, Model Town Rd Town, Ludhiana, Punjab 141002, India
                            </p>
                            <p class="mb-0 text-black font-weight-bold"><a class="mr-2 btn btn-sm btn-secondary" href="#"> DELIVER HERE</a>
                            <span>40MIN</span>
                            </p>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>

    </div>
                <div class="pt-2"></div>
    <div class="p-4 bg-white rounded shadow-sm osahan-payment">
        <h4 class="mb-1">Choose payment method</h4>
        <h6 class="mb-3 text-black-50">Credit/Debit Cards</h6>
        <div class="row">
            <div class="pr-0 col-sm-4">
                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">

        <a class="nav-link active" id="v-pills-cash-tab" data-toggle="pill" href="#v-pills-cash" role="tab" aria-controls="v-pills-cash" aria-selected="false"><i class="icofont-money"></i> Pay on Delivery</a>
        <a class="nav-link" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true"><i class="icofont-credit-card"></i> Credit/Debit Cards</a>



                </div>
            </div>
            <div class="pl-0 col-sm-8">
                <div class="tab-content h-100" id="v-pills-tabContent">

                    <div class="tab-pane fade show active" id="v-pills-cash" role="tabpanel" aria-labelledby="v-pills-cash-tab">
                        <h6 class="mt-0 mb-3">Cash</h6>
                        <p>Please keep exact change handy to help us serve you better</p>
                        <hr>
                        <form action="{{ route('cash_order') }}" method="POST">
                            @csrf
                            <input type="hidden" name="name" value="{{ Auth::user()->name }}">
                            <input type="hidden" name="email" value="{{ Auth::user()->email }}">
                            <input type="hidden" name="phone" value="{{ Auth::user()->phone }}">
                            <input type="hidden" name="address" value="{{ Auth::user()->address }}">
                            <button type="submit" class="btn btn-success btn-block btn-lg">PAY
                                <i class="icofont-long-arrow-right"></i>
                            </button>
                        </form>
                    </div>
<div class="tab-pane fade" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
    <h6 class="mt-0 mb-3">Add new card</h6>
    <p>WE ACCEPT <span class="osahan-card">
        <i class="icofont-visa-alt"></i> <i class="icofont-mastercard-alt"></i> <i class="icofont-american-express-alt"></i> <i class="icofont-payoneer-alt"></i> <i class="icofont-apple-pay-alt"></i> <i class="icofont-bank-transfer-alt"></i> <i class="icofont-discover-alt"></i> <i class="icofont-jcb-alt"></i>
        </span>
    </p>
    <form>
        <div class="form-row">
            <div class="form-group col-md-12">
            <label for="inputPassword4">Card number</label>
            <div class="input-group">
                <input type="number" class="form-control" placeholder="Card number">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="button" id="button-addon2"><i class="icofont-card"></i></button>
                </div>
            </div>
            </div>
            <div class="form-group col-md-8">
            <label>Valid through(MM/YY)
            </label>
            <input type="number" class="form-control" placeholder="Enter Valid through(MM/YY)">
            </div>
            <div class="form-group col-md-4">
            <label>CVV
            </label>
            <input type="number" class="form-control" placeholder="Enter CVV Number">
            </div>
            <div class="form-group col-md-12">
            <label>Name on card
            </label>
            <input type="text" class="form-control" placeholder="Enter Card number">
            </div>
            <div class="form-group col-md-12">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="customCheck1">
                <label class="custom-control-label" for="customCheck1">Securely save this card for a faster checkout next time.</label>
            </div>
            </div>
            <div class="mb-0 form-group col-md-12">
            <a href="thanks.html" class="btn btn-success btn-block btn-lg">PAY $1329
            <i class="icofont-long-arrow-right"></i></a>
            </div>
        </div>
    </form>
</div>



                </div>
            </div>
        </div>
    </div>
             </div>
          </div>
          @php
          $id = Auth::user()->id;
          $profileData = App\Models\User::find($id);
          @endphp
          <div class="col-md-4">
             <div class="p-4 mb-4 rounded shadow-sm generator-bg osahan-cart-item">
                <div class="mb-4 d-flex osahan-cart-item-profile">
                   <img class="mr-3 img-fluid rounded-pill" alt="osahan" src="{{ (!empty($profileData->photo)) ? url('upload/user_images/'.$profileData->photo) : url('upload/no_image.jpg') }}">
                   <div class="d-flex flex-column">
                      <h6 class="mb-1 text-white">{{ $profileData->name }}
                      </h6>
                      <p class="mb-0 text-white"><i class="icofont-location-pin"></i> {{ $profileData->address }}</p>
                   </div>
                </div>
                <p class="mb-4 text-white">{{ count((array) session('cart')) }} ITEMS</p>
                <div class="mb-2 bg-white rounded shadow-sm">

                    @php $total = 0 @endphp
            @if (session('cart'))
                @foreach (session('cart') as $id => $details)
                @php
                    $total += $details['price'] * $details['quantity']
                @endphp
                <div class="p-2 gold-members border-bottom">
                    <p class="float-right mb-0 ml-2 text-gray">${{ $details['price'] * $details['quantity'] }}</p>
                    <span class="float-right count-number">

                   <button class="btn btn-outline-secondary btn-sm left dec" data-id="{{ $id }}" > <i class="icofont-minus"></i> </button>

                    <input class="count-number-input" type="text" value="{{  $details['quantity'] }}" readonly="">

                    <button class="btn btn-outline-secondary btn-sm right inc" data-id="{{ $id }}" > <i class="icofont-plus"></i> </button>
                    <button class="btn btn-outline-danger btn-sm right remove" data-id="{{ $id }}"> <i class="icofont-trash"></i> </button>
                    </span>
                    <div class="media">
                       <div class="mr-2"><img src="{{ asset($details['image']) }}"  width="25px" ></div>
                       <div class="media-body">
                          <p class="mt-1 mb-0 text-black">{{ $details['name'] }}</p>
                       </div>
                    </div>
                 </div>
                 @endforeach
                 @endif

               </div>
                  @if (Session::has('coupon'))
              <div class="clearfix p-2 mb-2 bg-white rounded">
                 <p class="mb-1">Item Total <span class="float-right text-dark">{{ count((array) session('cart')) }}</span></p>

                 <p class="mb-1">Coupon Name <span class="float-right text-dark">{{ (session()->get('coupon')['coupon_name']) }} ( {{ (session()->get('coupon')['discount']) }} %) </span>
                 <a type="submit" onclick="couponRemove()"><i class="float-right icofont-ui-delete" style="color: red;"></i></a>
                 </p>

                 <p class="mb-1 text-success">Total Discount
                    <span class="float-right text-success">
                       @if (Session::has('coupon'))
                          ${{ $total - Session()->get('coupon')['discount_amount'] }}
                       @else
                       ${{ $total }}
                       @endif

                    </span>
                 </p>
                 <hr />
                 <h6 class="mb-0 font-weight-bold">TO PAY  <span class="float-right">
                 @if (Session::has('coupon'))
                 ${{ Session()->get('coupon')['discount_amount'] }}
                 @else
                 ${{ $total }}
                 @endif</span></h6>
              </div>

              @else
                <div class="clearfix p-2 mb-2 bg-white rounded">
                 <div class="mb-2 input-group input-group-sm">
                    <input type="text" class="form-control" placeholder="Enter promo code" id="coupon_name">
                    <div class="input-group-append">
                       <button class="btn btn-primary" type="submit" id="button-addon2" onclick="ApplyCoupon()" ><i class="icofont-sale-discount"></i> APPLY</button>
                    </div>
                 </div>
              </div>
              @endif


                   <a href="thanks.html" class="btn btn-success btn-block btn-lg">PAY
                       @if (Session::has('coupon'))
                       ${{ Session()->get('coupon')['discount_amount'] }}
                       @else
                       ${{ $total }}
                       @endif
                   <i class="icofont-long-arrow-right"></i></a>
                   </div>
                   <div class="pt-2"></div>
          </div>
       </div>
    </div>
 </section>

 <script>
    $(document).ready(function() {

       const Toast = Swal.mixin({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 100,
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

       function removeFromCart(id){
          $.ajax({
             url: '{{ route("cart.remove") }}',
             method: 'POST',
             data: {
                _token: '{{ csrf_token() }}',
                id: id
             },
             success: function(response){

                Toast.fire({
                   icon: 'success',
                   title: 'Cart Remove Successfully'
                }).then(() => {
                   location.reload();
                });

             }
          });
       }



    })
  </script>

@endsection
