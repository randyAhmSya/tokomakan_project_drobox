<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Coupon;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{

    public function AddtoCart($id)
    {
        if (Session::has('coupon')) {
            session::forget('coupon');
        }
        if (!Auth::check()) { // Gunakan Auth::check() secara eksplisit
            return redirect()->route('login')->with('error', 'You need to login to add items to your cart.');
        }

        $products = Product::find($id);
        if (!$products) {
            return redirect()->back()->with('error', 'Product not found.');
        }

        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $priceToShow = $products->discount_price ?? $products->price;
            $cart[$id] = [
                'id' => $id,
                'name' => $products->name,
                'image' => $products->image,
                'price' => $priceToShow,
                'client_id' => $products->client_id,
                'quantity' => 1,
            ];
        }
        session()->put('cart', $cart);

        $notification = [
            'alert-type' => 'success',
            'message' => 'Product added to cart successfully!',
        ];
        return redirect()->back()->with($notification);
    }

    public function updateCartQuanity(Request $request)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$request->id])) {
            $cart[$request->id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
        }
        return response()->json([
            'message' => 'Quantity Updated',
            'alert-type' => 'success'
        ]);
    }
    public function CartRemove(Request $request)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$request->id])) {
            unset($cart[$request->id]);
            session()->put('cart', $cart);
        }
        return response()->json([
            'message' => 'Cart Remove Successfully',
            'alert-type' => 'success'
        ]);
    }
    //End Method
    public function ApplyCoupon(Request $request)
    {
        $coupon = Coupon::where('coupon_name', $request->coupon_name)->where('validity', '>=', Carbon::now()->format('Y-m-d'))->first();
        $cart = session()->get('cart', []);
        $totalAmount = 0;
        $clientIds = [];
        foreach ($cart as $car) {
            $totalAmount += ($car['price'] * $car['quantity']);
            $pd = Product::find($car['id']);
            $cdid = $pd->client_id;
            array_push($clientIds, $cdid);
        }
        if ($coupon) {
            if (count(array_unique($clientIds)) === 1) {
                $cvendorId = $coupon->client_id;
                if ($cvendorId == $clientIds[0]) {
                    Session::put('coupon', [
                        'coupon_name' => $coupon->coupon_name,
                        'discount' => $coupon->discount,
                        'discount_amount' => $totalAmount - ($totalAmount * $coupon->discount / 100),
                    ]);
                    $couponData = Session()->get('coupon');
                    return response()->json(array(
                        'validity' => true,
                        'success' => 'Coupon Applied Successfully',
                        'couponData' => $couponData,
                    ));
                } else {
                    return response()->json(['error' => 'This Coupon Not Valid for this Restrurant']);
                }
            } else {
                return response()->json(['error' => 'This Coupon for one of the selected Restrurant']);
            }
        } else {
            return response()->json(['error' => 'Invalid Coupon']);
        }
    }
    public function CouponRemove()
    {
        Session::forget('coupon');
        return response()->json(['success' => 'Coupon Remove Successfully']);
    }
    public function Checkout()
    {
        if (Auth::check()) {
            $cart = session::get('cart', []);
            $totalamount = 0;
            foreach ($cart as $car) {
                $totalamount += $car['price'];
            }
            if ($totalamount > 0) {
                return view('frontend.checkout.view_checkout', compact('cart'));
            } else {
                $notification = [
                    'alert-type' => 'error',
                    'message' => 'Please Shoping at list one item',
                ];
                return redirect()->to('/')->with($notification);
            }
        } else {
            $notification = [
                'alert-type' => 'success',
                'message' => 'Please Login First',
            ];
            return redirect()->route('login')->with($notification);
        }
    }
}
