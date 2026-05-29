<?php

declare(strict_types=1);

/*
 * This file is part of the TYPO3 extension t3sbootstrap_grid.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3S\T3sbootstrapGrid\ViewHelpers;

use TYPO3\CMS\Core\Service\FlexFormService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

class FlexformViewHelper extends AbstractViewHelper
{
	/**
	 * Mapping of Bootstrap breakpoint prefixes to row-class array indices.
	 * Order: largest breakpoint first, so longer prefixes (xxl) match before xl.
	 */
	private const BREAKPOINT_MAP = [
		'xxl' => 5,
		'xl' => 4,
		'lg' => 3,
		'md' => 2,
		'sm' => 1,
		'xs' => 0,
	];

	private const COLUMN_POSITIONS = ['one', 'two', 'three', 'four', 'five', 'six'];

	/**
	 * Column positions sorted by length descending, so longer suffixes
	 * ('three', 'four', 'five') are matched before shorter ones ('one', 'two', 'six').
	 */
	private const COLUMN_POSITIONS_BY_LENGTH = ['three', 'four', 'five', 'one', 'two', 'six'];

	private const SKIP_KEYS = ['containerWrapper', 'row_extraClass', 'verticalGutters', 'horizontalGutters'];

	public function initializeArguments(): void
	{
		parent::initializeArguments();
		$this->registerArgument('flexform', 'string', 'Flexform field');
		$this->registerArgument('cType', 'string', 'CType', false);
	}

	/**
	 * Parses the FlexForm XML and builds Bootstrap grid classes.
	 *
	 * @return array<string, mixed>
	 */
	public function render(): array
	{
		$classes = [
			'extraClassCols' => '',
			'rowClass' => [],
		];

		if (empty($this->arguments['flexform'])) {
			return $classes;
		}

		$flexconf = GeneralUtility::makeInstance(FlexFormService::class)
			->convertFlexFormContentToArray((string)$this->arguments['flexform']);

		$cType = (string)($this->arguments['cType'] ?? '');

		if ($cType === 'row_columns') {
			$classes = array_merge($classes, $this->buildRowColumnsClasses($flexconf));
		} else {
			$classes = array_merge($classes, $this->buildGridColumnsClasses($flexconf));
		}

		$classes['gutters'] = $this->buildGutterClasses($flexconf);
		$classes['extraClassRow'] = !empty($flexconf['row_extraClass'])
			? ' ' . trim((string)$flexconf['row_extraClass'])
			: '';
		$classes['containerClass'] = (string)($flexconf['containerWrapper'] ?? '');

		return $classes;
	}

	/**
	 * @param array<string, mixed> $flexconf
	 * @return array{extraClassCols: string, rowClass: array<int, string>}
	 */
	private function buildRowColumnsClasses(array $flexconf): array
	{
		$result = [
			'extraClassCols' => '',
			'rowClass' => [],
		];

		if (!empty($flexconf['cols_extraClass'])) {
			$result['extraClassCols'] = ' ' . trim((string)$flexconf['cols_extraClass']);
		}

		foreach (array_reverse($flexconf) as $key => $grid) {
			if (empty($grid) || !is_string($key)) {
				continue;
			}

			$parts = explode('_', $key);
			if (($parts[1] ?? '') !== 'rowclass') {
				continue;
			}

			foreach (self::BREAKPOINT_MAP as $bp => $idx) {
				if (str_starts_with($key, $bp . '_')) {
					$result['rowClass'][$idx] = '-' . (string)$grid;
					break;
				}
			}
		}

		return $result;
	}

	/**
	 * Build column classes (with breakpoint-specific col-xx-N entries
	 * plus optional extra classes) for the standard grid containers.
	 *
	 * @param array<string, mixed> $flexconf
	 * @return array<string, string>
	 */
	private function buildGridColumnsClasses(array $flexconf): array
	{
		$extraClass = array_fill_keys(
			array_map(static fn (string $pos): string => 'extraClass_' . $pos, self::COLUMN_POSITIONS),
			''
		);

		// Collect extra classes (relevant in both equalWidth and grid mode)
		foreach ($flexconf as $key => $value) {
			if (empty($value) || !is_string($key)) {
				continue;
			}
			if (str_starts_with($key, 'extraClass_')) {
				$extraClass[$key] = trim((string)$value);
			}
		}

		$isEqualWidth = !empty($flexconf['equalWidth']);
		$cols = array_fill_keys(self::COLUMN_POSITIONS, $isEqualWidth ? 'col' : '');

		if (!$isEqualWidth) {
			foreach (array_reverse($flexconf) as $key => $grid) {
				if (empty($grid) || !is_string($key)) {
					continue;
				}
				if (str_starts_with($key, 'extraClass_') || in_array($key, self::SKIP_KEYS, true)) {
					continue;
				}

				$position = $this->resolveColumnPosition($key);
				if ($position === null) {
					continue;
				}

				$cols[$position] .= ' ' . $this->buildColClass($key, $position, (string)$grid);
			}
		}

		return [
			'columnOne' => trim($cols['one'] . ' ' . $extraClass['extraClass_one']),
			'columnTwo' => trim($cols['two'] . ' ' . $extraClass['extraClass_two']),
			'columnThree' => trim($cols['three'] . ' ' . $extraClass['extraClass_three']),
			'columnFour' => trim($cols['four'] . ' ' . $extraClass['extraClass_four']),
			'columnFive' => trim($cols['five'] . ' ' . $extraClass['extraClass_five']),
			'columnSix' => trim($cols['six'] . ' ' . $extraClass['extraClass_six']),
		];
	}

	/**
	 * Find which column position a FlexForm key belongs to.
	 * Uses the length-sorted list so 'three'/'four'/'five' match before
	 * 'one'/'two'/'six' (defensive guard against suffix collisions).
	 */
	private function resolveColumnPosition(string $key): ?string
	{
		foreach (self::COLUMN_POSITIONS_BY_LENGTH as $position) {
			if (str_ends_with($key, '_' . $position)) {
				return $position;
			}
		}

		return null;
	}

	/**
	 * Build a Bootstrap col-* class for one grid setting.
	 * For the xs breakpoint, Bootstrap uses no suffix; for others use col-{bp}-{n}.
	 */
	private function buildColClass(string $key, string $position, string $grid): string
	{
		// The breakpoint prefix is everything before '_{position}'
		$breakpoint = substr($key, 0, -1 * (strlen($position) + 1));

		if ($breakpoint === 'xs') {
			return 'col-' . $grid;
		}

		return 'col-' . $breakpoint . '-' . $grid;
	}

	/**
	 * Build gutter classes; returns empty string if both default to Bootstrap defaults.
	 *
	 * @param array<string, mixed> $flexconf
	 */
	private function buildGutterClasses(array $flexconf): string
	{
		$horizontal = (string)($flexconf['horizontalGutters'] ?? '');
		$vertical = (string)($flexconf['verticalGutters'] ?? '');

		$horizontalPart = ($horizontal === '' || $horizontal === 'gx-4') ? '' : $horizontal;
		$verticalPart = ($vertical === '' || $vertical === 'gy-4') ? '' : $vertical;

		$combined = trim($horizontalPart . ' ' . $verticalPart);

		return $combined === '' ? '' : ' ' . $combined;
	}
}
