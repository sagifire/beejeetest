<?php

namespace app\services;

use Illuminate\Database\Capsule\Manager as Capsule;
use app\contracts\InitiableService;

class Database implements InitiableService
{
    public $driver = 'mysql';
    public $host = 'localhost';
    public $charset = 'utf8';
    public $collation = 'utf8_unicode_ci';
    public $prefix = '';
    public $database;
    public $password;
    public $username;

    function init() {
        $capsule = new Capsule();
        $capsule->addConnection([
            'driver'    => $this->driver,
            'host'      => $this->host,
            'database'  => $this->database,
            'username'  => $this->username,
            'password'  => $this->password,
            'charset'   => $this->charset,
            'collation' => $this->collation,
            'prefix'    => $this->prefix,
        ]);

        $capsule->setAsGlobal();

        // Setup the Eloquent ORM…
        $capsule->bootEloquent();
    }
}