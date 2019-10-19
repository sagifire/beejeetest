<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

$config = require_once dirname(__DIR__) . '/config/app.php';

(new \app\Application($config))->run();