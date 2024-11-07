<?php

use \TYPO3\CMS\Core\Utility\GeneralUtility;
use \TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use \B13\Container\Tca\Registry;
use \B13\Container\Tca\ContainerConfiguration;

defined('TYPO3') or die();

/***************
 * Add new EXT:container CTypes
 */

# TWO COLUMNS
GeneralUtility::makeInstance(Registry::class)->configureContainer(
	(
		new ContainerConfiguration(
			'two_columns',
			'LLL:EXT:t3sbootstrap_grid/Resources/Private/Language/locallang_be.xlf:tx_container.twoColumns.title',
			'LLL:EXT:t3sbootstrap_grid/Resources/Private/Language/locallang_be.xlf:tx_container.twoColumns.description',
			[
				[
					['name' => 'LLL:EXT:t3sbootstrap_grid/Resources/Private/Language/locallang_be.xlf:tx_container.anyColumns.colPos.0', 'colPos' => 221],
					['name' => 'LLL:EXT:t3sbootstrap_grid/Resources/Private/Language/locallang_be.xlf:tx_container.anyColumns.colPos.1', 'colPos' => 222]
				]
			]
		)
	)
	->setIcon('EXT:container/Resources/Public/Icons/container-2col.svg')
	->setGroup('T3S Bootstrap Grid')
	->setSaveAndCloseInNewContentElementWizard(false)
);

$GLOBALS['TCA']['tt_content']['types']['two_columns']['showitem'] = '
		--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
			--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.general;general,
			--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.headers;headers,
		--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.appearance,
			--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.frames;frames,T3SFlex;tx_t3sbootstrap_grid_flexform,
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

# THREE COLUMNS
GeneralUtility::makeInstance(Registry::class)->configureContainer(
	(
		new ContainerConfiguration(
			'three_columns',
			'LLL:EXT:t3sbootstrap_grid/Resources/Private/Language/locallang_be.xlf:tx_container.threeColumns.title',
			'LLL:EXT:t3sbootstrap_grid/Resources/Private/Language/locallang_be.xlf:tx_container.threeColumns.description',
			[
				[
					['name' => 'LLL:EXT:t3sbootstrap_grid/Resources/Private/Language/locallang_be.xlf:tx_container.anyColumns.colPos.0', 'colPos' => 231],
					['name' => 'LLL:EXT:t3sbootstrap_grid/Resources/Private/Language/locallang_be.xlf:tx_container.anyColumns.colPos.1', 'colPos' => 232],
					['name' => 'LLL:EXT:t3sbootstrap_grid/Resources/Private/Language/locallang_be.xlf:tx_container.anyColumns.colPos.2', 'colPos' => 233]
				  ]
			]
		)
	)
	->setIcon('EXT:container/Resources/Public/Icons/container-3col.svg')
	->setGroup('T3S Bootstrap Grid')
	->setSaveAndCloseInNewContentElementWizard(false)
);
$GLOBALS['TCA']['tt_content']['types']['three_columns']['showitem'] = $GLOBALS['TCA']['tt_content']['types']['two_columns']['showitem'];

# FOUR COLUMNS
GeneralUtility::makeInstance(Registry::class)->configureContainer(
	(
		new ContainerConfiguration(
			'four_columns',
			'LLL:EXT:t3sbootstrap_grid/Resources/Private/Language/locallang_be.xlf:tx_container.fourColumns.title',
			'LLL:EXT:t3sbootstrap_grid/Resources/Private/Language/locallang_be.xlf:tx_container.fourColumns.description',
			[
				[
					['name' => 'LLL:EXT:t3sbootstrap_grid/Resources/Private/Language/locallang_be.xlf:tx_container.anyColumns.colPos.0', 'colPos' => 241],
					['name' => 'LLL:EXT:t3sbootstrap_grid/Resources/Private/Language/locallang_be.xlf:tx_container.anyColumns.colPos.1', 'colPos' => 242],
					['name' => 'LLL:EXT:t3sbootstrap_grid/Resources/Private/Language/locallang_be.xlf:tx_container.anyColumns.colPos.2', 'colPos' => 243],
					['name' => 'LLL:EXT:t3sbootstrap_grid/Resources/Private/Language/locallang_be.xlf:tx_container.anyColumns.colPos.3', 'colPos' => 244]
				  ]
			]
		)
	)
	->setIcon('EXT:container/Resources/Public/Icons/container-4col.svg')
	->setGroup('T3S Bootstrap Grid')
	->setSaveAndCloseInNewContentElementWizard(false)
);
$GLOBALS['TCA']['tt_content']['types']['four_columns']['showitem'] = $GLOBALS['TCA']['tt_content']['types']['two_columns']['showitem'];

