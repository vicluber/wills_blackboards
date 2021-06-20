<?php
return [
    'ctrl' => [
        'title' => 'LLL:EXT:wills_blackboards/Resources/Private/Language/locallang_db.xlf:hk_blackboards_comment',
        'label' => 'text',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'iconfile' => 'EXT:wills_blackboards/Resources/Public/Icons/Extension.svg',
    ],
    'columns' => [
        'crdate' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        'text' => [
            'label' => 'LLL:EXT:wills_blackboards/Resources/Private/Language/locallang_db.xlf:hk_blackboards_comment.text',
            'config' => [
                'type' => 'text',
                'eval' => 'trim',
                "max" => "500"
            ],
        ],
        'user' => [
            'label' => 'LLL:EXT:wills_blackboards/Resources/Private/Language/locallang_db.xlf:hk_blackboards_comment.user',
            'config' => [
                'type' => 'select',
                'foreign_table' => 'fe_users',
                'renderType' => 'selectSingle',
                'minitems' => 0,
                'maxitems' => 1,
            ],
        ],
        'blackboard' => [
            'label' => 'LLL:EXT:wills_blackboards/Resources/Private/Language/locallang_db.xlf:hk_blackboards_comment.blackboard',
            'config' => [
                'type' => 'select',
                'foreign_table' => 'tx_willsblackboards_domain_model_blackboard',
                'renderType' => 'selectSingle',
                'minitems' => 0,
                'maxitems' => 1,
            ],
        ],
    ],
    'types' => [
        '0' => ['showitem' => 'tstamp, crdate, text, user, blackboard'],
    ],
];
