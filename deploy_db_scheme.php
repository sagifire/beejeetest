<?php
require_once __DIR__ . '/vendor/autoload.php';

$config = require_once __DIR__ . '/config/app.php';

$app = new \app\Application($config);

use Illuminate\Database\Capsule\Manager as Capsule;

Capsule::schema()->create('task', function ($table) {
    /** @var \Illuminate\Database\Schema\Blueprint $table */
    $table->increments('id');
    $table->string('username');
    $table->string('email');
    $table->text('description');
    $table->integer('status');
});

echo "The DB Schema deploying finished!\n";