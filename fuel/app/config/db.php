<?php

return array(
    'default' => array(
        'type' => 'pdo',
        'connection' => array(
            'dsn' => 'sqlite:' . APPPATH . 'tmp/app.sqlite',
            'username' => null,
            'password' => null,
            'persistent' => false,
        ),
        'profiling' => true,
    ),
);