<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function update(Request $request)
    {
        $user = Auth::user();

        // Validate input and optional image file
        $request->validate([
            'name'   => 'required|string|max:255',
            'email'  => 'required|email|max:255',
            'avatar' => 'nullable|image|max:2048',
        ]);

        // Update name and email
        $user->name  = $request->name;
        $user->email = $request->email;

        // Handle avatar file if uploaded
        if ($request->hasFile('avatar')) {
            $file      = $request->file('avatar');
            $extension = $file->getClientOriginalExtension();
            $filename  = $user->username . '.' . $extension; // Assumes 'username' exists
            $destination = public_path('avatars');
            $file->move($destination, $filename);
            $user->avatar = 'avatars/' . $filename;
        }

        $user->save();
        return redirect()->back()->with('success', 'Profile updated successfully.');
    }
}
