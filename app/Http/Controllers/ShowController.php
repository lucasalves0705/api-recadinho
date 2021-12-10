<?php

namespace App\Http\Controllers;

use App\Models\Show;
use App\Models\ShowSong;
use App\Models\User;
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

        $user = User::query()->where(['email' => $request->email, 'type_of_user_id' => 2])->first();

        if(is_null($user)){
            return response()->json([
                'success' => false,
                'message' => "Artista não encontrado"
            ]);
        }

        $show->user_id = $user->id;
        $show->bio = $request->bio;
        $show->save();

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
                'message' => 'Show não encontrado.'
            ]);
        }

        $songsShow = ShowSong::query()->where('show_id', $showId)->first();

        if (!is_null($songsShow)){
            return response([
                'success' => false,
                'message' => 'Ja existe musicas vinculadas ao show.'
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
                'email' => [
                    'required'
                ],
                'bio' => [
                    'required',
                    'max: 250'
                ]
            ],
            [
                'email.required' => 'O campo artista é obrigatório',
                'bio.required' => 'O campo descrição é obrigatório',
                'bio.max' => 'Tamanho da descrição é muito extenso'
            ]
        );
    }
}
