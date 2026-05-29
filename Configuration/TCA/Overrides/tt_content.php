<?php

use B13\Container\Tca\ContainerConfiguration;
use B13\Container\Tca\Registry;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

defined('TYPO3') or die();

# Container showitem definition - reused across all grid containers
$gridContainerShowitem = '
	--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
		--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.general;general,
		--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.headers;headers,
	--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.appearance,
		--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.frames;frames,
		tx_t3sbootstrap_grid_flexform,
		--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.appearanceLinks;appearanceLinks,
	--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,
		--palette--;;language,
	--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
		--palette--;;hidden,
		--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.access;access,
	--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:categories,
		categories,
	--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:notes,
		rowDescription,
	--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:extended
';

# TWO COLUMNS
GeneralUtility::makeInstance(Registry::class)->configureContainer(
	(new ContainerConfiguration(
		'two_columns',
		'LLL:EXT:t3sbootstrap_grid/Resources/Private/Language/locallang_be.xlf:tx_container.twoColumns.title',
		'LLL:EXT:t3sbootstrap_grid/Resources/Private/Language/locallang_be.xlf:tx_container.twoColumns.description',
		[
			[
				['name' => 'LLL:EXT:t3sbootstrap_grid/Resources/Private/Language/locallang_be.xlf:tx_container.anyColumns.colPos.0', 'colPos' => 221],
				['name' => 'LLL:EXT:t3sbootstrap_grid/Resources/Private/Language/locallang_be.xlf:tx_container.anyColumns.colPos.1', 'colPos' => 222],
			],
		],
	))
	->setIcon('EXT:t3sbootstrap_grid/Resources/Public/Icons/ge-2_col.svg')
	->setGroup('T3S Bootstrap Grid')
	->setSaveAndCloseInNewContentElementWizard(true)
);
$GLOBALS['TCA']['tt_content']['types']['two_columns']['showitem'] = $gridContainerShowitem;

# THREE COLUMNS
GeneralUtility::makeInstance(Registry::class)->configureContainer(
	(new ContainerConfiguration(
		'three_columns',
		'LLL:EXT:t3sbootstrap_grid/Resources/Private/Language/locallang_be.xlf:tx_container.threeColumns.title',
		'LLL:EXT:t3sbootstrap_grid/Resources/Private/Language/locallang_be.xlf:tx_container.threeColumns.description',
		[
			[
				['name' => 'LLL:EXT:t3sbootstrap_grid/Resources/Private/Language/locallang_be.xlf:tx_container.anyColumns.colPos.0', 'colPos' => 231],
				['name' => 'LLL:EXT:t3sbootstrap_grid/Resources/Private/Language/locallang_be.xlf:tx_container.anyColumns.colPos.1', 'colPos' => 232],
				['name' => 'LLL:EXT:t3sbootstrap_grid/Resources/Private/Language/locallang_be.xlf:tx_container.anyColumns.colPos.2', 'colPos' => 233],
			],
		],
	))
	->setIcon('EXT:t3sbootstrap_grid/Resources/Public/Icons/ge-3_col.svg')
	->setGroup('T3S Bootstrap Grid')
	->setSaveAndCloseInNewContentElementWizard(false)
);
$GLOBALS['TCA']['tt_content']['types']['three_columns']['showitem'] = $gridContainerShowitem;

# FOUR COLUMNS
GeneralUtility::makeInstance(Registry::class)->configureContainer(
	(new ContainerConfiguration(
		'four_columns',
		'LLL:EXT:t3sbootstrap_grid/Resources/Private/Language/locallang_be.xlf:tx_container.fourColumns.title',
		'LLL:EXT:t3sbootstrap_grid/Resources/Private/Language/locallang_be.xlf:tx_container.fourColumns.description',
		[
			[
				['name' => 'LLL:EXT:t3sbootstrap_grid/Resources/Private/Language/locallang_be.xlf:tx_container.anyColumns.colPos.0', 'colPos' => 241],
				['name' => 'LLL:EXT:t3sbootstrap_grid/Resources/Private/Language/locallang_be.xlf:tx_container.anyColumns.colPos.1', 'colPos' => 242],
				['name' => 'LLL:EXT:t3sbootstrap_grid/Resources/Private/Language/locallang_be.xlf:tx_container.anyColumns.colPos.2', 'colPos' => 243],
				['name' => 'LLL:EXT:t3sbootstrap_grid/Resources/Private/Language/locallang_be.xlf:tx_container.anyColumns.colPos.3', 'colPos' => 244],
			],
		],
	))
	->setIcon('EXT:t3sbootstrap_grid/Resources/Public/Icons/ge-4_col.svg')
	->setGroup('T3S Bootstrap Grid')
	->setSaveAndCloseInNewContentElementWizard(false)
);
$GLOBALS['TCA']['tt_content']['types']['four_columns']['showitem'] = $gridContainerShowitem;

