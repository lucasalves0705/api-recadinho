<?php

namespace App\Http\Controllers;

use App\Models\LikeOfMural;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use function PHPUnit\Framework\isEmpty;

class LikeOfMuralController extends Controller
{
    public function showByPostMural($muralId)
    {
        if(!is_null($muralId)){
            $likes = LikeOfMural::query()->where('mural_id', $muralId)->count();
        }

        return response()->json([
            'success' => true,
            'likes' => $likes
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

        $like = LikeOfMural::query()
            ->where('user_id', $data['user_id'])
            ->where('mural_id', $data['mural_id'])
            ->first();

        if(is_null($like)){
            $like = new LikeOfMural();
            $like->fill($data)->save();

            return response()->json([
                'success' => true,
                'message' => 'Inserido like'
            ]);
        }

        $like->delete();

        return response()->json([
            'success' => true,
            'message' => 'Removido like'
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
                'mural_id' => [
                    'required',
                    'numeric'
                ]
            ],
            [
                'user_id.required' => 'O usuário precisa estar logado',
                'user_id.numeric' => 'O campo usuário deve ser numerico',
                'mural_id.required' => 'É necessario ter um post válido',
                'mural_id.numeric' => 'O campo usuário deve ser numerico'
            ]
        );
    }
}
