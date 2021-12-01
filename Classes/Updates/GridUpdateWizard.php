<?php
declare(strict_types=1);

namespace T3S\T3sbootstrapGrid\Updates;

/*
 * This file is part of the TYPO3 extension t3sbootstrap_grid.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use TYPO3\CMS\Install\Updates\UpgradeWizardInterface;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\Restriction\DeletedRestriction;
use TYPO3\CMS\Core\Utility\GeneralUtility;


class GridUpdateWizard implements UpgradeWizardInterface
{
	/**
	 * Return the identifier for this wizard
	 * This should be the same string as used in the ext_localconf class registration
	 */
	public function getIdentifier(): string
	{
	  return 't3sGridUpdateWizard';
	}

	/**
	 * Return the speaking name of this wizard
	 */
	public function getTitle(): string
	{
	  return 'T3Sbootstrap Grid - Migrate tx_gridelements to tx_container';
	}

	/**
	 * Return the description for this wizard
	 */
	public function getDescription(): string
	{
	  return 'Migrate all content elements CType "gridelements_pi1" (e.g. "Two Columns" etc.) to EXT:container.';
	}

	/**
	 * Execute the update
	 *
	 * Called when a wizard reports that an update is necessary
	 */
	public function executeUpdate(): bool
	{
		$this->upgradeColumns();

 		return true;
	}

	/**
	 * Upgrade all grid columns
	 */
	protected function upgradeColumns(): void
	{

		$connectionPool = GeneralUtility::makeInstance(ConnectionPool::class);
		$queryBuilder = $connectionPool->getQueryBuilderForTable('tt_content');
		$queryBuilder->getRestrictions()->removeAll()
		->add(GeneralUtility::makeInstance(DeletedRestriction::class));
		$allGridelements = $queryBuilder
			->select('*')
			->from('tt_content')
			->where(
				$queryBuilder->expr()->eq('CType', $queryBuilder->createNamedParameter('gridelements_pi1'))
			)
			->execute()
			->fetchAll();

		if (!empty($allGridelements) && is_array($allGridelements)) {

			foreach ($allGridelements as $container) {

				$newCType = $container['tx_gridelements_backend_layout'];
				$containerId =	(int)$container['uid'];
				$parentContainerId = (int)$container['tx_gridelements_container'] ?: 0;
				$containerColPos = $container['colPos'];

				$queryBuilder = $connectionPool->getQueryBuilderForTable('tt_content');
				$queryBuilder->getRestrictions()->removeAll()
				->add(GeneralUtility::makeInstance(DeletedRestriction::class));

				$statement = $queryBuilder
					->select('tx_gridelements_backend_layout')
					->from('tt_content')
					->where(
						$queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($parentContainerId, \PDO::PARAM_INT))
					)
					->execute()
					->fetch();

				switch ($statement['tx_gridelements_backend_layout']) {
					case 'two_columns':
						$containerColPos = $container['tx_gridelements_columns'] === 0 ? 221 : 222;
						break;
					case 'three_columns':
						if ($container['tx_gridelements_columns'] === 0) {
							$containerColPos = 231;
						} elseif ($container['tx_gridelements_columns'] === 1) {
							$containerColPos = 232;
						} else {
							$containerColPos = 233;
						}
						break;
					case 'four_columns':
						if ($container['tx_gridelements_columns'] === 0) {
							$containerColPos = 241;
						} elseif ($container['tx_gridelements_columns'] === 1) {
							$containerColPos = 242;
						} elseif ($container['tx_gridelements_columns'] === 2) {
							$containerColPos = 243;
						} else {
							$containerColPos = 244;
						}
						break;
					case 'six_columns':
						if ($container['tx_gridelements_columns'] === 0) {
							$containerColPos = 261;
						} elseif ($container['tx_gridelements_columns'] === 1) {
							$containerColPos = 262;
						} elseif ($container['tx_gridelements_columns'] === 2) {
							$containerColPos = 263;
						} elseif ($container['tx_gridelements_columns'] === 3) {
							$containerColPos = 264;
						} elseif ($container['tx_gridelements_columns'] === 4) {
							$containerColPos = 265;
						} else {
							$containerColPos = 266;
						}
						break;
					case 'card_wrapper':
						$containerColPos = 270;
						break;
					case 'button_group':
						$containerColPos = 271;
						break;
					case 'autoLayout_row':
						$containerColPos = 272;
						break;
					case 'background_wrapper':
						$containerColPos = 273;
						break;
					case 'parallax_wrapper':
						$containerColPos = 274;
						break;
					case 'container':
						$containerColPos = 275;
						break;
					case 'carousel_container':
						$containerColPos = 276;
						break;
					case 'collapsible_container':
						$containerColPos = 277;
						break;
					case 'collapsible_accordion':
						$containerColPos = 278;
						break;
					case 'modal':
						$containerColPos = 279;
						break;
					case 'tabs_container':
						$containerColPos = 280;
						break;
					case 'tabs_tab':
						$containerColPos = 281;
						break;
					case 'listGroup_wrapper':
						$containerColPos = 282;
						break;
					default:
						$containerColPos = $container['colPos'];
				}

				$queryBuilder = $connectionPool->getQueryBuilderForTable('tt_content');
				$queryBuilder->getRestrictions()->removeAll()
				->add(GeneralUtility::makeInstance(DeletedRestriction::class));

				$children = $queryBuilder
					->select('*')
					->from('tt_content')
					->where(
						$queryBuilder->expr()->eq('tx_gridelements_container', $queryBuilder->createNamedParameter($containerId, \PDO::PARAM_INT)),
						$queryBuilder->expr()->neq('CType', $queryBuilder->createNamedParameter('gridelements_pi1'))
					)
					->execute()->fetchAll();

				if (!empty($children) && is_array($children)) {

					foreach ($children as $child) {

						if ($newCType == 'two_columns') {
							$queryBuilder
								->update('tt_content')
								->where(
									$queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($child['uid'], \PDO::PARAM_INT)),
									$queryBuilder->expr()->eq('tx_gridelements_columns', $queryBuilder->createNamedParameter(0, \PDO::PARAM_INT))
								)
								->set('colPos', 221)
								->set('tx_container_parent', $containerId)
								->execute();

							$queryBuilder
								->update('tt_content')
								->where(
									$queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($child['uid'], \PDO::PARAM_INT)),
									$queryBuilder->expr()->eq('tx_gridelements_columns', $queryBuilder->createNamedParameter(1, \PDO::PARAM_INT))
								)
								->set('colPos', 222)
								->set('tx_container_parent', $containerId)
								->execute();

						} elseif ($newCType == 'three_columns') {

							$queryBuilder
								->update('tt_content')
								->where(
									$queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($child['uid'], \PDO::PARAM_INT)),
									$queryBuilder->expr()->eq('tx_gridelements_columns', $queryBuilder->createNamedParameter(0, \PDO::PARAM_INT))
								)
								->set('colPos', 231)
								->set('tx_container_parent', $containerId)
								->execute();

							$queryBuilder
								->update('tt_content')
								->where(
									$queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($child['uid'], \PDO::PARAM_INT)),
									$queryBuilder->expr()->eq('tx_gridelements_columns', $queryBuilder->createNamedParameter(1, \PDO::PARAM_INT))
								)
								->set('colPos', 232)
								->set('tx_container_parent', $containerId)
								->execute();

							$queryBuilder
								->update('tt_content')
								->where(
									$queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($child['uid'], \PDO::PARAM_INT)),
									$queryBuilder->expr()->eq('tx_gridelements_columns', $queryBuilder->createNamedParameter(2, \PDO::PARAM_INT))
								)
								->set('colPos', 233)
								->set('tx_container_parent', $containerId)
								->execute();

						} elseif ($newCType == 'four_columns') {

							$queryBuilder
								->update('tt_content')
								->where(
									$queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($child['uid'], \PDO::PARAM_INT)),
									$queryBuilder->expr()->eq('tx_gridelements_columns', $queryBuilder->createNamedParameter(0, \PDO::PARAM_INT))
								)
								->set('colPos', 241)
								->set('tx_container_parent', $containerId)
								->execute();

							$queryBuilder
								->update('tt_content')
								->where(
									$queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($child['uid'], \PDO::PARAM_INT)),
									$queryBuilder->expr()->eq('tx_gridelements_columns', $queryBuilder->createNamedParameter(1, \PDO::PARAM_INT))
								)
								->set('colPos', 242)
								->set('tx_container_parent', $containerId)
								->execute();

							$queryBuilder
								->update('tt_content')
								->where(
									$queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($child['uid'], \PDO::PARAM_INT)),
									$queryBuilder->expr()->eq('tx_gridelements_columns', $queryBuilder->createNamedParameter(2, \PDO::PARAM_INT))
								)
								->set('colPos', 243)
								->set('tx_container_parent', $containerId)
								->execute();

							$queryBuilder
								->update('tt_content')
								->where(
									$queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($child['uid'], \PDO::PARAM_INT)),
									$queryBuilder->expr()->eq('tx_gridelements_columns', $queryBuilder->createNamedParameter(3, \PDO::PARAM_INT))
								)
								->set('colPos', 244)
								->set('tx_container_parent', $containerId)
								->execute();

						} elseif ($newCType == 'six_columns') {

							$queryBuilder
								->update('tt_content')
								->where(
									$queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($child['uid'], \PDO::PARAM_INT)),
									$queryBuilder->expr()->eq('tx_gridelements_columns', $queryBuilder->createNamedParameter(0, \PDO::PARAM_INT))
								)
								->set('colPos', 261)
								->set('tx_container_parent', $containerId)
								->execute();

							$queryBuilder
								->update('tt_content')
								->where(
									$queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($child['uid'], \PDO::PARAM_INT)),
									$queryBuilder->expr()->eq('tx_gridelements_columns', $queryBuilder->createNamedParameter(1, \PDO::PARAM_INT))
								)
								->set('colPos', 262)
								->set('tx_container_parent', $containerId)
								->execute();

							$queryBuilder
								->update('tt_content')
								->where(
									$queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($child['uid'], \PDO::PARAM_INT)),
									$queryBuilder->expr()->eq('tx_gridelements_columns', $queryBuilder->createNamedParameter(2, \PDO::PARAM_INT))
								)
								->set('colPos', 263)
								->set('tx_container_parent', $containerId)
								->execute();

							$queryBuilder
								->update('tt_content')
								->where(
									$queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($child['uid'], \PDO::PARAM_INT)),
									$queryBuilder->expr()->eq('tx_gridelements_columns', $queryBuilder->createNamedParameter(3, \PDO::PARAM_INT))
								)
								->set('colPos', 264)
								->set('tx_container_parent', $containerId)
								->execute();

							$queryBuilder
								->update('tt_content')
								->where(
									$queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($child['uid'], \PDO::PARAM_INT)),
									$queryBuilder->expr()->eq('tx_gridelements_columns', $queryBuilder->createNamedParameter(4, \PDO::PARAM_INT))
								)
								->set('colPos', 265)
								->set('tx_container_parent', $containerId)
								->execute();

							$queryBuilder
								->update('tt_content')
								->where(
									$queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($child['uid'], \PDO::PARAM_INT)),
									$queryBuilder->expr()->eq('tx_gridelements_columns', $queryBuilder->createNamedParameter(5, \PDO::PARAM_INT))
								)
								->set('colPos', 266)
								->set('tx_container_parent', $containerId)
								->execute();

						}	 else {

							$queryBuilder
								->update('tt_content')
								->where(
									$queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($child['uid'], \PDO::PARAM_INT)),
									$queryBuilder->expr()->eq('tx_gridelements_columns', $queryBuilder->createNamedParameter(0, \PDO::PARAM_INT))
								)
								->set('colPos', $containerColPos)
								->set('tx_container_parent', $containerId)
								->execute();

						}
					}
				}

				$queryBuilder
					->update('tt_content')
					->where(
						$queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($containerId, \PDO::PARAM_INT))
					)
					->set('CType', $newCType)
					->set('colPos', $containerColPos)
					->set('tx_container_parent', $parentContainerId)
					->execute();
			}
		}
	}

	/**
	 * Is an update necessary?
	 *
	 * Is used to determine whether a wizard needs to be run.
	 * Check if data for migration exists.
	 */
	public function updateNecessary(): bool
	{
		$updateNeeded = false;
		// Check if the database table even exists
		if ( $this->checkIfWizardIsRequired() ) {
			$updateNeeded = true;
		}
		return $updateNeeded;
	}


	/**
	 * Returns an array of class names of prerequisite classes
	 *
	 * This way a wizard can define dependencies like "database up-to-date" or
	 * "reference index updated"
	 *
	 * @return string[]
	 */
	public function getPrerequisites(): array
	{
		return '';
	}

	/**
	 * Check if there are record within database table with an empty "gridelements_pi1" field.
	 *
	 * @throws \InvalidArgumentException
	 */
	protected function checkIfWizardIsRequired(): bool
	{
		$require = false;

		$queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tt_content');
		$rows = $queryBuilder
			 ->select('*')
			 ->from('tt_content')
			 ->where($queryBuilder->expr()->eq('pid', $queryBuilder->createNamedParameter(1, \PDO::PARAM_INT)))
			 ->execute()
			 ->fetchAll();

		if ($rows[0]['gridelements_pi1'] ?? '') {
			$connectionPool = GeneralUtility::makeInstance(ConnectionPool::class);
			$queryBuilder = $connectionPool->getQueryBuilderForTable('tt_content');
			$numberOfEntries = $queryBuilder
				->count('uid')
				->from('tt_content')
				->where($queryBuilder->expr()->isNotNull('gridelements_pi1'))
				->execute()
				->fetchColumn();

			$require = $numberOfEntries ? true : false;
		}

		 return (bool)$require;
	}

}
