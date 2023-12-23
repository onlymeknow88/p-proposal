<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\User;
use App\Models\RegSS;
use Illuminate\Support\Str;
use App\Exports\RegSSExport;
use Illuminate\Http\Request;
use GuzzleHttp\Client as Guzzle;
use App\Helpers\ResponseFormatter;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Models\Homepage\UserHomepage;

class AuthController extends Controller
{

    public function fetch(Request $request)
    {
        return ResponseFormatter::success($request->user(), 'Data profile user berhasil diambil');
    }

    public function login(Request $request)
    {
        try {
            // Validate request
            $request->validate([
                'email' => ['required'],
                'password' => ['required'],
            ]);

            // Find user by email
            $user = User::where('email', $request->email)->firstOrFail();
            if (!Hash::check($request->password, $user->password)) {
                throw new Exception('Invalid password');
            }

            // Generate token
            $tokenResult = $user->createToken('authToken')->accessToken;

            // Return response
            return ResponseFormatter::success([
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'user' => $user
            ], 'Login success');
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage());
        }
    }

    public function autoLogin(Request $request)
    {

        try {
            // Validate request
            $request->validate([
                'nik' => ['required'],
            ]);

            // Find user by email
            $user = User::where('nik', $request->nik)->firstOrFail();

            // Generate token
            $tokenResult = $user->createToken('authToken')->accessToken;

            // Return response
            return ResponseFormatter::success([
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'user' => $user
            ], 'Login success');
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage());
        }
    }

    public function logout(Request $request)
    {
        // Get token from request
        $token = $request->user()->token();

        // Revoke token
        $token->revoke();

        // Return response
        return ResponseFormatter::success([], 'Logout success');
    }


    public function redirect(Request $request)
    {
        $nik = $request->nik;
        $isLogin = $request->isLogin;

        $user_homepage = UserHomepage::where('nik',$nik)->first();

        if ($user_homepage) {
            $user = User::where('nik', $nik)->first();
            if (!$user) {
                $user = User::create([
                    'nik' => $user_homepage->nik,
                    'name' => $user_homepage->name,
                    'email' => $user_homepage->email,
                    'password' => Hash::make($user_homepage->nik),
                    'role_id' => $user_homepage->IsRoleGroupSso ,
                    'isLogin' => $user_homepage->IsLoginSSO,
                    'is_dept_head' => $user_homepage->IsDeptHead,
                    'is_div_head' => $user_homepage->IsDivHead,
                ]);
            }

            $request->session()->put('nik', $user->nik);
            $request->session()->put('isLogin', $user->isLogin);

            $request->session()->put('state', $state = Str::random(40));
            $request->session()->put(
                'code_verifier',
                $code_verifier = Str::random(128)
            );

            $codeChallenge = strtr(rtrim(
                base64_encode(hash('sha256', $code_verifier, true)),
                '='
            ), '+/', '-_');

            $query = http_build_query([
                'client_id' => '25',
                'redirect_uri' => 'http://localhost:3000/sso/callback',
                'response_type' => 'code',
                'scope' => '',
                'state' => $state,
                'code_challenge' => $codeChallenge,
                'code_challenge_method' => 'S256',
            ]);

            return redirect('http://homepage.test/oauth/authorize?' . $query);
        }
    }

    public function callback(Request $request)
    {

        // dd($request->all());
        $state = $request->session()->pull('state');

        $nik = $request->session()->pull('nik');
        $isLogin = $request->session()->pull('isLogin');

        $codeVerifier = $request->session()->pull('code_verifier');

        $data = $request->only(['redirect_uri', 'code']);
        $data['client_id'] = '25';
        $data['code_verifier'] = $codeVerifier;
        $data['grant_type'] = 'authorization_code';

        return view('sso.authorizing', [
            'data' => $data,
            'nik' => $nik,
            'isLogin' => $isLogin,
        ]);
    }

    public function cekUserHomepage(Request $request)
    {
        $userHP = UserHomepage::with('employee_homepage','sso_role')->where('nik',$request->input('nik'))->first();

        if ($userHP) {
            return ResponseFormatter::success($userHP, 'data found');
        }
    }
}
