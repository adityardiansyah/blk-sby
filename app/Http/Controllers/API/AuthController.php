<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Seller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());
        }

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password)
        ]);

        $token = $user->createToken($request->username)->plainTextToken;
        return response()
            ->json(['data' => $user, 'access_token' => $token, 'token_type' => 'Bearer']);
    }

    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('username', 'password')))
        {
            return response()
                ->json(['message' => 'Unauthorized'], 401);
        }

        
        $user = User::where('username', $request['username'])->firstOrFail();
        
        PersonalAccessToken::where('name', $request['username'])->delete();

        $token = $user->createToken($request->username)->plainTextToken;

        return response()
            ->json(['message' => 'Hi '.$user->name.', welcome to home','access_token' => $token, 'token_type' => 'Bearer', ]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->where('tokenable_id', Auth::user()->id)->delete();

        return response()
            ->json([
            'message' => 'You have successfully logged out and the token was successfully deleted'
        ],200);
    }

    public function profile()
    {
        try {
            if(Auth::user()){
                $user = Auth::user();
                $data = Seller::with('shop')->where('user_id', $user->id)->first();
                $data->username = $user->username;
                $data->seller_id = $user->id;
                $data->shop = $data->shop;
        
                return response()->json([
                    'message' => 'Data berhasil ditemukan',
                    'data' => $data,
                ]);
            }else{
                return response()->json([
                    'message' => 'Data user tidak ditemukan',
                    'data' => []
                ], 403);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'data' => []
            ], 400);
        }
    }
}
