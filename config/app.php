<?php

return [
    'name' => 'BeeJeeTest',
    'language' => 'ru',
    'services' => [
        'router' => [
            'rules' => [
                ['GET', '/', 'Task/index'],
                ['GET', '/task/create', 'Task/create'],
                ['POST', '/task/create', 'Task/create'],
                ['GET', '/task/edit/{id:\d+}', 'Task/edit'],
                ['POST', '/task/edit/{id:\d+}', 'Task/edit'],
                ['GET', '/login', 'Site/login'],
                ['POST', '/login', 'Site/login'],
                ['GET', '/logout', 'Site/logout'],
            ]
        ],
        'db' => [
            'database' => 'beejeetest',
            'username' => 'root',
            'password' => 'xxx',
        ],
        'user' => [
            'username' => 'admin',
            'password' => '123',
        ]
    ]
];