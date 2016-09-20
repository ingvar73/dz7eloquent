<?php
require "app/components/config.php";
use Illuminate\Database\Capsule\Manager as Capsule;

Capsule::schema()->create('users', function ($table) {
    $table->increments('id');
    $table->string('login');
    $table->string('name');
    $table->string('email')->unique();
    $table->integer('age');
    $table->longtext('about');
    $table->string('password');
    $table->string('hash');
    $table->string('avatar');
    $table->boolean('activate')->default(false);
    $table->string('url');
    $table->timestamp('date');
    $table->timestamps();
});