<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\City;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Carbon\Carbon;
use App\Models\Client;
use App\Models\Category;
use App\Models\Menu;
use App\Models\Banner;
use App\Models\Product;
use App\Models\Gllery;

class ManageController extends Controller
{
    public function AdminAllProduct()
    {
        $product = Product::orderBy('id', 'desc')->get();
        return view('admin.backend.products.all_products', compact('product'));
    }
    public function AdminAddProduct()
    {
        $category = Category::latest()->get();
        $city = City::latest()->get();
        $menu = Menu::latest()->get();
        $client = Client::latest()->get();
        return view('admin.backend.products.add_product', compact('category', 'city', 'menu', 'client'));
    }

    public function AdminStoreProduct(Request $request)
    {
        // Fixed the 'length' parameter spelling and set it to a specific value (e.g., 5)
        $pcode = IdGenerator::generate([
            'table' => 'products',
            'field' => 'code',
            'length' => 5,
            'prefix' => 'PC'
        ]);


        if ($request->file('image')) {
            $image = $request->file('image');
            $manager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $img = $manager->read($image);
            $img->resize(100, 100)->save(public_path('upload/product/' . $name_gen));
            $save_url = 'upload/product/' . $name_gen;

            Product::create([
                'name' => $request->name,
                'slug' => strtolower(str_replace(' ', '_', $request->name)),
                'size' => $request->size,
                'qty' => $request->qty, // Pastikan qty ada di sini
                'code' => $pcode,
                'client_id' => $request->client_id,
                'discount_price' => $request->discount_price,
                'price' => $request->price,
                'city_id' => $request->city_id,
                'menu_id' => $request->menu_id,
                'best_seller' => $request->best_seller,
                'most_populer' => $request->most_populer,
                'category_id' => $request->category_id,
                'status' => 1,
                'created_at' => Carbon::now(),
                'image' => $save_url,
            ]);
        }

        $notification = array(
            'alert-type' => 'success',
            'message' => 'Product added successfully'
        );

        return redirect()->route('all.product.admin')->with($notification);
    }
    public function AdminEditProduct($id)
    {
        $product = Product::find($id);
        $category = Category::latest()->get();
        $city = City::latest()->get();
        $menu = Menu::latest()->get();
        $client = Client::latest()->get();
        return view('admin.backend.products.edit_product', compact('product', 'category', 'city', 'menu', 'client'));
    }
    public function AdminUpdateProduct(Request $request)
    {
        $pro_id = $request->id;

        if ($request->file('image')) {
            $image = $request->file('image');
            $manager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $img = $manager->read($image);
            $img->resize(300, 300)->save(public_path('upload/product/' . $name_gen));
            $save_url = 'upload/product/' . $name_gen;
            Product::find($pro_id)->update([
                'name' => $request->name,
                'slug' => strtolower(str_replace(' ', '-', $request->name)),
                'category_id' => $request->category_id,
                'city_id' => $request->city_id,
                'menu_id' => $request->menu_id,
                'client_id' => $request->client_id,
                'qty' => $request->qty,
                'size' => $request->size,
                'price' => $request->price,
                'discount_price' => $request->discount_price,
                'most_populer' => $request->most_populer,
                'best_seller' => $request->best_seller,
                'created_at' => Carbon::now(),
                'image' => $save_url,
            ]);
            $notification = array(
                'message' => 'Product Updated Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('all.product.admin')->with($notification);
        } else {
            Product::find($pro_id)->update([
                'name' => $request->name,
                'slug' => strtolower(str_replace(' ', '-', $request->name)),
                'category_id' => $request->category_id,
                'city_id' => $request->city_id,
                'menu_id' => $request->menu_id,
                'client_id' => $request->client_id,
                'qty' => $request->qty,
                'size' => $request->size,
                'price' => $request->price,
                'discount_price' => $request->discount_price,
                'most_populer' => $request->most_populer,
                'best_seller' => $request->best_seller,
                'created_at' => Carbon::now(),
            ]);

            $notification = array(
                'message' => 'Product Updated Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('all.product.admin')->with($notification);
        }
    }
    // End Method
    public function AdminDeleteProduct($id)
    {
        $item = Product::find($id);
        $img = $item->image;
        unlink($img);
        Product::find($id)->delete();
        $notification = array(
            'message' => 'Product Delete Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
    // End Method
    /// kontroller restourant

    public function AdminPendingRestorant()
    {
        $client = Client::where('status', 0)->get();
        return view('admin.backend.restaurant.pending_restaurants', compact('client'));
    }
    public function ClientchangeStatus(Request $request)
    {
        $client = Client::find($request->client_id);
        $client->status = $request->status;
        //$product->status = 0;
        $client->save();
        return response()->json([
            'success' => 'Status Changed Succes',
        ]);
    }
    public function AdminApproveRestorant()
    {
        $client = Client::where('status', 1)->get();
        return view('admin.backend.restaurant.approve_restaurants', compact('client'));
    }
    //end method
    //Banner method
    public function AllBanner()
    {
        $banner = Banner::latest()->get();
        return view('admin.backend.banner.all_banner', compact('banner'));
    }
    public function BannerStore(Request $request)
    {
        if ($request->file('image')) {
            $image = $request->file('image');
            $manager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $img = $manager->read($image);
            $img->resize(400, 400)->save(public_path('upload/banner/' . $name_gen));
            $save_url = 'upload/banner/' . $name_gen;
            Banner::create([
                'url' => $request->url,
                'image' => $save_url,
            ]);
        }
        $notification = array(
            'message' => 'Banner Inserted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
    // End Method
    public function EditBanner($id)
    {
        $banner = Banner::find($id);
        if ($banner) {
            $banner->image = asset($banner->image);
        }
        return response()->json($banner);
    }
    public function BannerUpdate(Request $request)
    {
        $banner_id = $request->banner_id;
        if ($request->file('image')) {
            $image = $request->file('image');
            $manager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $img = $manager->read($image);
            $img->resize(400, 400)->save(public_path('upload/banner/' . $name_gen));
            $save_url = 'upload/banner/' . $name_gen;
            Banner::find($banner_id)->update([
                'url' => $request->url,
                'image' => $save_url,
            ]);
            $notification = array(
                'message' => 'Banner Updated Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('all.banner')->with($notification);
        } else {
            Banner::find($banner_id)->update([
                'url' => $request->url,
            ]);
            $notification = array(
                'message' => 'Banner Updated Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('all.banner')->with($notification);
        }
    }
    public function DeleteBanner($id)
    {
        $item = Banner::find($id);
        $img = $item->image;
        unlink($img);
        Banner::find($id)->delete();
        $notification = array(
            'message' => 'Banner Delete Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
    // End Method
}
