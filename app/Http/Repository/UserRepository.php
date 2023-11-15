<?php

namespace App\Http\Repository;

use App\Models\Conversion;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    protected $user;

    public function __construct(User $con)
    {
        $this->user = $con;
    }

    public function get_all()
    {
        return User::orderBy('id', 'desc')->get();
    }

    public function without_admin()
    {
        return User::where('id', '<>', 1)->orderBy('id', 'desc')->get();
    }

    public function get_data_by_id($id)
    {
        return $this->user->where('id', $id)->first();
    }

    public function create($data)
    {
        $arr = [
            'name' => $data['name'],
            'username' => $data['username'],
            'password' => Hash::make($data['password']),
            'status' => "active",
        ];
        $user = $this->user->create($arr);

        return $user;
    }
}
