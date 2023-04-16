<?php

namespace App\Http\Controllers\Api\Caleg;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use DB;

class ChatController extends Controller
{
    public function __construct(){
      $this->middleware(['keyverified','useractivated']);
    }

    public function index(request $request){
      $tingkat  = $request->userTingkat;
      $data     = DB::table('users')
                    ->where('id_caleg',$request->idCaleg)
                    ->get();

      return response()->json([
        'data' => $data,
        'tingkat' => $tingkat,
      ]);
    }
}
