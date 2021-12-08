<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function loginUserVip(Request $request){

        $data = $request->all();
        $validator = $this->validateData($data);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' =>$validator->errors()->toArray()
            ]);
        }

        $password = Hash::make($data['password']);

        $user = User::query()->where( 'email', $data['email'])->first();

        if(is_null($user)) {
            return response()->json([
                'success' => false,
                'message' => 'E-mail não encontrado.'
            ]);
        }

        if(!Hash::check($data['password'], $user->password)){
            return response()->json([
                'success' => false,
                'message' => 'Senha incorreta.'
            ]);
        }


        return response()->json([
            'success' => true,
            'user' => $user
        ]);

    }

    protected function validateData(array $data)
    {
        return Validator::make(
            $data,
            [
                'email' => [
                    'required'
                ],
                'password' => [
                    'required'
                ]
            ],
            [
                'email.required' => 'O campo email é obrigatório',
                'password.required' => 'O campo nome senha é obrigatório'
            ]
        );
    }
}
