<?php

return [
    [
        'id' => 1000,
        'user_id' => 1,
        'created_at' => (new \DateTimeImmutable())->modify("-2 day")->format('Y-m-d H:i:s'),
        'title' => 'Too old note from user' . 1,
        'content' => 'Test Content 1000',
    ], [
        'id' => 1001,
        'user_id' => 1,
        'created_at' => $sameDate = (new \DateTimeImmutable())->format('Y-m-d H:i:s'),
        'title' => '1001 Note',
        'content' => 'Test Content 1001',
    ], [
        'id' => 1002,
        'user_id' => 1,
        'created_at' => $sameDate,
        'title' => '1002 Note',
        'content' => 'Test Content 1002',
    ], [
        'id' => 1003,
        'user_id' => 1,
        'created_at' => (new \DateTimeImmutable())->modify("+2 day")->format('Y-m-d H:i:s'),
        'title' => '1003 Note from future from user' . 1,
        'content' => 'Test Content 1003',
    ], [
        'id' => 1004,
        'user_id' => 2,
        'created_at' => (new \DateTimeImmutable())->modify("-2 day")->format('Y-m-d H:i:s'),
        'title' => 'Too old note from user' . 2,
        'content' => 'Test Content 1004',
    ], [
        'id' => 1005,
        'user_id' => 2,
        'created_at' => $sameDate = (new \DateTimeImmutable())->format('Y-m-d H:i:s'),
        'title' => '1005 Note',
        'content' => 'Test Content 1005',
    ], [
        'id' => 1006,
        'user_id' => 2,
        'created_at' => $sameDate,
        'title' => '1006 Note',
        'content' => 'Test Content 1006',
    ], [
        'id' => 1007,
        'user_id' => 2,
        'created_at' => (new \DateTimeImmutable())->modify("+2 day")->format('Y-m-d H:i:s'),
        'title' => '1007 Note from future from user' . 2,
        'content' => 'Test Content 1007',
    ],
];
