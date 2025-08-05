<?php

namespace Smactactic\Selso\Http\Middleware;

use Closure;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Smactactic\Selso\Guards\User;
use Symfony\Component\HttpFoundation\Response;

class SelsoAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = Auth::user()?->access_token;

        // if (!$token) return abort(401);
        if (!$token) return redirect()->route('selso.login');

        try {
            JWT::decode($token, new Key(config('selso.public_key'), 'RS256'));
            return $next($request);
        } catch (ExpiredException $e) {
            $baseUrl = config('selso.auth_server_url');

            $response = Http::asForm()->post($baseUrl . '/oauth/token', [
                'grant_type' => 'refresh_token',
                'refresh_token' => Auth::user()?->refresh_token,
                'client_id' => config('selso.client_id'),
                'client_secret' => config('selso.client_secret'),
                'scope' => '',
            ]);

            Auth::logout();
            session()->flush();

            // if ($response->failed()) return abort(401);
            if ($response->failed()) return redirect()->route('selso.login');

            $data = $response->json();
            $userInfo = Http::withToken($data['access_token'])->get($baseUrl . '/api/user')->json();
            $userInfo['access_token'] = $data['access_token'];
            $userInfo['refresh_token'] = $data['refresh_token'];

            Auth::login(new User($userInfo));
            session(['selso' => $userInfo]);

            return $next($request);
        } catch (\Exception $e) {
            Auth::logout();
            session()->flush();
            return response()->json([
                'status' => 'invalid',
                'message' => $e->getMessage(),
            ], 400);
        }
    }
}
