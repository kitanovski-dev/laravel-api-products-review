<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\BaseController;

class LoginController extends BaseController
{
    public function login(Request $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            if($user->email_verified_at) {
                $success['name']    = $user->name;
                $success['token']   = $user->createToken('MyApp')->accessToken;

                return $this->sendResponse(true, $success, 'User login successfully.');
            } else {
                return "Email not verified.";
            }
        }

        return $this->sendError('Unauthorised.', ['errror' => 'Unauthorised']);
    }
}
