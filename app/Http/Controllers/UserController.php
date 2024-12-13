<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        return view('frontend.index');
    }
    public function ProfileStore(Request $request)
    {
        $id = Auth::user()->id;
        $data = User::find($id);

        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address;
        $oldPhotoPath = $data->photo;

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('upload/user_images'), $fileName);
            $data->photo = $fileName;

            if ($oldPhotoPath && $oldPhotoPath !== $fileName) {
                $this->deleteOldImage($oldPhotoPath);
            }
        }
        $data->save();
        $notification = array(
            'alert-type' => 'success',
            'message' => 'Profile updated successfully'
        );
        return redirect()->back()->with($notification);
    }
    private function deleteOldImage(string $oldPhotoPath): void
    {
        $fullePath = public_path('upload/user_images/' . $oldPhotoPath);
        if (file_exists($fullePath)) {
            unlink($fullePath);
        }
    }
    public function UserLogout()
    {
        Auth::guard('web')->logout();
        return redirect()->route('index')->with('logout', 'logout succesfully');
    }
    public function ChangePassword()
    {
        return view('frontend.dashboard.change_password');
    }
    public function UserPasswordUpdate(Request $request)
    {
        $user = Auth::guard('web')->user();

        // Fix validation field names to match the form
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed'
        ]);

        // Check if old password matches
        if (!Hash::check($request->old_password, $user->password)) {
            $notification = [
                'message' => 'Old password does not match',
                'alert-type' => 'error'
            ];
            return redirect()->back()->with($notification);
        }

        // Update password
        User::whereId($user->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        $notification = [
            'message' => 'Password updated successfully',
            'alert-type' => 'success'
        ];

        return redirect()->back()->with($notification);
    }
}
