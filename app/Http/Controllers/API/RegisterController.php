<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use Illuminate\Auth\Events\Validated;
use Validator;

class RegisterController extends BaseController
{
    protected $request;

    public function register(Request $request)
    {
        $data = [
            'name'          =>  $request->name,
            'email'         =>  $request->email,
            'password'      =>  $request->password,
            'c_password'    =>  $request->c_password
        ];

        if($validator = $this->validateRequest($data)->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $data['password'] = bcrypt($data['password']);
        $user = User::create($data);

        $success = [
            'name'          =>  $user->name,
            'token'         =>  $user->createToken('MyApi')->accessToken
        ];

        return $this->sendResponse(true, $success, 'User Registered Successfully.');
    }

    protected function validateRequest($data)
    {
        return validator($data, [
            'name'          =>  'required',
            'email'         =>  'required|email',
            'password'      =>  'required',
            'c_password'    =>  'required|same:password'
        ]);
    }
}
