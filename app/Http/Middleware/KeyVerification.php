<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use DB;

class KeyVerification
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $cek    = DB::table('users')
                    ->where('uid',$request->input('uidKey'))
                    ->orwhere('hp',$request->input('hpKey'))
                    ->first();

        if($cek){
          if(!$cek->uid){
            DB::table('users')
              ->where('id',$cek->id)
              ->update([
                'users.uid' => $request->input('uidKey'),
              ]);
          }

          if(!$cek->hp){
            DB::table('users')
              ->where('id',$cek->id)
              ->update([
                'users.hp' => $request->input('hpKey'),
              ]);
          }
        } else {
          DB::table('users')
            ->insert([
              'uid' => $request->input('uidKey'),
              'hp' => $request->input('hpKey'),
              'id_akses' => 4,
              'status' => 1,
            ]);

          $baru   = DB::table('users')
                      ->orderby('id','desc')
                      ->first();

          DB::table('users')
            ->where('id',$baru->id)
            ->update([
              'id_caleg' => $baru->id,
            ]);
        }
        
        $user   = DB::table('users')
                    ->where('uid',$request->input('uidKey'))
                    ->orwhere('hp',$request->input('hpKey'))
                    ->first();

        if ($request->input('key') !== env('API_KEY') || !$user) {
            return response()->json([
            'status' => false,
            'message' => 'Unauthorized',
          ], 404);
        }

        $request->merge([
          'userId' => $user->id ?? null,
          'userUid' => $user->uid ?? null,
          'idAkses' => $user->id_akses ?? null,
          'userHp' => $user->hp ?? null,
          'idPartai' => $user->id_partai ?? null,
          'idCaleg' => $user->id_caleg ?? null,
          'idDistributor' => $user->id_distributor ?? null,
          'userTingkat' => $user->tingkat ?? null,
          'noPropWilayah' => $user->no_prop_wilayah ?? null,
          'noKabWilayah' => $user->no_kab_wilayah ?? null,
          'noKecWilayah' => $user->no_kec_wilayah ?? null,
          'noKelWilayah' => $user->no_kel_wilayah ?? null,
          'idKordProp' => $user->id_kord_prop ?? null,
          'idKordKab' => $user->id_kord_kab ?? null,
          'idKordKec' => $user->id_kord_kec ?? null,
          'idKordKel' => $user->id_kord_kel ?? null,
        ]);

        return $next($request);
    }
}
