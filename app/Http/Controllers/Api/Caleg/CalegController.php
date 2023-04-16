<?php

namespace App\Http\Controllers\Api\Caleg;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use DB;
use File;
use Image;

class CalegController extends Controller
{
    public function __construct(){
      $this->middleware(['keyverified','useractivated']);
    }

    public function index(request $request){
    }

    public function akses(request $request){
      $data   = DB::table('dt_akses')
                  ->where('id','>',8)
                  ->get();

      if($data) {
        return response()->json($data);
      } else {
        return response()->json([
          'status' => false,
          'message' => 'Data tidak ditemukan',
        ], 401);
      }
    }
}
