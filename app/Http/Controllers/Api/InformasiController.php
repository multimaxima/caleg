<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use DB;
use File;
use Image;

class InformasiController extends Controller
{
    public function __construct(){
      $this->middleware(['keyverified','useractivated']);
    }

    public function index(request $request){
      $data   = DB::table('single_data')
                  ->first();

      return response()->json($data);
    }
}