# SIX COLUMNS
GeneralUtility::makeInstance(Registry::class)->configureContainer(
	(new ContainerConfiguration(
		'six_columns',
		'LLL:EXT:t3sbootstrap_grid/Resources/Private/Language/locallang_be.xlf:tx_container.sixColumns.title',
		'LLL:EXT:t3sbootstrap_grid/Resources/Private/Language/locallang_be.xlf:tx_container.sixColumns.description',
		[
			[
				['name' => 'LLL:EXT:t3sbootstrap_grid/Resources/Private/Language/locallang_be.xlf:tx_container.anyColumns.colPos.0', 'colPos' => 261],
				['name' => 'LLL:EXT:t3sbootstrap_grid/Resources/Private/Language/locallang_be.xlf:tx_container.anyColumns.colPos.1', 'colPos' => 262],
				['name' => 'LLL:EXT:t3sbootstrap_grid/Resources/Private/Language/locallang_be.xlf:tx_container.anyColumns.colPos.2', 'colPos' => 263],
				['name' => 'LLL:EXT:t3sbootstrap_grid/Resources/Private/Language/locallang_be.xlf:tx_container.anyColumns.colPos.3', 'colPos' => 264],
				['name' => 'LLL:EXT:t3sbootstrap_grid/Resources/Private/Language/locallang_be.xlf:tx_container.anyColumns.colPos.4', 'colPos' => 265],
				['name' => 'LLL:EXT:t3sbootstrap_grid/Resources/Private/Language/locallang_be.xlf:tx_container.anyColumns.colPos.5', 'colPos' => 266],
			],
		],
	))
	->setIcon('EXT:t3sbootstrap_grid/Resources/Public/Icons/ge-4_col.svg')
	->setGroup('T3S Bootstrap Grid')
	->setSaveAndCloseInNewContentElementWizard(false)
);
$GLOBALS['TCA']['tt_content']['types']['six_columns']['showitem'] = $gridContainerShowitem;

# ROW COLUMNS
GeneralUtility::makeInstance(Registry::class)->configureContainer(
	(new ContainerConfiguration(
		'row_columns',
		'LLL:EXT:t3sbootstrap_grid/Resources/Private/Language/locallang_be.xlf:tx_container.rowColumns.title',
		'LLL:EXT:t3sbootstrap_grid/Resources/Private/Language/locallang_be.xlf:tx_container.rowColumns.description',
		[
			[
				['name' => 'LLL:EXT:t3sbootstrap_grid/Resources/Private/Language/locallang_be.xlf:tx_container.anyColumns.colPos.290', 'colPos' => 290],
			],
		],
	))
	->setIcon('EXT:t3sbootstrap_grid/Resources/Public/Icons/ge-4_col.svg')
	->setGroup('T3S Bootstrap Grid')
	->setSaveAndCloseInNewContentElementWizard(false)
);
$GLOBALS['TCA']['tt_content']['types']['row_columns']['showitem'] = $gridContainerShowitem;

/***************
 * New field in table:tt_content
 *
 * The default ds (Default.xml) acts as a safe fallback for any CType not
 * covered by the columnsOverrides loop below.
 */
$tempContentColumns = [
	'tx_t3sbootstrap_grid_flexform' => [
		'exclude' => true,
		'l10n_mode' => 'exclude',
		'l10n_display' => 'hideDiff',
		'label' => ' ',
		'config' => [
			'type' => 'flex',
			'ds' => 'FILE:EXT:t3sbootstrap_grid/Configuration/FlexForms/Default.xml',
		],
	],
];

ExtensionManagementUtility::addTCAcolumns('tt_content', $tempContentColumns);

# Per-CType FlexForm data structures (v14 way, replaces ds_pointerField)
$gridTypes = [
	'two_columns'   => 'TwoColumns.xml',
	'three_columns' => 'ThreeColumns.xml',
	'four_columns'  => 'FourColumns.xml',
	'six_columns'   => 'SixColumns.xml',
	'row_columns'   => 'RowColumns.xml',
];

foreach ($gridTypes as $cType => $flexFormFile) {
	$GLOBALS['TCA']['tt_content']['types'][$cType]['columnsOverrides']['tx_t3sbootstrap_grid_flexform']['config'] = [
		'type' => 'flex',
		'ds' => 'FILE:EXT:t3sbootstrap_grid/Configuration/FlexForms/' . $flexFormFile,
	];
}