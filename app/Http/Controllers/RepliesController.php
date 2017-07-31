<?php

namespace App\Http\Controllers;

use App\Moyu;
use Illuminate\Http\Request;

class RepliesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Moyu $moyu)
    {
        $moyu->addReply([
            'body' => request('body'),
            'user_id' => auth()->id(),
        ]);

        return back();
    }
}
