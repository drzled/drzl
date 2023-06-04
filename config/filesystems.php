<?php

return [
    'default' => 'local',

    'disks' => [
        'local' => [
            'driver' => 'local',
            'root' => getcwd().'/.'.strtolower(config('app.name')),
        ],
    ],
];