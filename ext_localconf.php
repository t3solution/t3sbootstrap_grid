<?php
use T3S\T3sbootstrapGrid\Updates\GridUpdateWizard;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Information\Typo3Version;

defined('TYPO3') || die();

(function () {

	$typo3Version = new Typo3Version();

	/***************
	 * Registering wizards
	 */
	$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/install']['update']['t3sGridUpdateWizard'] = GridUpdateWizard::class;

	/***************
	 * TsConfig
	 */
	 # Page
	// bug in EXT:container with PHP 8
	ExtensionManagementUtility::addPageTSConfig("@import 'EXT:t3sbootstrap_grid/Configuration/TSConfig/Page.tsconfig'");

})();
