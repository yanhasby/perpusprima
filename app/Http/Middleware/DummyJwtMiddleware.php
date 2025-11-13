<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
class DummyJwtMiddleware
{
    /**
    * Handle an incoming request.
    *
    * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
    */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            // Ambil payload dari token tanpa cari user di database
            $payload = JWTAuth::parseToken()->getPayload();
            // Simpan ke request agar bisa diakses di controller
            $request->merge(['jwt_payload' => $payload]);
        } catch (JWTException $e) {
            return response()->json([
                'message' => 'Token invalid or expired',
                'error' => $e->getMessage()
            ], 401);
        }
        return $next($request);
    }
}
