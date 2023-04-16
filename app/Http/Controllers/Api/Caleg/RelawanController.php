<?php

namespace App\Http\Controllers\Api\Caleg;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use DB;

class RelawanController extends Controller
{
    public function __construct(){
      $this->middleware(['keyverified','useractivated']);
    }

    public function index(request $request){
      //$data   = Relawan::where('id_akses','>',$request->idAkses)                
                //->with(str_repeat('children.',20))
                //->where('id_caleg',$request->userId)
                //->where('id_akses',$bawahan)
                //->get();

      if($request->userTingkat == 'NASIONAL'){
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
      }

      if($request->userTingkat == 'PROPINSI'){
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
                                AND x.no_kab_wilayah = users.no_kab_wilayah
                                AND x.id_akses = 7) as kord_kecamatan,
                               (SELECT COUNT(x.id)
                                FROM users x
                                WHERE x.id_caleg = users.id_caleg
                                AND x.no_prop_wilayah = users.no_prop_wilayah
                                AND x.no_kab_wilayah = users.no_kab_wilayah
                                AND x.id_akses = 8) as kord_desa,
                               (SELECT COUNT(x.id)
                                FROM users x
                                WHERE x.id_caleg = users.id_caleg
                                AND x.no_prop_wilayah = users.no_prop_wilayah
                                AND x.no_kab_wilayah = users.no_kab_wilayah
                                AND x.id_akses = 9) as kord_tps,
                               (SELECT COUNT(x.id)
                                FROM users x
                                WHERE x.id_caleg = users.id_caleg
                                AND x.no_prop_wilayah = users.no_prop_wilayah
                                AND x.no_kab_wilayah = users.no_kab_wilayah
                                AND x.id_akses = 10) as relawan,
                               (SELECT COUNT(data.id)
                                FROM data
                                WHERE data.no_prop = users.no_prop_wilayah
                                AND data.no_kab = users.no_kab_wilayah
                                AND data.id_caleg = users.id_caleg) as suara')
                  ->where('id_akses',6)
                  ->where('id_caleg',$request->userId)
                  ->get();
      }

