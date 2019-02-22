<?php
return [
    'change_note' => [
        'type' => 2,
        'ruleName' => 'changeNote',
    ],
    'user' => [
        'type' => 1,
        'children' => [
            'change_note',
        ],
    ],
];
