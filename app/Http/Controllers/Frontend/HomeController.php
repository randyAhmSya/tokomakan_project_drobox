<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Gllery;
use App\Models\Menu;
use App\Models\Wishlist;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


class HomeController extends Controller
{
    public function RestaurantDetail($id)
    {
        $client = Client::find($id);
        $menus = Menu::where('client_id', $client->id)->get()->filter(function ($menu) {
            return $menu->products->isNotEmpty();
        });
        $galerys = Gllery::where('client_id', $id)->get();
        return view('frontend.page_detail', compact('client', 'menus', 'galerys'));
    }
    public function AddWishlist(Request $request, $id)
    {
        if (Auth::check()) {
            $exists = Wishlist::where('user_id', Auth::id())->where('client_id', $id)->first();
            if (!$exists) {
                Wishlist::insert([
                    'user_id' => Auth::id(),
                    'client_id' => $id,
                    'created_at' => Carbon::now(),
                ]);
                return response()->json(['success' => 'Your Wishlist Addedd Successfully']);
            } else {
                return response()->json(['error' => 'This product has already on your wishlist']);
            }
        } else {
            return response()->json(['error' => 'First Login Your Account']);
        }
    }
    //End Method
    public function AllWishlist()
    {
        $wishlist = Wishlist::where('user_id', Auth::id())->get();
        return view('frontend.dashboard.all_wishlist', compact('wishlist'));
    }
    public function RemoveWishlist($id)
    {
        Wishlist::find($id)->delete();
        $notification = array(
            'alert-type' => 'danger',
            'message' => 'Wishlist Delete successfully'
        );
        return redirect()->back()->with($notification);
    }
}
