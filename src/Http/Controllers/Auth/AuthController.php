<?php

namespace Smactactic\Selso\Http\Controllers\Auth;

use Smactactic\Selso\Guards\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    protected $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('selso.auth_server_url');
    }

    public function login(Request $request)
    {
        $request->session()->put('state', $state = Str::random(40));

        $query = http_build_query([
            'client_id' => config('selso.client_id'),
            'redirect_uri' => config('selso.redirect_uri'),
            'response_type' => 'code',
            'scope' => '',
            'state' => $state,
        ]);

        return redirect($this->baseUrl . '/oauth/authorize?' . $query);
    }

    public function callback(Request $request)
    {
        $response = Http::asForm()->post($this->baseUrl . '/oauth/token', [
            'grant_type' => 'authorization_code',
            'client_id' => config('selso.client_id'),
            'client_secret' => config('selso.client_secret'),
            'redirect_uri' => config('selso.redirect_uri'),
            'code' => $request->get('code'),
        ]);

        if ($response->failed()) {
            return abort(401);
        }

        $data = $response->json();
        $userInfo = Http::withToken($data['access_token'])->get($this->baseUrl . '/api/user')->json();
        $userInfo['access_token'] = $data['access_token'];
        $userInfo['refresh_token'] = $data['refresh_token'];

        Auth::login(new User($userInfo));
        session(['selso' => $userInfo]);

        // return redirect()->intended(route(config('selso.redirect_after_login'), absolute: false));
        return redirect()->intended(config('selso.redirect_after_login'));
    }

    public function destroy()
    {
        $response = Http::withToken(Auth::user()->access_token)
            ->acceptJson()->post($this->baseUrl . '/api/logout');

        if ($response->failed()) {
            return abort(401);
        }

        $data = $response->json();

        if (isset($data['revoked']) && $data['revoked']) {
            Auth::logout();
            session()->flush();
        }

        return redirect()->to('/');
    }
}
