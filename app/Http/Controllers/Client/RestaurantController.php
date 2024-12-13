<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\City;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Carbon\Carbon;
use App\Models\Menu;
use App\Models\Gllery;

class RestaurantController extends Controller
{
    public function AllMenu()
    {
        $id = Auth::guard('client')->id();
        $menu = Menu::where('client_id', $id)->orderBy('id', 'desc')->get();
        return view('client.backend.menu.all_menu', compact('menu'));
    }
    // End Method
    public function AddMenu()
    {
        return view('client.backend.menu.add_menu');
    }
    //end method
    public function StoreMenu(Request $request)
    {
        if ($request->file('image')) {
            $image = $request->file('image');
            $manager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $img = $manager->read($image);
            $img->resize(100, 100)->save(public_path('upload/menu/' . $name_gen));
            $save_url = 'upload/menu/' . $name_gen;

            Menu::create([
                'menu_name' => $request->menu_name,
                'client_id' => Auth::guard('client')->id(),
                'image' => $save_url,
            ]);
        }

        $notification = array(
            'alert-type' => 'success',
            'message' => 'Menu added successfully'
        );

        return redirect()->route('all.menu')->with($notification);
    }
    public function EditMenu($id)
    {
        $menu = Menu::find($id);
        return view('client.backend.menu.edit_menu', compact('menu'));
    }
    public function UpdateMenu(Request $request)
    {

        $cat_id = $request->id;
        if ($request->file('image')) {
            $image = $request->file('image');
            $manager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $img = $manager->read($image);
            $img->resize(300, 300)->save(public_path('upload/menu/' . $name_gen));
            $save_url = 'upload/menu/' . $name_gen;

            Menu::find($cat_id)->update([
                'menu_name' => $request->menu_name,
                'image' => $save_url,
            ]);
            $notification = array(
                'message' => 'menu Updated Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('all.menu')->with($notification);
        } else {
            Menu::find($cat_id)->update([
                'menu_name' => $request->menu_name,
            ]);
            $notification = array(
                'message' => 'menu Updated Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('all.menu')->with($notification);
        }
    }
    public function DeleteMenu($id)
    {
        $menu = Menu::find($id);
        $img = $menu->image;
        unlink($img);

        Menu::find($id)->delete();

        $notification = array(
            'alert-type' => 'error',
            'message' => 'Category deleted successfully'
        );
        return redirect()->back()->with($notification);
    }

    //end menu

    // Start Product
    public function AllProduct()
    {
        $id = Auth::guard('client')->id();
        $product = Product::where('client_id', $id)->orderBy('id', 'desc')->get();
        return view('client.backend.product.all_product', compact('product'));
    }
    public function AddProduct()
    {
        $id = Auth::guard('client')->id();
        $category = Category::latest()->get();
        $menu = Menu::where('client_id', $id)->latest()->get();
        $city = City::latest()->get();
        return view('client.backend.product.add_product', compact('category', 'menu', 'city'));
    }
    public function StoreProduct(Request $request)
    {
        // Fixed the 'length' parameter spelling and set it to a specific value (e.g., 5)
        $pcode = IdGenerator::generate([
            'table' => 'products',
            'field' => 'code',
            'length' => 5,  // Fixed spelling from 'lenght' to 'length'
            'prefix' => 'PC'
        ]);


        if ($request->file('image')) {
            $image = $request->file('image');
            $manager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $img = $manager->read($image);
            $img->resize(300, 300)->save(public_path('upload/product/' . $name_gen));
            $save_url = 'upload/product/' . $name_gen;

            Product::create([
                'name' => $request->name,
                'slug' => strtolower(str_replace(' ', '_', $request->name)),
                'size' => $request->size,
                'qty' => $request->qty, // Pastikan qty ada di sini
                'code' => $pcode,
                'client_id' => Auth::guard('client')->id(),
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

        return redirect()->route('all.product')->with($notification);
    }
    public function EditProduct($id)
    {
        $cid = Auth::guard('client')->id();
        $category = Category::latest()->get();
        $menu = Menu::where('client_id', $cid)->latest()->get();
        $city = City::latest()->get();
        $product = Product::find($id);
        return view('client.backend.product.edit_product', compact('category', 'menu', 'city', 'product'));
    }

    public function UpdateProduct(Request $request)
    {
        $pro_id = $request->id;
        $product = Product::find($pro_id);


        if (!$product) {
            return redirect()->route('all.product')->with([
                'message' => 'Product not found',
                'alert-type' => 'error'
            ]);
        }



        if ($request->file('image')) {
            $image = $request->file('image');
            $manager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $img = $manager->read($image);
            $img->resize(300, 300)->save(public_path('upload/product/' . $name_gen));
            $save_url = 'upload/product/' . $name_gen;


            $product->update([
                'name' => $request->name,
                'slug' => strtolower(str_replace(' ', '-', $request->name)),
                'category_id' => $request->category_id,
                'city_id' => $request->city_id,
                'menu_id' => $request->menu_id,
                'qty' => $request->qty,
                'size' => $request->size,
                'price' => $request->price,
                'discount_price' => $request->discount_price,
                'most_populer' => $request->most_populer,
                'best_seller' => $request->best_seller,
                'updated_at' => Carbon::now(),
                'image' => $save_url,
            ]);
        } else {

            $product->update([
                'name' => $request->name,
                'slug' => strtolower(str_replace(' ', '-', $request->name)),
                'category_id' => $request->category_id,
                'city_id' => $request->city_id,
                'menu_id' => $request->menu_id,
                'qty' => $request->qty,
                'size' => $request->size,
                'price' => $request->price,
                'discount_price' => $request->discount_price,
                'most_populer' => $request->most_populer,
                'best_seller' => $request->best_seller,
                'updated_at' => Carbon::now(),
            ]);
        }

        $notification = [
            'message' => 'Product Updated Successfully',
            'alert-type' => 'success'
        ];

        return redirect()->route('all.product')->with($notification);
    }



    public function DeleteProduct($id)
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
    public function ChangeStatus(Request $request)
    {
        $product = Product::find($request->product_id);
        $product->status = $request->status;
        //$product->status = 0;
        $product->save();
        return response()->json([
            'success' => 'Status Changed Succes',
        ]);
    }

    //galery
    public function AllGallery()
    {
        $cid = Auth::guard('client')->id();
        $gallery = Gllery::where('client_id', $cid)->orderBy('id', 'desc')->get();
        return view('client.backend.gallery.all_gallery', compact('gallery'));
    }
    public function AddGallery()
    {
        return view('client.backend.gallery.add_gallery');
    }
    public function StoreGallery(Request $request)
    {
        if (!$request->hasFile('gallery_image')) {
            return redirect()->back()->with('error', 'Please upload at least one image.');
        }

        $images = $request->file('gallery_image');

        foreach ($images as $gimg) {
            $manager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()) . '.' . $gimg->getClientOriginalExtension();
            $img = $manager->read($gimg);
            $img->resize(800, 800)->save(public_path('upload/gallery/' . $name_gen));
            $save_url = 'upload/gallery/' . $name_gen;

            Gllery::insert([
                'client_id' => Auth::guard('client')->id(),
                'gallery_image' => $save_url,
                'created_at' => now()
            ]);
        } // end foreach

        $notification = array(
            'message' => 'Gallery Inserted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.gallery')->with($notification);
    }
    public function EditGallery($id)
    {
        $gallery = Gllery::find($id);
        return view('client.backend.gallery.edit_gallery', compact('gallery'));
    }
    // End Method
    public function UpdateGallery(Request $request)
    {
        $gallery_id = $request->id;
        if ($request->hasFile('gallery_image')) {
            $image = $request->file('gallery_image');
            $manager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $img = $manager->read($image);
            $img->resize(800, 800)->save(public_path('upload/gallery/' . $name_gen));
            $save_url = 'upload/gallery/' . $name_gen;
            $gallery = Gllery::find($gallery_id);
            if ($gallery->gallery_image) {
                $oldImagePath = public_path($gallery->gallery_image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
            $gallery->update([
                'gallery_image' => $save_url,
            ]);

            $notification = array(
                'message' => 'Menu Updated Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('all.gallery')->with($notification);
        } else {
            $notification = array(
                'message' => 'No Image Selected for Update',
                'alert-type' => 'warning'
            );

            return redirect()->back()->with($notification);
        }
    }
    public function DeleteGallery($id)
    {
        $item = Gllery::find($id);
        $img = $item->gallery_image;
        unlink($img);
        Gllery::find($id)->delete();
        $notification = array(
            'message' => 'Gallery Delete Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
}
