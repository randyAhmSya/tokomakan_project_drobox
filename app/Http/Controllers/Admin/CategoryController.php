<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\City;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class CategoryController extends Controller
{
    public function AllCategory()
    {
        $category = Category::latest()->get();
        return view('admin.backend.category.all_category', compact('category'));
    }
    public function AddCategory()
    {
        return view('admin.backend.category.add_category');
    }
    public function StoreCategory(Request $request)
    {
        if ($request->file('image')) {
            $image = $request->file('image');
            $manager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $img = $manager->read($image);
            $img->resize(100, 100)->save(public_path('upload/category/' . $name_gen));
            $save_url = 'upload/category/' . $name_gen;

            Category::create([
                'category_name' => $request->category_name,
                'image' => $save_url,
            ]);
        }

        $notification = array(
            'alert-type' => 'success',
            'message' => 'Category added successfully'
        );

        return redirect()->route('all.category')->with($notification);
    }
    public function EditCategory($id)
    {
        $category = Category::find($id);
        return view('admin.backend.category.edit_category', compact('category'));
    }
    // End Method
    public function UpdateCategory(Request $request)
    {

        $cat_id = $request->id;
        if ($request->file('image')) {
            $image = $request->file('image');
            $manager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $img = $manager->read($image);
            $img->resize(300, 300)->save(public_path('upload/category/' . $name_gen));
            $save_url = 'upload/category/' . $name_gen;

            Category::find($cat_id)->update([
                'category_name' => $request->category_name,
                'image' => $save_url,
            ]);
            $notification = array(
                'message' => 'Category Updated Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('all.category')->with($notification);
        } else {
            Category::find($cat_id)->update([
                'category_name' => $request->category_name,
            ]);
            $notification = array(
                'message' => 'Category Updated Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('all.category')->with($notification);
        }
    }
    public function DeleteCategory($id)
    {
        $category = Category::find($id);
        $img = $category->image;
        unlink($img);

        Category::find($id)->delete();

        $notification = array(
            'alert-type' => 'error',
            'message' => 'Category deleted successfully'
        );
        return redirect()->back()->with($notification);
    }

    //end category
    public function AllCity()
    {
        $city = City::latest()->get();
        return view('admin.backend.city.all_city', compact('city'));
    }
    public function StoreCity(Request $request)
    {
        City::create([
            'city_name' => $request->city_name,
            'city_slug' => strtolower(str_replace(' ', '_', $request->city_name)),
        ]);

        $notification = array(
            'alert-type' => 'success',
            'message' => 'City added successfully'
        );

        return redirect()->back()->with($notification);
    }

    public function EditCity($id)
    {
        $city = City::findOrFail($id);
        return response()->json($city);
    }

    public function UpdateCity(Request $request)
    {
        $city_id = $request->city_id;

        City::findOrFail($city_id)->update([
            'city_name' => $request->city_name,
            'city_slug' => strtolower(str_replace(' ', '_', $request->city_name)),
        ]);

        $notification = array(
            'alert-type' => 'success',
            'message' => 'City updated successfully'
        );

        return redirect()->back()->with($notification);
    }

    public function DeleteCity($id)
    {
        City::findOrFail($id)->delete();

        $notification = array(
            'alert-type' => 'error',
            'message' => 'City deleted successfully'
        );

        return redirect()->back()->with($notification);
    }
}
