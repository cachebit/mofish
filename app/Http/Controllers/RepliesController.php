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

    public function store($channelId, Moyu $moyu)
    {
        $this->validate(request(),['body' => 'required']);

        $moyu->addReply([
            'body' => request('body'),
            'user_id' => auth()->id(),
        ]);

        return back()->with('flash', 'Replied!');
    }
}
