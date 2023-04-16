<?php

namespace App\Http\Controllers\Api;

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
      $userId   = $request->userId;
      $idPartai = $request->idPartai;

      $data   = DB::table('users')
                  ->leftjoin('dt_akses','users.id_akses','=','dt_akses.id')
                  ->selectRaw('users.id, 
                               users.nama, 
                               users.alamat, 
                               users.dusun, 
                               users.rt, 
                               users.rw, 
                               users.propinsi, 
                               users.kota, 
                               users.kecamatan, 
                               users.desa, 
                               users.kelamin, 
                               users.hp, 
                               users.foto, 
                               dt_akses.akses,
                               users.dusun_wilayah, 
                               users.rw_wilayah, 
                               users.rt_wilayah, 
                               users.propinsi_wilayah, 
                               users.kota_wilayah, 
                               users.kecamatan_wilayah, 
                               users.desa_wilayah')
                  ->where('users.id_akses','>',4)
                  ->when($request->idAkses == 2, function ($query) use($userId) {
                      return $query->where('users.id_distributor',$userId);
                    })
                  ->when($request->idAkses == 3, function ($query) use($idPartai) {
                      return $query->where('users.id_partai',$idPartai);
                    })
                  ->when($request->idAkses == 4, function ($query) use($userId) {
                      return $query->where('users.id_caleg',$userId);
                    })
                  ->get();

      return response()->json($data);
    }

    public function baru(request $request){
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
            'id_distributor' => $request->idDistributor,
            'id_partai' => $request->idPartai,
            'id_caleg' => $request->userId,
            'nama' => $request->nama, 
            'alamat' => $request->alamat, 
            'dusun' => $request->dusun, 
            'rt' => $request->rt, 
            'rw' => $request->rw, 
            'no_prop' => $request->no_prop, 
            'no_kab' => $request->no_kab, 
            'no_kec' => $request->no_kec, 
            'no_kel' => $request->no_kel, 
            'propinsi' => $request->propinsi, 
            'kota' => $request->kota, 
            'kecamatan' => $request->kecamatan, 
            'desa' => $request->desa, 
            'kodepos' => $request->kodepos, 
            'lat' => $request->lat, 
            'lng' => $request->lng, 
            'temp_lahir' => $request->temp_lahir, 
            'tgl_lahir' => $request->tgl_lahir, 
            'kelamin' => $request->kelamin, 
            'hp' => $request->hp, 
            'nik' => $request->nik, 
            'id_akses' => $request->id_akses, 
            'email' => $request->email, 
            'status' => 1, 
            'no_prop_wilayah' => $request->no_prop_wilayah ? $request->no_prop_wilayah : null, 
            'no_kab_wilayah' => $request->no_kab_wilayah ? $request->no_kab_wilayah : null, 
            'no_kec_wilayah' => $request->no_kec_wilayah ? $request->no_kec_wilayah : null, 
            'no_kel_wilayah' => $request->no_kel_wilayah ? $request->no_kel_wilayah : null, 
            'propinsi_wilayah' => $request->propinsi_wilayah ? $request->propinsi_wilayah : null, 
            'kota_wilayah' => $request->kota_wilayah ? $request->kota_wilayah : null, 
            'kecamatan_wilayah' => $request->kecamatan_wilayah ? $request->kecamatan_wilayah : null, 
            'desa_wilayah' => $request->desa_wilayah ? $request->desa_wilayah : null, 
            'dusun_wilayah' => $request->dusun_wilayah ? $request->dusun_wilayah : null, 
            'rw_wilayah' => $request->rw_wilayah ? $request->rw_wilayah : null, 
            'rt_wilayah' => $request->rt_wilayah ? $request->rt_wilayah : null,             
            'created' => $request->userId,
            'updated' => $request->userId,
          ]);

        return response()->json([
          'status' => true,
          'message' => 'Data berhasil ditambahkan',
        ], 200);
      }
    }

    public function edit(request $request){
    }

    public function hapus(request $request){
      $cek  = DB::table('users')->where('id',$request->id)->first();

      if($cek){
        DB::table('users')
          ->where('id',$request->id)
          ->delete();

        return response()->json([
          'status' => false,
          'message' => 'Data berhasil dihapus',
        ],200);  
      } else {
        return response()->json([
          'status' => false,
          'message' => 'Data tidak ditemukan',
        ],401);
      }
    }

    public function detil(request $request){
      $data  = DB::table('users')->where('id',$request->id)->first();

      if($data){
        return response()->json($data);
      } else {
        return response()->json([
          'status' => false,
          'message' => 'Data tidak ditemukan',
        ],401);
      }
    }
}
