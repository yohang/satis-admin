<?php

return [
    'security.firewalls' => [
        'admin' => [
            'pattern'  => '^/',
            'http'     => true,
            'security' => !$this['debug'],
            'users'    => json_decode(file_get_contents($this['app.users_file']), true)
        ],
        'unsecured' => [
            'anonymous' => true
        ],
    ]
];