      if($request->userTingkat == 'KABUPATEN/KOTA'){
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
                                AND x.no_kab_wilayah = users.no_kab_wilayah
                                AND x.no_kec_wilayah = users.no_kec_wilayah
                                AND x.id_akses = 8) as kord_desa,
                               (SELECT COUNT(x.id)
                                FROM users x
                                WHERE x.id_caleg = users.id_caleg
                                AND x.no_prop_wilayah = users.no_prop_wilayah
                                AND x.no_kab_wilayah = users.no_kab_wilayah
                                AND x.no_kec_wilayah = users.no_kec_wilayah
                                AND x.id_akses = 9) as kord_tps,
                               (SELECT COUNT(x.id)
                                FROM users x
                                WHERE x.id_caleg = users.id_caleg
                                AND x.no_prop_wilayah = users.no_prop_wilayah
                                AND x.no_kab_wilayah = users.no_kab_wilayah
                                AND x.no_kec_wilayah = users.no_kec_wilayah
                                AND x.id_akses = 10) as relawan,
                               (SELECT COUNT(data.id)
                                FROM data
                                WHERE data.no_prop = users.no_prop_wilayah
                                AND data.no_kab = users.no_kab_wilayah
                                AND data.no_kec = users.no_kec_wilayah
                                AND data.id_caleg = users.id_caleg) as suara')
                  ->where('id_akses',7)
                  ->where('id_caleg',$request->userId)
                  ->get();
      }

      return response()->json([
        'data' => $data,
        'tingkat' => $request->userTingkat,
        'id_atasan' => $request->userId,
      ]);
    }

    public function baru(request $request){
      $cek1 = DB::table('users')
                ->where('hp',$request->hp)
                ->whereNull('id_caleg')
                ->count();

      $cek2 = DB::table('users')
                ->where('hp',$request->hp)
                ->whereNotNull('id_caleg')
                ->count();

      if($cek2 == 0){
        $parent   = DB::table('users')->where('id',$request->parent)->first();

        if($parent->id_akses == 4){
          $id_caleg = $parent->id;
        } else {
          $id_caleg = $parent->id_caleg;
        }

        if($request->id_akses == 5){
          $id_kord_prop = null;
          $id_kord_kab = null;
          $id_kord_kec = null;
          $id_kord_kel = null;
        } else {
          if($request->id_akses == 6){
            $id_kord_prop = $parent->id;
            $id_kord_kab = null;
            $id_kord_kec = null;
            $id_kord_kel = null;
          } else {
            if($request->id_akses == 7){
              $id_kord_prop = $parent->id_kord_prop;
              $id_kord_kab = $parent->id;
              $id_kord_kec = null;
              $id_kord_kel = null;
            } else {
              if($request->id_akses == 8){
                $id_kord_prop = $parent->id_kord_prop;
                $id_kord_kab = $parent->id_kord_kab;
                $id_kord_kec = $parent->id;
                $id_kord_kel = null;
              } else {
                $id_kord_prop = $parent->id_kord_prop;
                $id_kord_kab = $parent->id_kord_kab;
                $id_kord_kec = $parent->id_kord_kec;
                $id_kord_kel = $parent->id;
              }
            }
          }
        }

        if($cek1 == 0){
          DB::table('users')
            ->insert([
              'id_distributor' => $parent->id_distributor, 
              'id_partai' => $parent->id_partai, 
              'id_caleg' => $id_caleg,

              'id_kord_prop' => $id_kord_prop, 
              'id_kord_kab' => $id_kord_kab, 
              'id_kord_kec' => $id_kord_kec, 
              'id_kord_kel' => $id_kord_kel, 

              'nama' => $request->nama, 
              'alamat' => $request->alamat, 
              'dusun' => $request->dusun, 
              'rt' => $request->rt, 
              'rw' => $request->rw, 
              'no_prop' => $request->no_prop, 
              'no_kab' => $request->no_kab, 
              'no_kec' => $request->no_kec, 
              'no_kel' => $request->no_kel, 
              'propinsi' => $this->nama_propinsi($request->no_prop),
              'kota' => $this->nama_kota($request->no_prop, $request->no_kab),
              'kecamatan' => $this->nama_kecamatan($request->no_prop, $request->no_kab, $request->no_kec),
              'desa' => $this->nama_kelurahan($request->no_prop, $request->no_kab, $request->no_kec, $request->no_kel),
              'kodepos' => $request->kodepos, 
              'lat' => $request->lat, 
              'lng' => $request->lng, 
              'temp_lahir' => $request->temp_lahir, 
              'tgl_lahir' => $request->tgl_lahir != 'null' ? $request->tgl_lahir : null, 
              'kelamin' => $request->kelamin, 
              'hp' => $request->hp, 
              'nik' => $request->nik, 
              'ktp' => $request->ktp, 
              'foto' => $request->foto, 
              'id_akses' => $request->id_akses, 
              'akses' => $this->akses($request->id_akses),
              'tingkat' => $parent->tingkat, 
              'email' => $request->email, 

              'no_prop_wilayah' => $request->no_prop_wilayah, 
              'no_kab_wilayah' => $request->no_kab_wilayah, 
              'no_kec_wilayah' => $request->no_kec_wilayah, 
              'no_kel_wilayah' => $request->no_kel_wilayah,             
              'propinsi_wilayah' => $this->nama_propinsi($request->no_prop_wilayah),
              'kota_wilayah' => $this->nama_kota($request->no_prop_wilayah, $request->no_kab_wilayah),
              'kecamatan_wilayah' => $this->nama_kecamatan($request->no_prop_wilayah, $request->no_kab_wilayah, $request->no_kec_wilayah),
              'desa_wilayah' => $this->nama_kelurahan($request->no_prop_wilayah, $request->no_kab_wilayah, $request->no_kec_wilayah, $request->no_kel_wilayah),

              'dusun_wilayah' => $request->dusun_wilayah, 
              'rw_wilayah' => $request->rw_wilayah, 
              'rt_wilayah' => $request->rt_wilayah, 
              'created' => $request->userId, 
              'updated' => $request->userId, 
              'id_parent' => $parent->id,
            ]);

          return response()->json([
            'status' => true,
            'message' => 'Data berhasil ditambahkan',
          ], 200);
        } else {
          DB::table('users')
            ->where('id',$cek1->id)
            ->update([
              'id_distributor' => $parent->id_distributor, 
              'id_partai' => $parent->id_partai, 
              'id_caleg' => $id_caleg,
              'id_kord_prop' => $parent->id_kord_prop, 
              'id_kord_kab' => $parent->id_kord_kab, 
              'id_kord_kec' => $parent->id_kord_kec, 
              'id_kord_kel' => $parent->id_kord_kel, 
              'nama' => $request->nama, 
              'alamat' => $request->alamat, 
              'dusun' => $request->dusun, 
              'rt' => $request->rt, 
              'rw' => $request->rw, 
              'no_prop' => $request->no_prop, 
              'no_kab' => $request->no_kab, 
              'no_kec' => $request->no_kec, 
              'no_kel' => $request->no_kel, 
              'propinsi' => $this->nama_propinsi($request->no_prop),
              'kota' => $this->nama_kota($request->no_prop, $request->no_kab),
              'kecamatan' => $this->nama_kecamatan($request->no_prop, $request->no_kab, $request->no_kec),
              'desa' => $this->nama_kelurahan($request->no_prop, $request->no_kab, $request->no_kec, $request->no_kel),
              'kodepos' => $request->kodepos, 
              'lat' => $request->lat, 
              'lng' => $request->lng, 
              'temp_lahir' => $request->temp_lahir, 
              'tgl_lahir' => $request->tgl_lahir != 'null' ? $request->tgl_lahir : null, 
              'kelamin' => $request->kelamin, 
              'nik' => $request->nik, 
              'ktp' => $request->ktp, 
              'foto' => $request->foto, 
              'id_akses' => $request->id_akses, 
              'akses' => $this->akses($request->id_akses),
              'tingkat' => $parent->tingkat, 
              'email' => $request->email, 

              'no_prop_wilayah' => $request->no_prop_wilayah, 
              'no_kab_wilayah' => $request->no_kab_wilayah, 
              'no_kec_wilayah' => $request->no_kec_wilayah, 
              'no_kel_wilayah' => $request->no_kel_wilayah,             
              'propinsi_wilayah' => $this->nama_propinsi($request->no_prop_wilayah),
              'kota_wilayah' => $this->nama_kota($request->no_prop_wilayah, $request->no_kab_wilayah),
              'kecamatan_wilayah' => $this->nama_kecamatan($request->no_prop_wilayah, $request->no_kab_wilayah, $request->no_kec_wilayah),
              'desa_wilayah' => $this->nama_kelurahan($request->no_prop_wilayah, $request->no_kab_wilayah, $request->no_kec_wilayah, $request->no_kel_wilayah),

              'dusun_wilayah' => $request->dusun_wilayah, 
              'rw_wilayah' => $request->rw_wilayah, 
              'rt_wilayah' => $request->rt_wilayah, 
              'created' => $request->userId, 
              'updated' => $request->userId, 
              'id_parent' => $parent->id,
            ]);

          return response()->json([
            'status' => true,
            'message' => 'Data berhasil ditambahkan',
          ], 200);
        }
      } else {
        return response()->json([
          'status' => false,
          'message' => 'Nomor HP sudah terdaftar',
        ], 401);
      }
    }

    public function edit(request $request){
      $cek  = DB::table('users')->where('id',$request->id)->first();

      if($cek){
        DB::table('users')
          ->where('id',$cek->id)
          ->update([
            'nama' => $request->nama, 
            'alamat' => $request->alamat, 
            'dusun' => $request->dusun, 
            'rt' => $request->rt, 
            'rw' => $request->rw, 
            'no_prop' => $request->no_prop, 
            'no_kab' => $request->no_kab, 
            'no_kec' => $request->no_kec, 
            'no_kel' => $request->no_kel, 
            'propinsi' => $this->nama_propinsi($request->no_prop),
            'kota' => $this->nama_kota($request->no_prop, $request->no_kab),
            'kecamatan' => $this->nama_kecamatan($request->no_prop, $request->no_kab, $request->no_kec),
            'desa' => $this->nama_kelurahan($request->no_prop, $request->no_kab, $request->no_kec, $request->no_kel),
            'kodepos' => $request->kodepos, 
            'lat' => $request->lat, 
            'lng' => $request->lng, 
            'temp_lahir' => $request->temp_lahir, 
            'tgl_lahir' => $request->tgl_lahir != 'null' ? $request->tgl_lahir : null, 
            'kelamin' => $request->kelamin, 
            'nik' => $request->nik, 
            'ktp' => $request->ktp, 
            'foto' => $request->foto, 
            'id_akses' => $request->id_akses, 
            'akses' => $this->akses($request->id_akses),
            'tingkat' => $parent->tingkat, 
            'email' => $request->email, 

            'no_prop_wilayah' => $request->no_prop_wilayah, 
            'no_kab_wilayah' => $request->no_kab_wilayah, 
            'no_kec_wilayah' => $request->no_kec_wilayah, 
            'no_kel_wilayah' => $request->no_kel_wilayah,             
            'propinsi_wilayah' => $this->nama_propinsi($request->no_prop_wilayah),
            'kota_wilayah' => $this->nama_kota($request->no_prop_wilayah, $request->no_kab_wilayah),
            'kecamatan_wilayah' => $this->nama_kecamatan($request->no_prop_wilayah, $request->no_kab_wilayah, $request->no_kec_wilayah),
            'desa_wilayah' => $this->nama_kelurahan($request->no_prop_wilayah, $request->no_kab_wilayah, $request->no_kec_wilayah, $request->no_kel_wilayah),

            'dusun_wilayah' => $request->dusun_wilayah, 
            'rw_wilayah' => $request->rw_wilayah, 
            'rt_wilayah' => $request->rt_wilayah, 
            'updated' => $request->userId, 
          ]);

        return response()->json([
          'status' => true,
          'message' => 'Data berhasil disimpan',
        ], 200);
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
          'status' => false,
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
      if($request->id > 0){
        $data   = DB::table('users')
                  ->leftjoin('dt_akses','users.id_akses','=','dt_akses.id')
                  ->selectRaw('users.id, 
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
                               users.nik, 
                               users.ktp, 
                               users.foto, 
                               users.id_akses, 
                               dt_akses.akses,
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
      } else {
        $data = "";
      }

      $parent   = DB::table('users')
                  ->where('id',$request->id_parent)
                  ->first();

      return response()->json([
        'data' => $data,
        'parent' => $parent,
      ], 200);
    }

    public function anggota(request $request){
      $user   = DB::table('users')
                  ->where('id',$request->id)
                  ->first();

      if($user->id_akses == 5){
        $data = DB::table('users')
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
                                AND x.id_kord_prop = users.id_kord_prop
                                AND x.id_kord_kab = users.id
                                AND x.id_akses = 7) as kord_kecamatan,

                               (SELECT COUNT(x.id)
                                FROM users x
                                WHERE x.id_caleg = users.id_caleg
                                AND x.id_kord_prop = users.id_kord_prop
                                AND x.id_kord_kab = users.id
                                AND x.id_akses = 8) as kord_desa,

                               (SELECT COUNT(x.id)
                                FROM users x
                                WHERE x.id_caleg = users.id_caleg
                                AND x.id_kord_prop = users.id_kord_prop
                                AND x.id_kord_kab = users.id
                                AND x.id_akses = 9) as kord_tps,

                               (SELECT COUNT(x.id)
                                FROM users x
                                WHERE x.id_caleg = users.id_caleg
                                AND x.id_kord_prop = users.id_kord_prop
                                AND x.id_kord_kab = users.id
                                AND x.id_akses = 10) as relawan,

                               (SELECT COUNT(data.id)
                                FROM data
                                WHERE data.no_prop = users.no_prop_wilayah
                                AND data.no_kab = users.no_kab_wilayah
                                AND data.id_caleg = users.id_caleg) as suara')

                  ->where('users.id_akses',6)
                  ->where('users.id_caleg',$user->id_caleg)
                  ->where('users.id_kord_prop',$user->id)
                  ->get();
      }

      if($user->id_akses == 6){
        $data = DB::table('users')
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
                                AND x.id_kord_prop = '.$user->id_kord_prop.'
                                AND x.id_kord_kab = '.$user->id.'
                                AND x.id_kord_kec = users.id
                                AND x.id_akses = 8) as kord_desa,

                               (SELECT COUNT(x.id)
                                FROM users x
                                WHERE x.id_caleg = users.id_caleg
                                AND x.id_kord_prop = '.$user->id_kord_prop.'
                                AND x.id_kord_kab = '.$user->id.'
                                AND x.id_kord_kec = users.id
                                AND x.id_akses = 9) as kord_tps,

                               (SELECT COUNT(x.id)
                                FROM users x
                                WHERE x.id_caleg = users.id_caleg
                                AND x.id_kord_prop = '.$user->id_kord_prop.'
                                AND x.id_kord_kab = '.$user->id.'
                                AND x.id_kord_kec = users.id
                                AND x.id_akses = 10) as relawan,

                               (SELECT COUNT(data.id)
                                FROM data
                                WHERE data.no_prop = users.no_prop_wilayah
                                AND data.no_kab = users.no_kab_wilayah
                                AND data.no_kec = users.no_kec_wilayah
                                AND data.id_caleg = users.id_caleg) as suara')

                  ->where('users.id_akses',7)
                  ->where('users.id_caleg',$user->id_caleg)
                  ->where('users.id_kord_prop',$user->id_kord_prop)
                  ->where('users.id_kord_kab',$user->id)
                  ->get();
      }

      if($user->id_akses == 7){
        $data = DB::table('users')
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
                                AND x.id_kord_prop = '.$user->id_kord_prop.'
                                AND x.id_kord_kab = '.$user->id_kord_kab.'
                                AND x.id_kord_kec = '.$user->id.'
                                AND x.id_kord_kel = users.id
                                AND x.id_akses = 9) as kord_tps,

                               (SELECT COUNT(x.id)
                                FROM users x
                                WHERE x.id_caleg = users.id_caleg
                                AND x.id_kord_prop = '.$user->id_kord_prop.'
                                AND x.id_kord_kab = '.$user->id_kord_kab.'
                                AND x.id_kord_kec = '.$user->id.'
                                AND x.id_kord_kel = users.id
                                AND x.id_akses = 10) as relawan,

                               (SELECT COUNT(data.id)
                                FROM data
                                WHERE data.no_prop = users.no_prop_wilayah
                                AND data.no_kab = users.no_kab_wilayah
                                AND data.no_kec = users.no_kec_wilayah
                                AND data.no_kel = users.no_kel_wilayah
                                AND data.id_caleg = users.id_caleg) as suara')

                  ->where('users.id_akses',8)
                  ->where('users.id_caleg',$user->id_caleg)
                  ->where('users.id_kord_prop',$user->id_kord_prop)
                  ->where('users.id_kord_kab',$user->id_kord_kab)
                  ->where('users.id_kord_kec',$user->id)
                  ->get();
      }

      if($user->id_akses == 8){
        $data = DB::table('users')
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
                                AND x.id_kord_prop = '.$user->id_kord_prop.'
                                AND x.id_kord_kab = '.$user->id_kord_kab.'
                                AND x.id_kord_kec = '.$user->id_kord_kec.'
                                AND x.id_kord_kel = users.id
                                AND x.id_akses = 9) as kord_tps,

                               (SELECT COUNT(x.id)
                                FROM users x
                                WHERE x.id_caleg = users.id_caleg
                                AND x.id_kord_prop = '.$user->id_kord_prop.'
                                AND x.id_kord_kab = '.$user->id_kord_kab.'
                                AND x.id_kord_kec = '.$user->id_kord_kec.'
                                AND x.id_kord_kel = users.id
                                AND x.id_akses = 10) as relawan,

                               (SELECT COUNT(data.id)
                                FROM data
                                WHERE data.id_caleg = users.id_caleg
                                AND data.no_prop = users.no_prop_wilayah
                                AND data.no_kab = users.no_kab_wilayah
                                AND data.no_kec = users.no_kec_wilayah
                                AND data.no_kel = users.id) as suara')

                  ->where('users.id_akses','>',8)
                  ->where('users.id_caleg',$user->id_caleg)
                  ->where('users.id_kord_prop',$user->id_kord_prop)
                  ->where('users.id_kord_kab',$user->id_kord_kab)
                  ->where('users.id_kord_kec',$user->id_kord_kec)
                  ->where('users.id_kord_kec',$user->id)
                  ->get();
      }

      return response()->json([
        'data' => $data,
        'user' => $user,
      ]);
    }

    public function daftar(request $request){
      if($request->idAkses == 4){
        $data   = DB::table('users')
                    ->leftjoin('dt_akses','users.id_akses','=','dt_akses.id')
                    ->selectRaw('users.id,
                                 users.nama,
                                 users.hp,
                                 users.foto,
                                 users.id_akses,
                                 dt_akses.akses,
                                 users.propinsi_wilayah,
                                 users.kota_wilayah,
                                 users.kecamatan_wilayah,
                                 users.desa_wilayah,
                                 users.suara')
                    ->where('users.id_caleg',$request->userId)
                    ->orderby('users.nama')
                    ->get();
      }

      if($request->idAkses == 5){
        $data   = DB::table('users')
                    ->leftjoin('dt_akses','users.id_akses','=','dt_akses.id')
                    ->selectRaw('users.id,
                                 users.nama,
                                 users.hp,
                                 users.foto,
                                 users.id_akses,
                                 dt_akses.akses,
                                 users.propinsi_wilayah,
                                 users.kota_wilayah,
                                 users.kecamatan_wilayah,
                                 users.desa_wilayah,
                                 users.suara')
                    ->where('users.id_caleg',$request->idCaleg)
                    ->where('users.id_kord_prop',$request->userId)
                    ->orderby('users.nama')
                    ->get();
      }

      if($request->idAkses == 6){
        $data   = DB::table('users')
                    ->leftjoin('dt_akses','users.id_akses','=','dt_akses.id')
                    ->selectRaw('users.id,
                                 users.nama,
                                 users.hp,
                                 users.foto,
                                 users.id_akses,
                                 dt_akses.akses,
                                 users.propinsi_wilayah,
                                 users.kota_wilayah,
                                 users.kecamatan_wilayah,
                                 users.desa_wilayah,
                                 users.suara')
                    ->where('users.id_caleg',$request->idCaleg)
                    ->where('users.id_kord_prop',$request->idKordProp)
                    ->where('users.id_kord_kab',$request->userId)
                    ->orderby('users.nama')
                    ->get();
      }

      if($request->idAkses == 7){
        $data   = DB::table('users')
                    ->leftjoin('dt_akses','users.id_akses','=','dt_akses.id')
                    ->selectRaw('users.id,
                                 users.nama,
                                 users.hp,
                                 users.foto,
                                 users.id_akses,
                                 dt_akses.akses,
                                 users.propinsi_wilayah,
                                 users.kota_wilayah,
                                 users.kecamatan_wilayah,
                                 users.desa_wilayah,
                                 users.suara')
                    ->where('users.id_caleg',$request->idCaleg)
                    ->where('users.id_kord_prop',$request->idKordProp)
                    ->where('users.id_kord_kab',$request->idKordKab)
                    ->where('users.id_kord_kec',$request->userId)
                    ->orderby('users.nama')
                    ->get();
      }

      if($request->idAkses == 8){
        $data   = DB::table('users')
                    ->leftjoin('dt_akses','users.id_akses','=','dt_akses.id')
                    ->selectRaw('users.id,
                                 users.nama,
                                 users.hp,
                                 users.foto,
                                 users.id_akses,
                                 dt_akses.akses,
                                 users.propinsi_wilayah,
                                 users.kota_wilayah,
                                 users.kecamatan_wilayah,
                                 users.desa_wilayah,
                                 users.suara')
                    ->where('users.id_caleg',$request->idCaleg)
                    ->where('users.id_kord_prop',$request->idKordProp)
                    ->where('users.id_kord_kab',$request->idKordKab)
                    ->where('users.id_kord_kec',$request->idKordKec)
                    ->where('users.id_kord_kel',$request->userId)
                    ->orderby('users.nama')
                    ->get();
      }

      return response()->json($data);
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

    public function akses($id_akses) {
      $data   = DB::table('dt_akses')
                  ->selectRaw('akses')
                  ->where('id',$id_akses)
                  ->first();

      if($data){
        return $data->akses;
      } else {
        return NULL;
      }      
    }    
}
