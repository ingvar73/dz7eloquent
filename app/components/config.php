<?php
require __DIR__.'/../../vendor/autoload.php';
use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule;
$capsule->addConnection([
    'default' => 'mysql',
    'driver' => 'mysql',
    'host'     => '127.0.0.1',
    'database' => 'eloquent',
    'username' => 'root',
    'password' => '',
    'charset'  => 'utf8',
    'prefix'  => '',
]);

$capsule->setAsGlobal();
$capsule->bootEloquent();
class User extends Illuminate\Database\Eloquent\Model {}