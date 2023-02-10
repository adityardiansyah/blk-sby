<?php

namespace App\Http\Controllers;

use App\Http\Repository\ConversionRepository;
use App\Models\ProductMaster;
use Illuminate\Http\Request;

class HelperController extends Controller
{
    protected $conversionRepository;

    public function __construct(ConversionRepository $con) {
        $this->conversionRepository = $con;
    }

}
