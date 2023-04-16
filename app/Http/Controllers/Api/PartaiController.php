<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use DB;
use File;
use Image;

class PartaiController extends Controller
{
    public function __construct(){
      $this->middleware(['keyverified','useractivated']);
    }

    public function index(request $request){
      $data   = DB::table('partai')
                  ->orderby('urut')
                  ->get();

      return response()->json([
        'data' => $data,
        'akses' => $request->idAkses,
      ]);
    }

    public function baru(request $request){
      DB::table('partai')
        ->insert([
          'partai' => $request->partai,
          'kode' => $request->kode,
          'urut' => $request->urut,
          'logo' => $request->logo,
          'created' => $request->userId,
          'updated' => $request->userId,
        ]);

      return response()->json([
        'status' => true,
        'message' => 'Data berhasil ditambahkan',
      ],200);
    }

    public function edit(request $request){
      $cek  = DB::table('partai')->where('id',$request->id)->first();

      if($cek){
        DB::table('partai')
          ->where('id',$request->id)
          ->update([
            'partai' => $request->partai,
            'kode' => $request->kode,
            'urut' => $request->urut,
            'logo' => $request->logo,
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

    public function hapus(request $request){
      $cek  = DB::table('partai')->where('id',$request->id)->first();

      if($cek){
        DB::table('partai')
          ->where('id',$cek->id)
          ->delete();

        return response()->json([
          'status' => true,
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
      $cek  = DB::table('partai')->where('id',$request->id)->first();

      if($cek){
        $data   = DB::table('partai')->where('id',$cek->id)->first();

        return response()->json($data);
      } else {
        return response()->json([
          'status' => false,
          'message' => 'Data tidak ditemukan',
        ],401);
      }
    }
}
