<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});


$factory->define(App\Moyu::class, function($faker){
  return [
    'user_id' => function(){
        return factory('App\User')->create()->id;
    },
    'channel_id' => function(){
        return factory('App\Channel')->create()->id;
    },
    'title' => $faker->sentence,
    'img' => '/site/default.png',
    'thumbnail' => '/site/thumbnail.png',
  ];
});

$factory->define(App\Channel::class, function($faker){
  $name = $faker->word;
  return [
    'name' => $name,
    'slug' => $name
  ];
});

$factory->define(App\Reply::class, function($faker){
  return [
    'user_id' => function(){
        return factory('App\User')->create()->id;
    },
    'moyu_id' => function(){
        return factory('App\Moyu')->create()->id;
    },
    'body' => $faker->paragraph,
  ];
});

$factory->define(App\Favorite::class, function($faker){
  return [
    'user_id'=> \App\User::all()->random()->id,
    'favorited_id' => \App\Reply::all()->random()->id,
    'favorited_type' => 'App\Reply',
  ];
});

$factory->define(Illuminate\Notifications\DatabaseNotification::class, function($faker){
  return [
    'id' => \Ramsey\Uuid\Uuid::uuid4()->toString(),
    'type' => 'App\Notifications\MoyuWasUpdated',
    'notifiable_id' => function(){
      return auth()->id() ?: factory('App\User')->create()->id;
    },
    'notifiable_type' => 'App\User',
    'data' => ['foo' => 'bar']
  ];
});
