<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Repository\AdjusmentRepository;
use App\Models\Adjusment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdjusmentController extends Controller
{
    protected $adjusment;

    public function __construct(AdjusmentRepository $adjs)
    {
        $this->adjusment = $adjs;
    }

    public function adjusment_in()
    {
        $data = $this->adjusment->get_adjusment_in();

        return response().json([
            'message' => 'Data Adjusment In',
            'data' => $data
        ]);
    }
    
    public function adjusment_out()
    {
        $data = $this->adjusment->get_adjusment_out();

        return response().json([
            'message' => 'Data Adjusment Out',
            'data' => $data
        ]);
    }
}