<?php

if (!is_file($this['app.users_file'])) {
    file_put_contents($this['app.users_file'], json_encode([]));
}

return [
    'security.firewalls' => [
        'admin' => [
            'pattern'  => '^',
            'http'     => true,
            'security' => !$this['debug'],
            'users'    => json_decode(file_get_contents($this['app.users_file']), true)
        ],
        'unsecured' => [
            'anonymous' => true
        ],
    ]
];
