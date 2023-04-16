<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use DB;
use File;
use Image;

class ResellerController extends Controller
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
                               users.propinsi,
                               users.kota')
                  ->where('users.id_akses',2)
                  ->get();

      return response()->json($data);
    }

    public function baru(request $request){
    }

    public function edit(request $request){
      $validator = Validator::make($request->all(), [
        'hp' => 'required|String|unique:users,hp,'.$request->id,
      ]);

      if ($validator->fails()) {
        return response()->json($validator->errors(), 422);
      }

      DB::table('users')
        ->where('id',$request->id)
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
          'id_akses' => 2, 
          'email' => $request->email, 
          'created' => $request->userId, 
          'updated' => $request->userId
        ]);

      $data   = DB::table('user')
                  ->where('id',$request->id)
                  ->first();

      $destinationPath = public_path('dokumen/pengguna/'.$data->uid);
      if (!File::exists($destinationPath)) {File::makeDirectory($destinationPath, 0777, true, true);} 

      if($request->foto){
        $this->validate($request, [
          'foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg,bmp'
        ]);

        $image = $request->file('foto');
        $input['imagename'] = time().rand().'.'.$image->getClientOriginalExtension();

        $img = Image::make($image->getRealPath());
        $img->resize(1300, 1300, function ($constraint) {
          $constraint->aspectRatio();
        })->save($destinationPath.'/'.$input['imagename']);

        DB::table('users')
          ->where('id',$data->id)
          ->update([
            'foto' => env('APP_URL').'/dokumen/pengguna/'.$data->uid.'/'.$input['imagename'],
          ]);
      }

      if($request->ktp){
        $this->validate($request, [
          'ktp' => 'required|image|mimes:jpeg,png,jpg,gif,svg,bmp'
        ]);

        $image = $request->file('ktp');
        $input['imagename'] = time().rand().'.'.$image->getClientOriginalExtension();

        $img = Image::make($image->getRealPath());
        $img->resize(1300, 1300, function ($constraint) {
          $constraint->aspectRatio();
        })->save($destinationPath.'/'.$input['imagename']);

        DB::table('users')
          ->where('id',$data->id)
          ->update([
            'ktp' => env('APP_URL').'/dokumen/pengguna/'.$data->uid.'/'.$input['imagename'],
          ]);
      }

      $data   = DB::table('user')
                  ->where('id',$request->id)
                  ->first();

      return response()->json($data);
    }

    public function hapus(request $request){
      $cek  = DB::table('users')->where('id',$request->id)->first();

      if($cek){
        DB::table('users')
          ->where('id',$request->id)
          ->update([
            'status' => 0,
            'updated' => $request->userId,
          ]);

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
                    ->where('id',$request->id)
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
