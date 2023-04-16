<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use DB;

class HomeController extends Controller
{
    public function __construct(){
      $this->middleware(['keyverified','useractivated']);
    }

    public function propinsi(request $request){
      $data   = DB::table('dt_wilayah')
                  ->selectRaw('dt_wilayah.id,
                               dt_wilayah.kode,
                               dt_wilayah.no_prop,
                               dt_wilayah.nama,
                               dt_wilayah.polygon')
                  ->orderby('nama')
                  ->whereNotNull('no_prop')
                  ->whereNull('no_kab')
                  ->whereNull('no_kec')
                  ->whereNull('no_kel')
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

    public function kota(request $request){
      $data   = DB::table('dt_wilayah')
                  ->selectRaw('dt_wilayah.id,
                               dt_wilayah.kode,
                               dt_wilayah.no_prop,
                               dt_wilayah.no_kab,
                               dt_wilayah.nama,
                               dt_wilayah.polygon')
                  ->orderby('nama')
                  ->where('no_prop',$request->no_prop)
                  ->whereNotNull('no_kab')
                  ->whereNull('no_kec')
                  ->whereNull('no_kel')
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

    public function kecamatan(request $request){
      $data   = DB::table('dt_wilayah')
                  ->selectRaw('dt_wilayah.id,
                               dt_wilayah.kode,
                               dt_wilayah.no_prop,
                               dt_wilayah.no_kab,
                               dt_wilayah.no_kec,
                               dt_wilayah.nama,
                               dt_wilayah.polygon')
                  ->orderby('nama')
                  ->where('no_prop',$request->no_prop)
                  ->where('no_kab',$request->no_kab)
                  ->whereNotNull('no_kec')
                  ->whereNull('no_kel')
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

    public function desa(request $request){
      $data   = DB::table('dt_wilayah')
                  ->orderby('nama')
                  ->where('no_prop',$request->no_prop)
                  ->where('no_kab',$request->no_kab)
                  ->where('no_kec',$request->no_kec)
                  ->whereNotNull('no_kel')
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

    public function akses(request $request){
        $data   = DB::table('dt_akses')
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

    public function beranda(request $request){
      $relawan  = DB::table('users')
                    ->where('id_akses','>',2)
                    ->orderby('id','desc')
                    ->limit(4)
                    ->get();

      $suara    = DB::table('data')
                    ->orderby('id','desc')
                    ->limit(4)
                    ->get();

      $user   = DB::table('users')
                  ->leftjoin('partai','users.id_partai','=','partai.id')
                  ->leftjoin('dt_akses','users.id_akses','=','dt_akses.id')
                  ->selectRaw('users.id,
                               users.id_caleg,
                               users.id_partai,
                               partai.partai,
                               users.nama,
                               users.foto,
                               users.id_akses,
                               users.tingkat,
                               users.no_prop_wilayah,
                               users.no_kab_wilayah,
                               users.no_kec_wilayah,
                               users.no_kel_wilayah,
                               dt_akses.akses')
                  ->where('users.id',$request->userId)
                  ->first();

      return response()->json([
        'relawan' => $relawan,
        'suara' => $suara,
        'user' => $user,
      ]);
    }

    public function keygen(request $request){
      $data   = Str::random(256);

      return response()->json($data);
    }
}
