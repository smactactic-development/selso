<?php

namespace Smactactic\Selso\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function edit()
    {
        $payload['sub'] = (int)Auth::id();
        $payload['client_id'] = (int)config('selso.client_id');
        $payload['exp'] = (int)now()->addMinutes(1)->timestamp;

        $secret = config('selso.client_secret') . config('selso.public_key');
        $code = JWT::encode($payload, $secret, 'HS256');

        $query = http_build_query(['code' => $code]);

        return redirect(config('selso.auth_server_url') . '/settings/profile/direct?' . $query);
    }
}
