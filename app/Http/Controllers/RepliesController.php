<?php

namespace App\Http\Controllers;

use App\Inspections\Spam;
use App\Moyu;
use App\Reply;
use Illuminate\Http\Request;

class RepliesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => 'index']);
    }

    public function index($channelId, Moyu $moyu)
    {
        return $moyu->replies()->paginate(3);
    }

    public function store($channelId, Moyu $moyu, Spam $spam)
    {
        $this->validate(request(),['body' => 'required']);
        $spam->detect(request('body'));

        $reply = $moyu->addReply([
            'body' => request('body'),
            'user_id' => auth()->id(),
        ]);

        if(request()->expectsJson()) {
          return $reply->load('owner');
        }

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
