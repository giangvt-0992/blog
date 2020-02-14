<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Role_Permission;
use Faker\Generator as Faker;

$factory->define(Role_Permission::class, function (Faker $faker) {
    // return [
    //     'role_id' => $faker->numberBetween(1,4),
    //     'permission_id' => $faker->numberBetween(1,8)
    // ];
});
