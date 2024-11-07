<?php
declare(strict_types=1);

namespace T3S\T3sbootstrapGrid\ViewHelpers;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Service\FlexFormService;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/*
 * This file is part of the TYPO3 extension t3sbootstrap_grid.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */
class FlexformViewHelper extends AbstractViewHelper
{

	/**
	 * @return void
	 */
	public function initializeArguments(): void
	{
		parent::initializeArguments();
		$this->registerArgument('flexform', 'string', 'Flexform field');
		$this->registerArgument('cType', 'string', 'CType', false);
	}

	public function render()
	{
		$classes = [];

		if ( empty( $this->arguments['flexform']) ) {
			return $classes;
		}

		$extraClass = [];
		$extraClass['extraClass_one'] = '';
		$extraClass['extraClass_two'] = '';
		$extraClass['extraClass_three'] = '';
		$extraClass['extraClass_four'] = '';
		$extraClass['extraClass_five'] = '';
		$extraClass['extraClass_six'] = '';
		$classes['extraClassCols'] = '';
		$classes['rowClass'] = '';

		$flexFormService = GeneralUtility::makeInstance(FlexFormService::class);
		$flexconf = $flexFormService->convertFlexFormContentToArray($this->arguments['flexform']);

		if ( !empty($this->arguments['cType']) && $this->arguments['cType'] == 'row_columns' ) {
			// row_columns
			if ( !empty($flexconf['cols_extraClass']) ) {
				$classes['extraClassCols'] = ' '.trim($flexconf['cols_extraClass']);

			}

			$keyArr = [];
			$rowClass = [];

			foreach (array_reverse($flexconf) as $key=>$grid) {

				if (!empty($grid)) {

					$keyArr = explode('_', $key);

					if ( !empty($keyArr[1]) ) {

						if ( $keyArr[1] == 'rowclass' ) {
							if (str_starts_with($key, 'xxl_')) {
								$rowClass[5] = '-'.$grid;
							} elseif (str_starts_with($key, 'xl_')) {
								$rowClass[4] = '-'.$grid;
							} elseif (str_starts_with($key, 'lg_')) {
								$rowClass[3] = '-'.$grid;
							} elseif (str_starts_with($key, 'md_')) {
								$rowClass[2] = '-'.$grid;
							} elseif (str_starts_with($key, 'sm_')) {
								$rowClass[1] = '-'.$grid;
							}elseif (str_starts_with($key, 'xs_')) {
								$rowClass[0] = '-'.$grid;
							}
						}
					}
				}
			}

			$classes['rowClass'] = $rowClass;

		} else {

			if ( !empty($flexconf['equalWidth']) ) {

				$colOne = 'col';
				$colTwo = 'col';
				$colThree = 'col';
				$colFour = 'col';
				$colFive = 'col';
				$colSix = 'col';

				foreach (array_reverse($flexconf) as $key=>$grid) {

					if ($grid) {

						if (str_starts_with($key, 'extraClass_')) {
							$extraClass[$key] = trim($grid);
						}
					}
				}

			} else {

				$colOne = '';
				$colTwo = '';
				$colThree = '';
				$colFour = '';
				$colFive = '';
				$colSix = '';

				foreach (array_reverse($flexconf) as $key=>$grid) {

					if (!empty($grid)) {

						if (str_starts_with($key, 'extraClass_')) {
							$extraClass[$key] = trim($grid);
						} elseif ( $key === 'containerWrapper' || $key === 'row_extraClass' || $key === 'verticalGutters' || $key === 'horizontalGutters' ) {
							// do nothing
						} else {
							if ( substr($key, 0, 2) == 'xs' ) {
								if ( substr($key, -3) == 'one' ) {
									$colOne .= ' col-'.$grid;
								}
								if ( substr($key, -3) == 'two' ) {
									$colTwo .= ' col-'.$grid;
								}
								if ( substr($key, -5) == 'three' ) {
									$colThree .= ' col-'.$grid;
								}
								if ( substr($key, -4) == 'four' ) {
									$colFour .= ' col-'.$grid;
								}
								if ( substr($key, -4) == 'five' ) {
									$colFive .= ' col-'.$grid;
								}
								if ( substr($key, -3) == 'six' ) {
									$colSix .= ' col-'.$grid;
								}
							} else {
								if ( substr($key, -3) == 'one' ) {
									$colOne .= ' col-'.substr($key, 0, -4).'-'.$grid;
								}
								if ( substr($key, -3) == 'two' ) {
									$colTwo .= ' col-'.substr($key, 0, -4).'-'.$grid;
								}
								if ( substr($key, -5) == 'three' ) {
									$colThree .= ' col-'.substr($key, 0, -6).'-'.$grid;
								}
								if ( substr($key, -4) == 'four' ) {
									$colFour .= ' col-'.substr($key, 0, -5).'-'.$grid;
								}
								if ( substr($key, -4) == 'five' ) {
									$colFive .= ' col-'.substr($key, 0, -5).'-'.$grid;
								}
								if ( substr($key, -3) == 'six' ) {
									$colSix .= ' col-'.substr($key, 0, -4).'-'.$grid;
								}
							}
						}
					}
				}
			}

			$classes['columnOne'] = trim($colOne.' '.$extraClass['extraClass_one']);
			$classes['columnTwo'] = trim($colTwo.' '.$extraClass['extraClass_two']);
			$classes['columnThree'] = trim($colThree.' '.$extraClass['extraClass_three']);
			$classes['columnFour'] = trim($colFour.' '.$extraClass['extraClass_four']);
			$classes['columnFive'] = trim($colFive.' '.$extraClass['extraClass_five']);
			$classes['columnSix'] = trim($colSix.' '.$extraClass['extraClass_six']);
		}

		$horizontalGutters = !empty($flexconf['horizontalGutters']) && $flexconf['horizontalGutters'] == 'gx-4' ? '' : ' '.$flexconf['horizontalGutters'];
		$verticalGutters = !empty($flexconf['verticalGutters']) && $flexconf['verticalGutters'] == 'gy-4' ? '' : $flexconf['verticalGutters'];
		$extraContainerClass = '';
		#if ( $verticalGutters !== 'gy-0' ) {
		#	$extraContainerClass = ' overflow-hidden';
		#}
		$containerWrapper = !empty($flexconf['containerWrapper']) ? $flexconf['containerWrapper'] : '';
		if ( empty($containerWrapper) ) {
			$extraContainerClass = trim($extraContainerClass);
		}
		$gutters = trim($horizontalGutters).' '.trim($verticalGutters);
		if (empty($gutters)) {
			$classes['gutters'] = '';
		} else {
			$classes['gutters'] = ' '.trim($gutters);
		}

		$classes['extraClassRow'] = !empty($flexconf['row_extraClass']) ?	 ' '.trim($flexconf['row_extraClass']) : '';
		$classes['containerClass'] = $containerWrapper.$extraContainerClass;

		return $classes;
	}

}
