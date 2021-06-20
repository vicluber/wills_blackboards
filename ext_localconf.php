<?php
defined('TYPO3_MODE') || die('Access denied.');

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Wills.WillsBlackboards',
    'BlackboardsList',
    [   
        \Wills\WillsBlackboards\Controller\BlackboardsController::class => 'list, new, create, show, edit, update, delete, imageEdit',
        \Wills\WillsBlackboards\Controller\CommentsController::class => 'delete, createComment',
    ],
    [
        \Wills\WillsBlackboards\Controller\BlackboardsController::class => 'list, new, create, show, edit, update, delete, imageEdit',
        \Wills\WillsBlackboards\Controller\CommentsController::class => 'delete, createComment',
    ]
);
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Wills.WillsBlackboards',
    'BlackboardsNew',
    [
        \Wills\WillsBlackboards\Controller\BlackboardsController::class => 'new, create',
    ],
    [
        \Wills\WillsBlackboards\Controller\BlackboardsController::class => 'new, create',
    ]
 );
 \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Wills.WillsBlackboards',
    'BlackboardsShow',
    [
        \Wills\WillsBlackboards\Controller\BlackboardsController::class => 'show, edit, update, imageEdit',
        \Wills\WillsBlackboards\Controller\CommentsController::class => 'delete, createComment',
    ],
    [
        \Wills\WillsBlackboards\Controller\BlackboardsController::class => 'show, edit, update, imageEdit',
        \Wills\WillsBlackboards\Controller\CommentsController::class => 'delete, createComment',
    ]
 );
call_user_func(
    function()
    {
    	$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks']['Wills\\WillsBlackboards\\Task\\BlackboardArchive'] = [
			'extension' => 'Wills_blackboards',
			'title' => 'Blackboards to Archive',
			'description' => 'It sets hidden equal to 1 once the creating dates is loder than the times setted on the task.',
			'additionalFields' => 'Wills\\WillsBlackboards\\Task\\BlackboardArchiveFieldProvider'
		];
	}
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerTypeConverter('Wills\\WillsBlackboards\\Property\\TypeConverter\\UploadedFileReferenceConverter');

