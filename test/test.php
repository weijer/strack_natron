<?php
require './../vendor/autoload.php';

use Natron\TransCode;

$transCode = new TransCode();

$param = [
    'video' => [
        'node_name' => 'Video',
        'filename' => 'out_test',
        'read_path' => 'test.mov',
        'render_path' => 'out_test.mp4',
        'fps' => 24
    ],
    'thumbnail' => [
        'node_name' => 'Thumbnail',
        'filename' => 'out_test',
        'read_path' => 'test.mov',
        'render_path' => 'out_test.####.jpg'
    ]
];

$transCode->run($param);


