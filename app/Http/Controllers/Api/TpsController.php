<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class TpsController extends Controller
{
    public function __construct(){
      $this->middleware(['keyverified','useractivated']);
    }

    public function index(request $request){
      if($request->idAkses == 4){
        if($request->userTingkat == 'NASIONAL'){
          $data   = DB::table('tps')
                      ->selectRaw('tps.id, 
                                   LPAD(tps.nomor,3,0) as nomor,
                                   tps.nama, 
                                   tps.alamat, 
                                   tps.dusun, 
                                   LPAD(tps.rt,3,0) as rt,
                                   LPAD(tps.rw,3,0) as rw,
                                   tps.no_prop, 
                                   tps.no_kab, 
                                   tps.no_kec, 
                                   tps.no_kel, 
                                   tps.propinsi, 
                                   tps.kota, 
                                   tps.kecamatan, 
                                   tps.desa')
                      ->orderby('tps.propinsi')
                      ->orderby('tps.kota')
                      ->orderby('tps.kecamatan')
                      ->orderby('tps.desa')
                      ->orderby('tps.nomor')
                      ->get();
        }

        if($request->userTingkat == 'PROPINSI'){
          $data   = DB::table('tps')
                      ->selectRaw('tps.id, 
                                   LPAD(tps.nomor,3,0) as nomor,
                                   tps.nama, 
                                   tps.alamat, 
                                   tps.dusun, 
                                   LPAD(tps.rt,3,0) as rt,
                                   LPAD(tps.rw,3,0) as rw,
                                   tps.no_prop, 
                                   tps.no_kab, 
                                   tps.no_kec, 
                                   tps.no_kel, 
                                   tps.propinsi, 
                                   tps.kota, 
                                   tps.kecamatan, 
                                   tps.desa')
                      ->where('tps.no_prop',$request->noPropWilayah)
                      ->orderby('tps.propinsi')
                      ->orderby('tps.kota')
                      ->orderby('tps.kecamatan')
                      ->orderby('tps.desa')
                      ->orderby('tps.nomor')
                      ->get();
        }

        if($request->userTingkat == 'KABUPATEN/KOTA'){
          $data   = DB::table('tps')
                      ->selectRaw('tps.id, 
                                   LPAD(tps.nomor,3,0) as nomor,
                                   tps.nama, 
                                   tps.alamat, 
                                   tps.dusun, 
                                   LPAD(tps.rt,3,0) as rt,
                                   LPAD(tps.rw,3,0) as rw,
                                   tps.no_prop, 
                                   tps.no_kab, 
                                   tps.no_kec, 
                                   tps.no_kel, 
                                   tps.propinsi, 
                                   tps.kota, 
                                   tps.kecamatan, 
                                   tps.desa')
                      ->where('tps.no_prop',$request->noPropWilayah)
                      ->where('tps.no_kab',$request->noKabWilayah)
                      ->orderby('tps.propinsi')
                      ->orderby('tps.kota')
                      ->orderby('tps.kecamatan')
                      ->orderby('tps.desa')
                      ->orderby('tps.nomor')
                      ->get();
        }
      }

      if($request->idAkses == 5){
        $data   = DB::table('tps')
                    ->selectRaw('tps.id, 
                                 LPAD(tps.nomor,3,0) as nomor,
                                 tps.nama, 
                                 tps.alamat, 
                                 tps.dusun, 
                                 LPAD(tps.rt,3,0) as rt,
                                 LPAD(tps.rw,3,0) as rw,
                                 tps.no_prop, 
                                 tps.no_kab, 
                                 tps.no_kec, 
                                 tps.no_kel, 
                                 tps.propinsi, 
                                 tps.kota, 
                                 tps.kecamatan, 
                                 tps.desa')
                    ->where('tps.no_prop',$request->noPropWilayah)
                    ->orderby('tps.propinsi')
                    ->orderby('tps.kota')
                    ->orderby('tps.kecamatan')
                    ->orderby('tps.desa')
                    ->orderby('tps.nomor')
                    ->get();
      }

      if($request->idAkses == 6){
        $data   = DB::table('tps')
                    ->selectRaw('tps.id, 
                                 LPAD(tps.nomor,3,0) as nomor,
                                 tps.nama, 
                                 tps.alamat, 
                                 tps.dusun, 
                                 LPAD(tps.rt,3,0) as rt,
                                 LPAD(tps.rw,3,0) as rw,
                                 tps.no_prop, 
                                 tps.no_kab, 
                                 tps.no_kec, 
                                 tps.no_kel, 
                                 tps.propinsi, 
                                 tps.kota, 
                                 tps.kecamatan, 
                                 tps.desa')
                    ->where('tps.no_prop',$request->noPropWilayah)
                    ->where('tps.no_kab',$request->noKabWilayah)
                    ->orderby('tps.kecamatan')
                    ->orderby('tps.desa')
                    ->orderby('tps.nomor')
                    ->get();
      }

      if($request->idAkses == 7){
        $data   = DB::table('tps')
                    ->selectRaw('tps.id, 
                                 LPAD(tps.nomor,3,0) as nomor,
                                 tps.nama, 
                                 tps.alamat, 
                                 tps.dusun, 
                                 LPAD(tps.rt,3,0) as rt,
                                 LPAD(tps.rw,3,0) as rw,
                                 tps.no_prop, 
                                 tps.no_kab, 
                                 tps.no_kec, 
                                 tps.no_kel, 
                                 tps.propinsi, 
                                 tps.kota, 
                                 tps.kecamatan, 
                                 tps.desa')
                    ->where('tps.no_prop',$request->noPropWilayah)
                    ->where('tps.no_kab',$request->noKabWilayah)
                    ->where('tps.no_kec',$request->noKecWilayah)          
                    ->orderby('tps.desa')
                    ->orderby('tps.nomor')
                    ->get();
      }

      if($request->idAkses == 8){
        $data   = DB::table('tps')
                    ->selectRaw('tps.id, 
                                 LPAD(tps.nomor,3,0) as nomor,
                                 tps.nama, 
                                 tps.alamat, 
                                 tps.dusun, 
                                 LPAD(tps.rt,3,0) as rt,
                                 LPAD(tps.rw,3,0) as rw,
                                 tps.no_prop, 
                                 tps.no_kab, 
                                 tps.no_kec, 
                                 tps.no_kel, 
                                 tps.propinsi, 
                                 tps.kota, 
                                 tps.kecamatan, 
                                 tps.desa')
                    ->where('tps.no_prop',$request->noPropWilayah)
                    ->where('tps.no_kab',$request->noKabWilayah)
                    ->where('tps.no_kec',$request->noKecWilayah)
                    ->where('tps.no_kel',$request->noKelWilayah)
                    ->orderby('tps.nomor')
                    ->get();
      }

      return response()->json($data);
    }

    public function detil(request $request){
      $data   = DB::table('tps')->where('id',$request->id)->first();

      if($data){
        return response()->json($data);
      } else {
        return response()->json([
          'status' => false,
          'message' => 'Data tidak ditemukan',
        ],401);
      }
    }

    public function baru(request $request){
      DB::table('tps')
        ->insert([
          'nomor' => $request->nomor, 
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
          'lat' => $request->lat, 
          'lng' => $request->lng, 
          'created' => $request->userId, 
          'updated' => $request->userId, 
        ]);

      return response()->json([
        'status' => true,
        'message' => 'Data berhasil ditambahkan',
      ],200);
    }

    public function edit(request $request){
      $cek  = DB::table('tps')->where('id',$request->id)->first();

      if($cek){
        DB::table('tps')
          ->where('id',$request->id)
          ->update([
            'nomor' => $request->nomor, 
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
            'lat' => $request->lat, 
            'lng' => $request->lng, 
            'updated' => $request->userId, 
          ]);

        return response()->json([
          'status' => true,
          'message' => 'Data berhasil disimpan',
        ],200);
      } else {
        return response()->json([
          'status' => false,
          'message' => 'Data tidak ditemukan',
        ],401);
      }
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
