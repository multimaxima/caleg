<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use DB;

class UserController extends Controller
{
    public function __construct(){
      $this->middleware(['keyverified','useractivated']);
    }

    public function getUser(request $request){
      $data   = DB::table('users')
                  ->leftjoin('partai','users.id_partai','=','partai.id')
                  ->leftjoin('dt_akses','users.id_akses','=','dt_akses.id')
                  ->selectRaw('users.id,
                               users.uid,
                               users.hp,
                               users.id_caleg,
                               users.id_partai,
                               partai.partai,
                               users.nama,
                               users.foto,
                               users.id_akses,
                               dt_akses.akses')
                  ->where('users.id',$request->userId)
                  ->first();

      if($data){
        return response()->json($data);
      } else {
        return response()->json([
          'status' => false,
          'message' => 'Data tidak ditemukan',
        ], 401);
      }
    }

    public function getUserDetil(request $request){
      $data   = DB::table('users')
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

      if($data){
        return response()->json($data);
      } else {
        return response()->json([
          'status' => false,
          'message' => 'Unauthorized',
        ],401);
      }
    }

    public function getNama(request $request){
      $data   = DB::table('users')
                  ->selectRaw('users.nama')
                  ->where('users.id',$request->userId)
                  ->first();

      if($data){
        return response()->json($data);
      } else {
        return response()->json([
          'status' => false,
          'message' => 'Unauthorized',
        ],401);
      }
    }

    public function getAkses(request $request){
      $data   = DB::table('users')
                  ->selectRaw('users.id_akses')
                  ->where('users.id',$request->userId)
                  ->first();

      if($data){
        return response()->json($data);
      } else {
        return response()->json([
          'status' => false,
          'message' => 'Unauthorized',
        ],401);
      }
    }

    public function profil(request $request){
      $data   = DB::table('users')
                  ->leftjoin('partai','users.id_partai','=','partai.id')
                  ->leftjoin('dt_akses','users.id_akses','=','dt_akses.id')
                  ->selectRaw('users.id, 
                               users.id_distributor, 
                               users.id_partai, 
                               users.id_caleg, 
                               (SELECT x.nama
                                FROM users x
                                WHERE x.id = users.id_caleg) as caleg,
                               users.nama, 
                               users.alamat, 
                               users.dusun, 
                               users.rt, 
                               users.rw, 
                               users.no_prop, 
                               users.no_kab, 
                               users.no_kec, 
                               users.no_kel, 
                               users.propinsi, 
                               users.kota, 
                               users.kecamatan, 
                               users.desa, 
                               users.kodepos, 
                               users.lat, 
                               users.lng, 
                               users.temp_lahir, 
                               users.tgl_lahir, 
                               users.kelamin,
                               users.hp, 
                               users.uid, 
                               users.nik, 
                               users.ktp, 
                               users.foto, 
                               users.id_akses,
                               dt_akses.akses, 
                               users.tingkat, 
                               users.email, 
                               users.status, 
                               users.no_prop_wilayah, 
                               users.no_kab_wilayah, 
                               users.no_kec_wilayah, 
                               users.no_kel_wilayah, 
                               users.dusun_wilayah, 
                               users.rw_wilayah, 
                               users.rt_wilayah, 
                               users.propinsi_wilayah, 
                               users.kota_wilayah, 
                               users.kecamatan_wilayah, 
                               users.desa_wilayah,
                               partai.partai')
                  ->where('users.id',$request->userId)
                  ->first();

      if($data) {
        return response()->json($data);
      } else {
        return response()->json([
          'status' => false,
          'message' => 'Data tidak ditemukan',
        ], 401);
      }
    }    

    public function simpan(request $request){      
      $data   = DB::table('users')
                  ->where('id',$request->userId)
                  ->first();

      if($data) {
        DB::table('users')
          ->where('id',$request->userId)
          ->update([
              'id_distributor' => $request->id_distributor != 'null' ? $request->id_distributor : null, 
              'id_partai' => $request->id_partai != 'null' ? $request->id_partai : null, 
              'id_caleg' => $request->id_caleg != 'null' ? $request->id_caleg : null, 
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
              'nik' => $request->nik, 
              'foto' => $request->foto, 
              'ktp' => $request->ktp, 
              'email' => $request->email, 
              'tingkat' => $request->tingkat, 
              'no_prop_wilayah' => $request->no_prop_wilayah, 
              'no_kab_wilayah' => $request->no_kab_wilayah, 
              'no_kec_wilayah' => $request->no_kec_wilayah, 
              'no_kel_wilayah' => $request->no_kel_wilayah, 
              'dusun_wilayah' => $request->dusun_wilayah, 
              'rw_wilayah' => $request->rw_wilayah, 
              'rt_wilayah' => $request->rt_wilayah, 
              'propinsi_wilayah' => $request->propinsi_wilayah, 
              'kota_wilayah' => $request->kota_wilayah, 
              'kecamatan_wilayah' => $request->kecamatan_wilayah, 
              'desa_wilayah' => $request->desa_wilayah, 
              'updated' => $request->userId,
          ]);

        return response()->json([
          'status' => true,
          'message' => 'Profil berhasil disimpan',
        ], 200);
      } else {
        return response()->json([
          'status' => false,
          'message' => 'Data tidak ditemukan',
        ], 401);
      }
    }

    public function hapus(request $request){
      DB::table('users')
        ->where('id',$request->userId)
        ->delete();

      return response()->json([
        'status' => true,
        'message' => 'Akun berhasil dihapus',
      ], 200);
    }

    public function nama_propinsi($noprop) {
      $data   = DB::table('dt_wilayah')
                  ->selectRaw('nama')
                  ->where('no_prop',$noprop)
                  ->whereNull('no_kab')
                  ->whereNull('no_kec')
                  ->whereNull('no_kel')
                  ->first();

      if($data){
        return $data->nama;
      } else {
        return NULL;
      }      
    }

    public function nama_kota($noprop, $nokab) {
      $data   = DB::table('dt_wilayah')
                  ->selectRaw('nama')
                  ->where('no_prop',$noprop)
                  ->where('no_kab',$nokab)
                  ->whereNull('no_kec')
                  ->whereNull('no_kel')
                  ->first();

      if($data){
        return $data->nama;
      } else {
        return NULL;
      }
    }

    public function nama_kecamatan($noprop, $nokab, $nokec) {
      $data   = DB::table('dt_wilayah')
                  ->selectRaw('nama')
                  ->where('no_prop',$noprop)
                  ->where('no_kab',$nokab)
                  ->where('no_kec',$nokec)
                  ->whereNull('no_kel')
                  ->first();

      if($data){
        return $data->nama;
      } else {
        return NULL;
      }      
    }

    public function nama_kelurahan($noprop, $nokab, $nokec, $nokel) {
      $data   = DB::table('dt_wilayah')
                  ->selectRaw('nama')
                  ->where('no_prop',$noprop)
                  ->where('no_kab',$nokab)
                  ->where('no_kec',$nokec)
                  ->where('no_kel',$nokel)
                  ->first();

      if($data){
        return $data->nama;
      } else {
        return NULL;
      }      
    }
}
