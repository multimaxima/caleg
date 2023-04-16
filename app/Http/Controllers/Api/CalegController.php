<?php

namespace App\Http\Controllers\Api;

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
      if($request->cari){
        $cari   = $request->cari;
      } else {
        $cari   = '';
      }

      $userId     = $request->userId;
      $idPartai   = $request->idPartai;

      $data   = DB::table('users')
                  ->leftjoin('partai','users.id_partai','=','partai.id')
                  ->leftjoin('dt_akses','users.id_akses','=','dt_akses.id')
                  ->selectRaw('users.id,
                               users.nama,
                               users.foto,
                               users.hp,
                               users.uid,
                               users.id_akses,
                               dt_akses.akses,
                               users.propinsi_wilayah,
                               users.kota_wilayah,
                               users.tingkat,
                               users.status,
                               DATE_FORMAT(users.created_at, "%d %M %Y") as created_at,
                               DATE_FORMAT(DATE_ADD(users.created_at, INTERVAL 1 MONTH), "%d %M %Y") as demo_at,
                               DATE_FORMAT(DATE_ADD(users.created_at, INTERVAL 1 YEAR), "%d %M %Y") as end_at,
                               (SELECT x.nama
                                FROM users x
                                WHERE x.id = users.id_distributor) as distributor,
                               (SELECT COUNT(x.id)
                                FROM users x
                                WHERE x.id_caleg = users.id) as relawan,                               
                               (SELECT COUNT(data.id)
                                FROM data
                                WHERE data.id_caleg = users.id) as suara,
                               users.bayar,
                               partai.partai')
                  ->where('users.id_akses','>',3)
                  ->where('users.id_akses','<',7)
                  ->when($request->idAkses == 2, function ($query) use($userId) {
                      return $query->where('users.id_distributor',$userId);
                    })
                  ->when($request->idAkses == 3, function ($query) use($idPartai) {
                      return $query->where('users.id_partai',$idPartai);
                    })
                  ->when($cari, function ($query) use($cari) {
                      return $query->where('users.nama','LIKE','%'.$cari.'%')
                                   ->orwhere('partai.partai','LIKE','%'.$cari.'%')
                                   ->orwhere('users.propinsi_wilayah','LIKE','%'.$cari.'%')
                                   ->orwhere('users.kota_wilayah','LIKE','%'.$cari.'%');
                    })
                  ->get();

      return response()->json([
        'data' => $data,
        'idAkses' => $request->idAkses,
      ]);
    }

    public function akses(request $request){
      $data   = DB::table('dt_akses')
                  ->where('id','>',3)
                  ->where('id','<',7)
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
            'id_distributor' => $request->userId, 
            'id_partai' => $request->id_partai,
            'nama' => $request->nama, 
            'hp' => $request->hp, 
            'status' => 1, 
            'id_akses' => 4,
            'tingkat' => $request->tingkat,
            'no_prop_wilayah' => $request->no_prop_wilayah, 
            'no_kab_wilayah' => $request->no_kab_wilayah, 
            'propinsi_wilayah' => $request->propinsi_wilayah, 
            'kota_wilayah' => $request->kota_wilayah, 
            'created' => $request->userId, 
            'updated' => $request->userId
          ]);
  
        return response()->json([
          'status' => true,
          'message' => 'Data berhasil disimpan',
        ],200);
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
            ->where('id',$request->id)
            ->update([
              'id_partai' => $request->id_partai, 
              'nama' => $request->nama, 
              'alamat' => $request->alamat, 
              'hp' => $request->hp, 
              'id_akses' => 4,
              'tingkat' => $request->tingkat,
              'no_prop_wilayah' => $request->no_prop_wilayah, 
              'no_kab_wilayah' => $request->no_kab_wilayah, 
              'propinsi_wilayah' => $request->propinsi_wilayah, 
              'kota_wilayah' => $request->kota_wilayah, 
              'created' => $request->userId, 
              'updated' => $request->userId
            ]);

          return response()->json([
            'status' => true,
            'message' => 'Data berhasil disimpan',
          ],200);
        }
      } else {
        return response()->json([
          'status' => false,
          'message' => 'Data tidak ditemukan',
        ],401);
      }
    }

    public function hapus(request $request){
      $cek  = DB::table('users')
                ->where('id',$request->id)
                ->first();

      if($cek){
        DB::table('users')->where('id_caleg',$request->id)->delete();
        DB::table('users')->where('id',$request->id)->delete();

        return response()->json([
          'status' => false,
          'message' => 'Data berhasil dihapus',
        ],200);
      } else {
        return response()->json([
          'status' => false,
          'message' => 'Data tidak ditemukan',
        ],404);
      }
    }

    public function detil(request $request){
      $cek  = DB::table('users')
                ->where('id',$request->id)
                ->first();

      if($cek){
        $data   = DB::table('users')
                    ->leftjoin('partai','users.id_partai','=','partai.id')
                    ->selectRaw('users.id, 
                                 (SELECT x.nama
                                  FROM users x
                                  WHERE x.id = users.id_distributor) as distributor,
                                 partai.partai,
                                 users.nama, 
                                 users.alamat, 
                                 users.dusun, 
                                 users.rt, 
                                 users.rw, 
                                 users.propinsi, 
                                 users.kota, 
                                 users.kecamatan, 
                                 users.desa, 
                                 users.kodepos, 
                                 users.lat, 
                                 users.lng, 
                                 users.temp_lahir, 
                                 DATE_FORMAT(users.tgl_lahir, "%d %M %Y") as tgl_lahir,
                                 users.kelamin, 
                                 users.hp, 
                                 users.uid, 
                                 users.nik, 
                                 users.ktp, 
                                 users.foto, 
                                 users.tingkat, 
                                 users.email, 
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
                                 users.desa_wilayah')
                    ->where('users.id',$request->id)
                    ->first();

        return response()->json($data);
      } else {
        return response()->json([
          'status' => false,
          'message' => 'Data tidak ditemukan',
        ],404);
      }
    }

    public function blokir(request $request){
      $cek  = DB::table('users')
                ->where('id',$request->id)
                ->first();

      if($cek){
        DB::table('users')
          ->where('id_caleg',$request->id)
          ->update([
            'status' => 0,
          ]);

        DB::table('users')
          ->where('id',$request->id)
          ->update([
            'status' => 0,
          ]);

        return response()->json([
          'status' => true,
          'message' => 'Data berhasil diblokir',
        ],200);
      } else {
        return response()->json([
          'status' => false,
          'message' => 'Data tidak ditemukan',
        ],404);
      }
    }

    public function buka(request $request){
      $cek  = DB::table('users')
                ->where('id',$request->id)
                ->first();

      if($cek){
        DB::table('users')
          ->where('id',$request->id)
          ->update([
            'status' => 1,
          ]);

        DB::table('users')
          ->where('id_caleg',$request->id)
          ->update([
            'status' => 1,
          ]);        

        return response()->json([
          'status' => true,
          'message' => 'Blokir berhasil dibuka',
        ],200);
      } else {
        return response()->json([
          'status' => false,
          'message' => 'Data tidak ditemukan',
        ],404);
      }
    }
}
