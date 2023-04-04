<?php

namespace App\Http\Controllers;

use App\Http\Repository\SellerRepository;
use App\Http\Repository\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\User;

class UserController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepository $us) {
        $this->middleware(function ($request, $next){
            Session::put('menu_active','users');
            return $next($request);
        });
        $this->userRepository = $us;
    }
    
    public function index(Request $request)
    {
        $data = $this->userRepository->get_all();
        return view('page.users', compact('data'));
    }

    public function show($id) {
        $data = $this->userRepository->get_data_by_id($id);
        if(!empty($data)){
            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        }else{
            return response()->json([
                'success' => false,
                'data' => []
            ]);
        }
    }

    public function store(Request $request)
    {
        $user = $this->userRepository->create($request->all());
        $this->userRepository->create($request->all());
        
        return response()->json([
            'success'=>true,
            'message' => 'Berhasil ditambahkan!' 
        ]);
    }

    public function update(Request $request, $id)
    {
        return $request->all();
        $this->validate($request,[
        ]);
        $data = User::find($id);
        $data->password = $request->input('password');
        $data->status = $request->input('status');
        $data->save();

        return redirect()->to('/users')->with('message', ['type' => 'success','content' => 'Data berhasil diupdate']);
    }
}
