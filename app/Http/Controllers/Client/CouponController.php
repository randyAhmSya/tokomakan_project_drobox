<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Coupon;

class CouponController extends Controller
{
    public function AllCoupon()
    {
        $cid = Auth::guard('client')->id();
        $coupon = Coupon::where('client_id', $cid)->orderBy('id', 'desc')->get();
        return view('client.backend.coupon.all_coupon', compact('coupon'));
    }
    public function AddCoupon()
    {
        return view('client.backend.coupon.add_coupon');
    }
    public function StoreCoupon(Request $request)
    {


        Coupon::create([
            'coupon_name' => strtoupper($request->coupon_name),
            'coupon_desc' => $request->coupon_desc,
            'discount' => $request->discount,
            'validity' => $request->validity,
            'client_id' => Auth::guard('client')->id(),
            'created_at' => Carbon::now()
        ]);

        $notification = array(
            'alert-type' => 'success',
            'message' => 'Cooupon added successfully'
        );

        return redirect()->route('all.coupon')->with($notification);
    }
    public function EditCoupon($id)
    {
        $coupon = Coupon::find($id);
        return view('client.backend.coupon.edit_coupon', compact('coupon'));
    }
    public function UpdateUpdate(Request $request)
    {
        $coupon_id = $request->id;
        Coupon::find($coupon_id)->update([
            'coupon_name' => strtoupper($request->coupon_name),
            'coupon_desc' => $request->coupon_desc,
            'discount' => $request->discount,
            'validity' => $request->validity,
            'created_at' => Carbon::now()
        ]);

        $notification = array(
            'alert-type' => 'success',
            'message' => 'Cooupon Update successfully'
        );

        return redirect()->route('all.coupon')->with($notification);
    }
    public function DeleteCoupon($id)
    {
        Coupon::find($id)->delete();
        $notification = array(
            'alert-type' => 'success',
            'message' => 'Cooupon deleted successfully'
        );
        return redirect()->back()->with($notification);
    }
}
