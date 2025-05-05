<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class NewPassword extends Controller
{
    //
    public function resetPassword(Request $request)
{
    $request->validate([
        'email_or_username' => 'required|string',
        'password' => 'required|string|confirmed|min:8',
    ]);

    // Find the user by email or username
    $user = User::where('email', $request->email_or_username)
                ->orWhere('username', $request->email_or_username)
                ->first();

    if (!$user) {
        return back()->withErrors(['email_or_username' => __('No user found with this email or username.')]);
    }

    // Update the user's password
    $user->update([
        'password' => Hash::make($request->password),
    ]);

    return redirect()->route('login')->with('success', __('Password reset successfully. You can now log in.'));
}
}
