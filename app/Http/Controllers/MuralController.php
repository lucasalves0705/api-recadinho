<?php

namespace App\Http\Controllers;

use App\Models\Mural;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MuralController extends Controller
{
    public function index()
    {
        $murals = Mural::all();

        return response()->json([
            'success' => true,
            'mural' => $murals
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->all();

        $validator = $this->validateData($data);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' =>$validator->errors()->toArray()
            ]);
        }

        $mural = new Mural();

        $mural->fill($data)->save();

        return response()->json([
            'success' => true,
            'mural' => $mural
        ]);
    }

    protected function validateData(array $data){
        return Validator::make(
            $data,
            [
                'user_id' => [
                    'required',
                    'numeric'
                ],
                'message' => [
                    'required',
                    'max:300'
                ]
            ],
            [
                'user_id.required' => 'O usuário precisa estar logado',
                'user_id.numeric' => 'O campo usuário deve ser numerico',
                'message.required' => 'O campo mensagem é obrigatório',
                'mural_id.max' => 'Tamanho da mensagem é muito extenso'
            ]
        );
    }
}
