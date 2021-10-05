<?php

namespace App\Http\Controllers;

use App\Models\Message;

class MessageController extends Controller
{
    public function index($senderUser){
        $messages = Message::query()->where('sender_user', $senderUser);

        return response()->json([
            'success' => true,
            'show' => $messages
        ]);
    }

    public function showByUser($showId){
        $messages = Message::query()->find($showId);

        if (is_null($messages)){
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
}
