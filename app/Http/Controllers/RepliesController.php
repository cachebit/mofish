<?php

namespace App\Http\Controllers;

use App\Moyu;
use App\Reply;
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

    public function update(Reply $reply)
    {
        $this->authorize('update', $reply);

        $reply->update(request(['body'])) ;
    }

    public function destroy(Reply $reply)
    {
        $this->authorize('update', $reply);

        $reply->delete();

        if(request()->expectsJson()){
          return response(['status' => "Reply deleted"]);
        }

        return back();
    }
}
