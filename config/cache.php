<?php

return [
    'default' => 'array',

    'stores' => [
        'array' => [
            'driver' => 'array',
        ],
        'file' => [
            'driver' => 'file',
            'path'   => __DIR__ . '/../storage',
        ],
    ]
];
