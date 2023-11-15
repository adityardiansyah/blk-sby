<?php

namespace App\Http\Controllers;

use App\Http\Repository\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\Group;
use App\Models\UserGroup;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepository $user)
    {
        $this->middleware(function ($request, $next) {
            Session::put('menu_active', '/profile');
            return $next($request);
        });
        $this->userRepository = $user;
    }

    public function index()
    {
        $userId = Auth::check() ? Auth::user()->id : null;

        if ($userId) {
            $user = User::find($userId);

            if ($user) {
                return view('profile.index', compact('user'));
            } else {
                return redirect()->route('home')->with('error', 'User not found.');
            }
        } else {
            return redirect()->route('login')->with('error', 'User not authenticated.');
        }
    }

    public function updatePassword(Request $request, $id)
    {
        $this->validate($request, [
            'current_password' => 'required|string',
            'new_password' => 'required|confirmed|min:8|string'
        ]);

        // $auth = Auth::user();

        #Match The Old Password
        if (!Hash::check($request->current_password, auth()->user()->password)) {
            return back()->with([
                'message' => [
                    'content' => 'Kata sandi saat ini tidak valid!',
                    'type' => 'error'
                ]
            ]);
        }

        #Update the new Password
        User::whereId(auth()->user()->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        return back()->with([
            'message' => [
                'content' => 'Kata sandi berhasil diubah',
                'type' => 'success'
            ]
        ]);
    }
}
