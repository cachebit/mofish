<?php

namespace App\Http\Controllers;

use App\Moyu;
use Illuminate\Http\Request;

class MoyusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $moyus = Moyu::all();

        return view('moyus.index',compact('moyus'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Moyu  $moyu
     * @return \Illuminate\Http\Response
     */
    public function show(Moyu $moyu)
    {
        return view('moyus.show', compact('moyu'));
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
    public function destroy(Moyu $moyu)
    {
        //
    }
}
