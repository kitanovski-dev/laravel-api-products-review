<?php

namespace App\Http\Controllers\API;

use Lcobucci\JWT\Parser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\BaseController as BaseController;

class LogoutController extends BaseController
{
    public function logout(Request $request)
    {
        if(!$request->bearerToken()) {
            return "You are not loggedin.";
        }

        $id = App::make(Parser::class)->parse($request->bearerToken())->claims()->get('jti');

        $record = DB::table('oauth_access_tokens')->where('id', '=', $id);

        $record->update(['revoked' => true]);

        return $this->sendResponse('loged out', 'BYE, BYE.');
    }
}
