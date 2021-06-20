<?php
return [
    'ctrl' => [
        'title' => 'LLL:EXT:wills_blackboards/Resources/Private/Language/locallang_db.xlf:hk_blackboards_blackboard',
        'label' => 'title',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'iconfile' => 'EXT:wills_blackboards/Resources/Public/Icons/Extension.svg',
        'enablecolumns' => [ 
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
    ],
    'columns' => [
        'crdate' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        'title' => [
            'label' => 'LLL:EXT:wills_blackboards/Resources/Private/Language/locallang_db.xlf:hk_blackboards_blackboard.title',
            'config' => [
                'type' => 'input',
                'size' => '20',
                'eval' => 'trim',
            ],
        ],
        'description' => [
            'label' => 'LLL:EXT:wills_blackboards/Resources/Private/Language/locallang_db.xlf:hk_blackboards_blackboard.description',
            'config' => [
                'type' => 'text',
                'eval' => 'trim',
            ],
        ],
        'category' => [
            'label' => 'LLL:EXT:wills_blackboards/Resources/Private/Language/locallang_db.xlf:hk_blackboards_blackboard.category',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectTree',
                'treeConfig' => [
                    'parentField' => 'parent',
                    'rootUid' => $GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS']['wills_blackboards']['BlackboardsParentCategory'],
                    'appearance' => [
                        'showHeader' => false,
                        'expandAll' => true,
                    ],
                ],
                'foreign_table' => 'sys_category',
                'foreign_table_where' => ' AND (sys_category.sys_language_uid = 0 OR sys_category.l10n_parent = 0) ORDER BY sys_category.sorting',
                'size' => 10,
                'minitems' => 0,
                'maxitems' => 1,
            ]
        ],
        'user' => [
            'label' => 'LLL:EXT:wills_blackboards/Resources/Private/Language/locallang_db.xlf:hk_blackboards_blackboard.user',
            'config' => [
                'type' => 'select',
                'foreign_table' => 'fe_users',
                'renderType' => 'selectSingle',
                'minitems' => 0,
                'maxitems' => 1,
            ],
        ],
        'phone_number' => [
            'label' => 'LLL:EXT:wills_blackboards/Resources/Private/Language/locallang_db.xlf:hk_blackboards_blackboard.phone_number',
            'config' => [
                'type' => 'input',
                'size' => '20',
                'eval' => 'trim',
            ],
        ],
        'image' => [
            'label' => 'image',
            'config' =>
                \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
                    'image',
                    [
                        'appearance' => [
                            'createNewRelationLinkTitle' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:images.addFileReference'
                        ],
                        'foreign_types' => [
                            '0' => [
                                'showitem' => '
                            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                            --palette--;;filePalette'
                            ],
                            \TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => [
                                'showitem' => '
                            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                            --palette--;;filePalette'
                            ]
                        ],
                        'maxitems' => 1
                    ],
                    $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']
                ),
    
        ],
        'hidden' => [
            'exclude' => true,
            'label' => 'LLL:EXT:wills_blackboards/Resources/Private/Language/locallang_db.xlf:hk_blackboards_blackboard.visible',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'items' => [
                    [
                        0 => '',
                        1 => '',
                        'invertStateDisplay' => true
                    ]
                ],
            ],
        ],
    ],
    'types' => [
        '0' => ['showitem' => 'tstamp, crdate, title, description, category, user, phone_number, image, hidden'],
    ],
];
