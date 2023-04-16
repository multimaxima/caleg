<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
use File;
use Image;

class PenggunaController extends Controller
{
    public function __construct(){
      $this->middleware(['keyverified','useractivated']);
    }

    public function index(request $request){
      $data   = DB::table('users')
                  ->leftjoin('dt_akses','users.id_akses','=','dt_akses.id')
                  ->selectRaw('users.id,
                               users.nama,
                               users.foto,
                               users.hp,
                               users.uid,
                               users.tingkat,
                               users.id_akses,
                               dt_akses.akses')
                  ->whereNot('users.id',1)
                  ->get();

      return response()->json($data);
    }

    public function baru(request $request) {
      $validator = Validator::make($request->all(), [
        'hp' => 'required|String|unique:users',
      ]);
 
      if ($validator->fails()) {
        return response()->json([
          'status' => false,
          'message' => 'Nomor HP sudah terdaftar',
        ], 401);
      } else {
        DB::table('users')
          ->insert([
            'id_distributor' => $request->userId,
            'id_partai' => $request->id_partai ? $request->id_partai : null,
            'id_caleg' => $request->id_caleg ? $request->id_caleg : null,
            'nama' => $request->nama,
            'hp' => $request->hp,
            'id_akses' => $request->id_akses,
            'tingkat' => $request->tingkat,
            'status' => 1,
            'no_prop_wilayah' => $request->no_prop_wilayah ? $request->no_prop_wilayah : null,
            'no_kab_wilayah' => $request->no_kab_wilayah ? $request->no_kab_wilayah : null,
            'propinsi_wilayah' => $request->propinsi_wilayah ? $request->propinsi_wilayah : null,
            'kota_wilayah' => $request->kota_wilayah ? $request->kota_wilayah : null,
            'created' => $request->userId,
            'updated' => $request->userId,
          ]);

        $data   = DB::table('users')->orderby('id','desc')->first();

        return response()->json([
          'status' => true,
          'message' => 'Data berhasil ditambahkan',
        ], 200);
      }
    }

    public function edit(request $request){
      $cek  = DB::table('users')->where('id',$request->id)->first();

      if($cek){
        $validator = Validator::make($request->all(), [
          'hp' => 'required|string|unique:users,hp,'.$request->id,
        ]);
 
        if ($validator->fails()) {
          return response()->json([
            'status' => false,
            'message' => 'Nomor HP sudah terdaftar',
          ], 401);
        } else {
          DB::table('users')
            ->where('id',$cek->id)
            ->update([
              'id_partai' => $request->id_partai == 'null' ? null : $request->id_partai,
              'id_caleg' => $request->id_caleg == 'null' ? null : $request->id_caleg,
              'nama' => $request->nama,
              'hp' => $request->hp,
              'id_akses' => $request->id_akses,
              'tingkat' => $request->tingkat,
              'no_prop_wilayah' => $request->no_prop_wilayah == 'null' ? null : $request->no_prop_wilayah,
              'no_kab_wilayah' => $request->no_kab_wilayah == 'null' ? null : $request->no_kab_wilayah,
              'propinsi_wilayah' => $request->propinsi_wilayah == 'null' ? null : $request->propinsi_wilayah,
              'kota_wilayah' => $request->kota_wilayah == 'null' ? null : $request->kota_wilayah,
              'updated' => $request->userId,
            ]);
  
          return response()->json([
            'status' => true,
            'message' => 'Data berhasil disimpan',
          ], 200);
        }
      } else {
        return response()->json([
          'status' => false,
          'message' => 'Data tidak ditemukan',
        ], 401);
      }
    }

    public function hapus(request $request){
      $cek  = DB::table('users')->where('id',$request->id)->first();

      if($cek){
        DB::table('users')
          ->where('id',$request->id)
          ->delete();

        return response()->json([
          'status' => true,
          'message' => 'Data berhasil dihapus',
        ], 200);  
      } else {
        return response()->json([
          'status' => false,
          'message' => 'Data tidak ditemukan',
        ], 401);
      }
    }

    public function detil(request $request){
      $cek  = DB::table('users')->where('id',$request->id)->first();

      if($cek){
        $data   = DB::table('users')
                  ->leftjoin('partai','partai.id','=','users.id_partai')
                  ->leftjoin('dt_akses','dt_akses.id','=','users.id_akses')
                  ->selectRaw('users.id,
                               users.nama,
                               users.id_partai,
                               users.id_caleg,
                               users.nama,
                               users.hp,
                               users.uid,
                               users.id_akses,
                               users.tingkat,
                               users.no_prop_wilayah,
                               users.no_kab_wilayah,
                               users.propinsi_wilayah,
                               users.kota_wilayah,
                               partai.partai,
                               (SELECT x.nama
                                FROM users x
                                WHERE x.id = users.id_caleg) as caleg,
                               dt_akses.akses')
                  ->where('users.id',$request->id)
                  ->first();

        return response()->json($data);
      } else {
        return response()->json([
          'status' => false,
          'message' => 'Data tidak ditemukan',
        ], 401);
      }      
    }
}
