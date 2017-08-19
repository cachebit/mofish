<?php

namespace App\Http\Controllers;

use App\Moyu;

class MoyuSubscriptionsController extends Controller
{
    public function store($channelId, Moyu $moyu)
    {
      $moyu->subscribe();
    }

    public function destroy($channelId, Moyu $moyu)
    {
      $moyu->unsubscribe();
    }
}
