<?php
require "init.php";

for ($i = 0; $i < 30; $i++){
    $faker = Faker\Factory::create();
    $user = new User();
    $user->username = $faker->name;

}
