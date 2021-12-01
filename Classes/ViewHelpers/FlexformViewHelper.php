<?php
namespace T3S\T3sbootstrapGrid\ViewHelpers;

/*
 * This file is part of the TYPO3 extension t3sbootstrap_grid.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Service\FlexFormService;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

class FlexformViewHelper extends AbstractViewHelper
{
	use CompileWithRenderStatic;

	/**
	 * @return void
	 */
	public function initializeArguments()
	{
		parent::initializeArguments();
		$this->registerArgument('flexform', 'string', 'Flexform field');
	}

	public static function renderStatic(
		array $arguments,
		\Closure $renderChildrenClosure,
		RenderingContextInterface $renderingContext
	) {

		$flexFormService = GeneralUtility::makeInstance(FlexFormService::class);
		$flexconf = $flexFormService->convertFlexFormContentToArray($arguments['flexform']);

		$rowClass = [];
		$extraClass = [];
		$isColsClass = FALSE;
		$extraClass['extraClass_one'] = '';
		$extraClass['extraClass_two'] = '';
		$extraClass['extraClass_three'] = '';
		$extraClass['extraClass_four'] = '';
		$extraClass['extraClass_five'] = '';
		$extraClass['extraClass_six'] = '';

		if ( $flexconf['equalWidth'] ) {
			$colOne = 'col';
			$colTwo = 'col';
			$colThree = 'col';
			$colFour = 'col';
			$colFive = 'col';
			$colSix = 'col';

			foreach (array_reverse($flexconf) as $key=>$grid) {
				$keyArr = explode('_', $key);
				if ( substr($key,-10) === 'extraClass' ) {
					$extraClass[$key] = $grid;
				}

				if ($grid) {
					if ( substr($key,-8) === 'rowclass' ) {
						$rowClass[$key] = $grid;
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
				$keyArr = explode('_', $key);
				if ( substr($key,-10) === 'extraClass' ) {
					$extraClass[$key] = $grid;
				}

				if ($grid) {
					if ( substr($key,-8) === 'rowclass' ) {
						$rowClass[$key] = $grid;
					}
				}

				if ( !GeneralUtility::inList('extraClass_one, extraClass_two, extraClass_three, extraClass_four, extraClass_five,
				 extraClass_six, equalWidth, noGutters, horizontalGutters, verticalGutters', $key) ) {
					if ($grid) {
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

		if ($flexconf['cols_extraClass'] ?? '') {
			$isColsClass = TRUE;
			foreach (explode(',',$flexconf['cols_extraClass']) as $key=>$cec ) {
				$colsClass[$key] = ' '.trim($cec);
			}
		}

		$horizontalGutters = (trim($flexconf['horizontalGutters']) == 'gx-4') ? '' : trim($flexconf['horizontalGutters']);
		$verticalGutters = (trim($flexconf['verticalGutters']) == 'gy-4') ? '' : trim($flexconf['verticalGutters']);

		$extraContainerClass = '';
		if ( $verticalGutters ) {
			$extraContainerClass = ' overflow-hidden';
		}
		$containerWrapper = $flexconf['containerWrapper'] ? $flexconf['containerWrapper'] : '';
		if (!$containerWrapper) {
			$extraContainerClass = trim($extraContainerClass);
		}

		if ($isColsClass) {
			$classes['extraClassCols'] = $colsClass;
		}
		$classes['rowClass'] = ' '.implode(' ',$rowClass);
		$classes['gutters'] = ' '.$horizontalGutters.' '.$verticalGutters;
		$classes['extraClassRow'] = ' '.trim($flexconf['row_extraClass']);
		$classes['containerClass'] = $containerWrapper.$extraContainerClass;

		$classes['columnOne'] = trim($colOne.' '.$extraClass['extraClass_one']);
		$classes['columnTwo'] = trim($colTwo.' '.$extraClass['extraClass_two']);
		$classes['columnThree'] = trim($colThree.' '.$extraClass['extraClass_three']);
		$classes['columnFour'] = trim($colFour.' '.$extraClass['extraClass_four']);
		$classes['columnFive'] = trim($colFive.' '.$extraClass['extraClass_five']);
		$classes['columnSix'] = trim($colSix.' '.$extraClass['extraClass_six']);

		return $classes;
	}

}
