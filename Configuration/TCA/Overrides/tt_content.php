<?php

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'Wills.WillsBlackboards',
    'BlackboardsList',
    'Blackboards List view',
    'EXT:wills_blackboards/Resources/Public/Icons/Extension.svg'
);
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['willsblackboards_blackboardslist'] = 'pi_flexform';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['willsblackboards_blackboardslist'] = 'recursive,select_key,pages';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    // plugin signature: <extension key without underscores> '_' <plugin name in lowercase>
    'willsblackboards_blackboardslist',
    // Flexform configuration schema file
    'FILE:EXT:wills_blackboards/Configuration/FlexForms/BlackboardsList.xml'
);
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'Wills.WillsBlackboards',
    'BlackboardsNew',
    'Blackboards New view',
    'EXT:wills_blackboards/Resources/Public/Icons/Extension.svg'
);
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['willsblackboards_blackboardsnew'] = 'pi_flexform';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['willsblackboards_blackboardsnew'] = 'recursive';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    // plugin signature: <extension key without underscores> '_' <plugin name in lowercase>
    'willsblackboards_blackboardsnew',
    // Flexform configuration schema file
    'FILE:EXT:wills_blackboards/Configuration/FlexForms/BlackboardsNew.xml'
);
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'Wills.WillsBlackboards',
    'BlackboardsShow',
    'Blackboards Show view',
    'EXT:wills_blackboards/Resources/Public/Icons/Extension.svg'
);
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['willsblackboards_blackboardsshow'] = 'pi_flexform';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['willsblackboards_blackboardsshow'] = 'recursive,select_key,pages';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    // plugin signature: <extension key without underscores> '_' <plugin name in lowercase>
    'willsblackboards_blackboardsshow',
    // Flexform configuration schema file
    'FILE:EXT:wills_blackboards/Configuration/FlexForms/BlackboardsShow.xml'
);