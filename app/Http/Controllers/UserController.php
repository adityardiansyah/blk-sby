<?php

namespace App\Http\Controllers;

use App\Http\Repository\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\Group;
use App\Models\UserGroup;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepository $user)
    {
        $this->middleware(function ($request, $next) {
            Session::put('menu_active', '/users');
            return $next($request);
        });
        $this->userRepository = $user;
    }

    public function index(Request $request)
    {
        $user = Auth::user();

        if ($user && $user->group_id == 1) {
            $data = $this->userRepository->get_all();
        } else {
            $data = $this->userRepository->without_admin();
        }

        $group = Group::where('id', '<>', 1)->get();

        return view('page.users', compact('data', 'group'));
    }

    public function show($id)
    {
        $data = $this->userRepository->get_data_by_id($id);
        if (!empty($data)) {
            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        } else {
            return response()->json([
                'success' => false,
                'data' => []
            ]);
        }
    }

    public function store(Request $request)
    {
        $user = $this->userRepository->create($request->all());

        $group_id = $request->group_id;
        $user_id = $user->id;

        UserGroup::create([
            'user_id' => $user_id,
            'group_id' => $group_id,
        ]);

        return response()->json([
            'success' => true,
            'data' => $user,
            'message' => 'Berhasil ditambahkan!'
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'password' => 'required|string|min:6',
            'status' => 'required|in:active,nonactive'
        ]);

        User::where('id', $id)->update([
            'password' => bcrypt($request->input('password')),
            'status' => $request->input('status')
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Diubah!'
        ]);
    }

    public function showPassword($id)
    {
        $data = $this->userRepository->get_data_by_id($id);
        if (!empty($data)) {
            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        } else {
            return response()->json([
                'success' => false,
                'data' => []
            ]);
        }
    }
}