# SIX COLUMNS
GeneralUtility::makeInstance(Registry::class)->configureContainer(
	(
		new ContainerConfiguration(
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
					['name' => 'LLL:EXT:t3sbootstrap_grid/Resources/Private/Language/locallang_be.xlf:tx_container.anyColumns.colPos.5', 'colPos' => 266]
				  ]
			]
		)
	)
	->setIcon('EXT:container/Resources/Public/Icons/container-4col.svg')
	->setGroup('T3S Bootstrap Grid')
	->setSaveAndCloseInNewContentElementWizard(false)
);
$GLOBALS['TCA']['tt_content']['types']['six_columns']['showitem'] = $GLOBALS['TCA']['tt_content']['types']['two_columns']['showitem'];

# ROW COLUMNS
GeneralUtility::makeInstance(Registry::class)->configureContainer(
	(
		new ContainerConfiguration(
			'row_columns',
			'LLL:EXT:t3sbootstrap_grid/Resources/Private/Language/locallang_be.xlf:tx_container.rowColumns.title',
			'LLL:EXT:t3sbootstrap_grid/Resources/Private/Language/locallang_be.xlf:tx_container.rowColumns.description',
			[
				[
					['name' => 'LLL:EXT:t3sbootstrap_grid/Resources/Private/Language/locallang_be.xlf:tx_container.anyColumns.colPos.290', 'colPos' => 290]
				  ]
			]
		)
	)
	->setIcon('EXT:container/Resources/Public/Icons/container-4col.svg')
	->setGroup('T3S Bootstrap Grid')
	->setSaveAndCloseInNewContentElementWizard(false)
);
$GLOBALS['TCA']['tt_content']['types']['row_columns']['showitem'] = $GLOBALS['TCA']['tt_content']['types']['two_columns']['showitem'];


/***************
 * New fields in table:tt_content
*/
$tempContentColumns = [
	'tx_t3sbootstrap_grid_flexform' => [
		'exclude' => 1,
		'l10n_display' => 'hideDiff',
		'label' => ' ',
		'displayCond' => 'USER:T3S\\T3sbootstrapGrid\\DisplayCond\\Cond->useGridField',
		'config' => [
			'type' => 'flex',
			'ds_pointerField' => 'CType',
			'ds' => [
				'default' => 'FILE:EXT:t3sbootstrap_grid/Configuration/FlexForms/Default.xml',
				'two_columns' => 'FILE:EXT:t3sbootstrap_grid/Configuration/FlexForms/TwoColumns.xml',
				'three_columns' => 'FILE:EXT:t3sbootstrap_grid/Configuration/FlexForms/ThreeColumns.xml',
				'four_columns' => 'FILE:EXT:t3sbootstrap_grid/Configuration/FlexForms/FourColumns.xml',
				'six_columns' => 'FILE:EXT:t3sbootstrap_grid/Configuration/FlexForms/SixColumns.xml',
				'row_columns' => 'FILE:EXT:t3sbootstrap_grid/Configuration/FlexForms/RowColumns.xml',
			]
		]
	],
];

ExtensionManagementUtility::addTCAcolumns('tt_content',$tempContentColumns);
unset($tempContentColumns);

ExtensionManagementUtility::addToAllTCAtypes(
	'tt_content',
	'--palette--;T3S Bootstrap Grid System;bootstrapGrid',
	'',
	'after:layout',
);

$GLOBALS['TCA']['tt_content']['palettes']['bootstrapGrid'] = [
  'showitem' => 'tx_t3sbootstrap_grid_flexform',
];

