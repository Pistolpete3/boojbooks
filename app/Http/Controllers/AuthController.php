<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $client = new Client();

        try {
            return $client->post(config('auth.passport.token_uri'), [
                'form_params' => [
                    'grant_type' => 'password',
                    'client_id' => config('auth.passport.client_id'),
                    'client_secret' => config('auth.passport.client_secret'),
                    'username' => $request->get('username'),
                    'password' => $request->get('password'),
                ]
            ]);
        } catch (\Exception $exception) {
            return $exception;
        }
    }

    public function logout()
    {
        Auth::guard('api')->user()->tokens->each(function ($token) {
           $token->delete();
        });

        return response()->json('Logged out successfully', 200);
    }
}
