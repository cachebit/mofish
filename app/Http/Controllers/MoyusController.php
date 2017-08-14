<?php

namespace App\Http\Controllers;

use App\Filter\MoyuFilters;
use App\Channel;
use App\Moyu;
use Illuminate\Http\Request;

class MoyusController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('index', 'show');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Channel $channel, MoyuFilters $filters)
    {
        $moyus = $this->getMoyus($channel, $filters);

        if(request()->wantsJson()){
          return $moyus;
        }

        return view('moyus.index',compact('moyus'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('moyus.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(request(), [
          'title' => 'required',
          'img' => 'required',
          'thumbnail' => 'required',
          'channel_id' => 'required|exists:channels,id'
        ]);

        $moyu = Moyu::create([
          'user_id' => auth()->id(),
          'channel_id' => request('channel_id'),
          'title' => request('title'),
          'img' => '/site/default.png',
          'thumbnail' => '/site/thumbnail.png',
        ]);

        return redirect($moyu->path())
                ->with('flash', 'Your moyu has been published!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Moyu  $moyu
     * @return \Illuminate\Http\Response
     */
    public function show($channel, Moyu $moyu)
    {
        return view('moyus.show', [
          'moyu' => $moyu,
          'replies' => $moyu->replies()->latest()->paginate(10),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Moyu  $moyu
     * @return \Illuminate\Http\Response
     */
    public function edit(Moyu $moyu)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Moyu  $moyu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Moyu $moyu)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Moyu  $moyu
     * @return \Illuminate\Http\Response
     */
    public function destroy($channel, Moyu $moyu)
    {
        $this->authorize('update', $moyu);

        $moyu->delete();

        if(request()->wantsJson()){
          return response([], 204);
        }

        return redirect('/moyus');
    }

    public function getMoyus(Channel $channel, MoyuFilters $filters)
    {
        $moyus = Moyu::latest()->filter($filters);

        if($channel->exists){
           $moyus->where('channel_id', $channel->id);
        }

        return $moyus->get();
    }
}
