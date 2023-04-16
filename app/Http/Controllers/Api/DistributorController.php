<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
use File;
use Image;

class DistributorController extends Controller
{
    public function __construct(){
      $this->middleware(['keyverified','useractivated']);
    }

    public function index(request $request){
      $data   = DB::table('users')
                  ->selectRaw('users.id,
                               users.nama,
                               users.foto,
                               users.hp,
                               users.uid,
                               users.alamat,
                               users.propinsi,
                               users.kota,
                               users.kecamatan,
                               users.desa,
                               DATE_FORMAT(users.created_at, "%d %M %Y - %H:%i") as created_at')
                  ->whereNot('users.id',1)
                  ->where('id_akses',2)
                  ->orderby('users.nama')
                  ->get();

      return response()->json($data);
    }
}
