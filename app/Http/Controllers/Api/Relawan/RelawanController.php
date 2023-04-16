<?php

namespace App\Http\Controllers\Api\Relawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use DB;
use File;
use Image;

class RelawanController extends Controller
{
    public function __construct(){
      $this->middleware(['keyverified','useractivated']);
    }

    public function index(request $request){
      $data   = DB::table('users')
                  ->leftjoin('dt_akses','users.id_akses','=','dt_akses.id')
                  ->selectRaw('users.id,
                               users.nama,
                               users.id_akses,
                               dt_akses.akses,
                               users.propinsi_wilayah,
                               users.kota_wilayah,
                               users.kecamatan_wilayah,
                               users.desa_wilayah,
                               users.hp,

                               (SELECT COUNT(x.id)
                                FROM users x
                                WHERE x.id_caleg = users.id_caleg
                                AND x.no_prop_wilayah = users.no_prop_wilayah
                                AND x.id_akses = 6) as kord_kota,

                               (SELECT COUNT(x.id)
                                FROM users x
                                WHERE x.id_caleg = users.id_caleg
                                AND x.no_prop_wilayah = users.no_prop_wilayah
                                AND x.id_akses = 7) as kord_kecamatan,

                               (SELECT COUNT(x.id)
                                FROM users x
                                WHERE x.id_caleg = users.id_caleg
                                AND x.no_prop_wilayah = users.no_prop_wilayah
                                AND x.id_akses = 8) as kord_desa,

                               (SELECT COUNT(x.id)
                                FROM users x
                                WHERE x.id_caleg = users.id_caleg
                                AND x.no_prop_wilayah = users.no_prop_wilayah
                                AND x.id_akses = 9) as kord_tps,

                               (SELECT COUNT(x.id)
                                FROM users x
                                WHERE x.id_caleg = users.id_caleg
                                AND x.no_prop_wilayah = users.no_prop_wilayah
                                AND x.id_akses = 10) as relawan,
                                
                               (SELECT COUNT(data.id)
                                FROM data
                                WHERE data.no_prop = users.no_prop_wilayah
                                AND data.id_caleg = users.id_caleg) as suara')
                  ->where('id_akses',5)
                  ->where('id_caleg',$request->userId)
                  ->get();

      return response()->json($data);
    }
}
