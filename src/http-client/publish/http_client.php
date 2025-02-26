<?php

return [
    'connection' => [
        'pool' => [
            'min_objects' => 1,
            'max_objects' => 10,
            'wait_timeout' => 3.0,
            'max_lifetime' => 60.0,
        ],
    ],
];
