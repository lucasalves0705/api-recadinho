<?php

namespace App\Http\Controllers;

use App\Models\ShowSong;
use Illuminate\Http\Request;
use function PHPUnit\Framework\isEmpty;

class ShowSongController extends Controller
{
    public function index($showId)
    {
        $songs = ShowSong::query()->where('show_id', $showId)->get();

        if(is_null($songs)){
            return response()->json([
                'success' => false,
                'message' => 'Nenhum show foi encontrado'
            ]);
        }

        return response()->json([
            'success' => true,
            'songs' => $songs
        ]);
    }

    public function store(Request $request)
    {

    }
}
