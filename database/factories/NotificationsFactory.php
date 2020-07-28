<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */


use App\Notifications\ThreadWasUpdated;
use App\User;
use \Illuminate\Notifications\DatabaseNotification;
use Faker\Generator as Faker;
use Ramsey\Uuid\Uuid;


$factory->define(DatabaseNotification::class, function (Faker $faker) {

    return [
        'id' => Uuid::uuid4()->toString(),
        'type'=> ThreadWasUpdated::class,
        'data' => ['foo'=>'bar'],
        'notifiable_id' => function(){
            return  auth()->id() ?: factory(User::class)->create()->id;
        },
        'notifiable_type' => User::class,
    ];
});
