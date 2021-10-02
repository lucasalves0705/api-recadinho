<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use function PHPUnit\Framework\isNull;

class UserController
{
    public function index(){
        $users = User::all()->sortBy('name');
        return response()->json([
            'success' => true,
            'user' => $users
        ]);
    }

    public function show($userId){
        $user = User::query()->find($userId);

        if (is_null($user)){
            return response([
                'success' => false,
                'message' => 'Usuário não encontrado'
            ]);
        }

        return response([
            'success' => true,
            'user' => $user
        ]);
    }

    public function store(Request $request, int $userId = null){

        $data = $request->all();
        $validator = $this->validate($data, $userId);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' =>$validator->errors()->toArray()
            ]);
        }

        if(is_null($userId)) {
            $user = new User();
            $user->password = Hash::make($data['password']);
        } else {
            $user = User::query()->find($userId);

            if (is_null($user)) {
                return [
                    'success' => false,
                    'message' => 'Usuário não encontrado'
                ];
            }
        }

        $user->fill($data)->save();

        return response()->json([
            'success' => true,
            'message' => $user
        ]);
    }

    public function destroy($userId){

        $user = User::query()->find($userId);

        if (is_null($user)){
            return response([
                'success' => false,
                'message' => 'Usuário não encontrado'
            ]);
        }

        $user->delete();

        return response([
            'success' => true,
            'message' => 'Usuário removido com sucesso'
        ]);
    }

    protected function validate(array $data, int $userId = null){

        $nameUnique = Rule::unique('users', 'name');
        if (!is_null($userId)) {
            $nameUnique->ignore($userId);
        }

        $requiredIf = Rule::requiredIf( function () use ($data) {
            return $data['type_of_user_id'] == 1 || $data['type_of_user_id'] == 2;
        });

        return Validator::make(
            $data,
            [
                'name' => [
                    'required',
                    $nameUnique,
                    'max:30'
                ],
                'email' => [
                    Rule::unique('users', 'email'),
                    $requiredIf
                ],
                'password' => [
                    'min:8',
                    'max:16',
                    $requiredIf
                ]
            ],
            [
                'name.required' => 'O campo nome é obrigatório',
                'name.unique'   => 'Já existe um usuário com este username',
                'name.max' => 'O limite máximo é de 30 caracteres',
                'email.required' => 'O campo email é obrigatório',
                'email.unique'   => 'Já existe um usuário cadastrado com esse email',
                'password.required' => 'O campo nome senha é obrigatório',
                'password.min' => 'A senha é muito curta',
                'password.max' => 'Asenha é muito extensa'
            ]
        );
    }
}
