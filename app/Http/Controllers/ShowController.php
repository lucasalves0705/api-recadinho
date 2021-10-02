<?php

namespace App\Http\Controllers;

use App\Models\Show;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ShowController extends Controller
{
    public function index(){
        $show = Show::all()->sortBy('name');
        return response()->json([
            'success' => true,
            'show' => $show
        ]);
    }

    public function show($showId){
        $show = Show::query()->find($showId);

        if (is_null($show)){
            return response([
                'success' => false,
                'message' => 'Show não encontrado'
            ]);
        }

        return response([
            'success' => true,
            'show' => $show
        ]);
    }

    public function store(Request $request, int $showId = null){

        $data = $request->all();
        $validator = $this->validateData($data);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' =>$validator->errors()->toArray()
            ]);
        }

        if(is_null($showId)) {
            $show = new Show();
        } else {
            $show = Show::query()->find($showId);

            if (is_null($show)) {
                return [
                    'success' => false,
                    'message' => 'Show não encontrado'
                ];
            }
        }

        $show->fill($data)->save();

        return response()->json([
            'success' => true,
            'show' => $show
        ]);
    }

    public function destroy($showId){

        $show = Show::query()->find($showId);

        if (is_null($show)){
            return response([
                'success' => false,
                'message' => 'Show não encontrado'
            ]);
        }

        $show->delete();

        return response([
            'success' => true,
            'message' => 'Show removido com sucesso'
        ]);
    }

    protected function validateData(array $data){
        return Validator::make(
            $data,
            [
                'user_id' => [
                    'required'
                ],
                'bio' => [
                    'required',
                    'max: 250'
                ]
            ],
            [
                'user_id.required' => 'O campo artista é obrigatório',
                'bio.required' => 'O campo descrição é obrigatório'
            ]
        );
    }
}
