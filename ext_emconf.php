<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Bootstrap Grid System',
    'description' => 'Bootstrap 5 grid system from the EXT:t3sbootstrap.',
    'category' => 'templates',
    'author' => 'Helmut Hackbarth',
    'author_email' => 'typo3@t3solution.de',
    'state' => 'stable',
    'version' => '5.0.0',
    'constraints' => [
        'depends' => [
            'typo3' => '14.3.0-14.9.99',
            'container' => '3.2.0-3.99.99'
        ],
        'conflicts' => [
            't3sbootstrap' => '*',
        ],
        'suggests' => [],
    ],
];
