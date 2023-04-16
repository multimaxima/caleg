<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use DB;

class UserVerification
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user   = DB::table('users')
                    ->where('uid',$request->input('uidKey'))
                    ->where('hp',$request->input('hpKey'))
                    ->where('status',1)
                    ->first();

        if (!$user){
            return response()->json([
            'status' => false,
            'message' => 'Akun Anda belum di aktifasi',
          ], 401);
        }

        if ($user && !$user->id_akses){
            return response()->json([
            'status' => false,
            'message' => 'Akun Anda belum memiliki hak akses',
          ], 401);
        }

        return $next($request);
    }
}
