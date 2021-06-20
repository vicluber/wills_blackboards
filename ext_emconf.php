<?php

/**
 * Extension Manager/Repository config file for ext "Wills_blackboards".
 */
$EM_CONF[$_EXTKEY] = [
    'title' => 'Wills Blackboards',
    'description' => 'Adding data records for the blackboards platform',
    'category' => 'templates',
    'constraints' => [
        'depends' => [
            'typo3' => '10.2.0-10.4.99',
        ],
        'conflicts' => [
        ],
    ],
    'autoload' => [
        'psr-4' => [
            'Wills\\WillsBlackboards\\' => 'Classes',
        ],
    ],
    'state' => 'stable',
    'uploadfolder' => 0,
    'createDirs' => '',
    'clearCacheOnLoad' => 1,
    'author' => 'Victor Willhuber',
    'author_email' => 'victorwillhuber@gmail.com',
    'author_company' => 'Wills',
    'version' => '1.0.0',
];
