<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Client;

class ClientController extends Controller
{
    public function ClientLogin()
    {
        return view('client.client_login');
    }

    public function ClientRegister()
    {
        return view('client.client_register');
    }
    public function ClientRegisterSubmit(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:200'],
            'email' => ['required', 'string', 'email', 'unique:clients'],
        ]);
        Client::insert([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'address' => $request->address,
            'role' => 'client',
            'status' => '0',
        ]);
        $notification = array(
            'message' => 'Client registered successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('client.login')->with($notification);
    }
    public function ClientLoginSubmit(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $check = $request->all();
        $data = [
            'email' => $check['email'],
            'password' => $check['password'],
        ];

        if (Auth::guard('client')->attempt($data)) {
            return redirect()->route('client.dashboard')->with('success', 'Login successful');
        } else {
            return redirect()->route('client.login')->with('error', 'Invalid Credentials');
        }
    }
    public function ClientDashboard()
    {
        return view('client.index');
    }
    public function ClientLogout()
    {
        Auth::guard('client')->logout();
        return redirect()->route('client.login')->with('success', 'Logout successful');
    }
    public function ClientProfile()
    {
        $city = City::latest()->get();
        $id = Auth::guard('client')->id();
        $profileData = Client::find($id);
        return view('Client.Client_profile', compact('profileData', 'city'));
    }
    public function ClientProfileStore(Request $request)
    {
        $id = Auth::guard('client')->id();
        $data = Client::find($id);

        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address;
        $data->city_id = $request->city_id;
        $data->shop_info = $request->shop_info;

        $oldPhotoPath = $data->photo;

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('upload/client_images'), $fileName);
            $data->photo = $fileName;

            if ($oldPhotoPath && $oldPhotoPath !== $fileName) {
                $this->deleteOldImage($oldPhotoPath);
            }
        }
        if ($request->hasFile('cover_photo')) {
            $file1 = $request->file('cover_photo');
            $fileName1 = time() . '.' . $file1->getClientOriginalExtension();
            $file1->move(public_path('upload/client_images'), $fileName1);
            $data->cover_photo = $fileName1;
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
        $fullePath = public_path('upload/client_images/' . $oldPhotoPath);
        if (file_exists($fullePath)) {
            unlink($fullePath);
        }
    }
    public function ClientChangePassword()
    {
        $id = Auth::guard('client')->id();
        $profileData = Client::find($id);
        return view('client.client_change_password', compact('profileData'));
    }
    public function ClientPasswordUpdate(Request $request)
    {
        $client = Auth::guard('client')->user();

        // Fix validation field names to match the form
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed'
        ]);

        // Check if old password matches
        if (!Hash::check($request->old_password, $client->password)) {
            $notification = [
                'message' => 'Old password does not match',
                'alert-type' => 'error'
            ];
            return redirect()->back()->with($notification);
        }

        // Update password
        Client::whereId($client->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        $notification = [
            'message' => 'Password updated successfully',
            'alert-type' => 'success'
        ];

        return redirect()->back()->with($notification);
    }
}
