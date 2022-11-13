<?php
declare(strict_types=1);

namespace T3S\T3sbootstrapGrid\Backend\Preview;

/*
 * This file is part of the TYPO3 extension t3sbootstrap_grid.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use B13\Container\Backend\Grid\ContainerGridColumn;
use B13\Container\Backend\Grid\ContainerGridColumnItem;
use B13\Container\Domain\Factory\Exception;
use B13\Container\Domain\Factory\PageView\Backend\ContainerFactory;
use B13\Container\Tca\Registry;
use B13\Container\ContentDefender\ContainerColumnConfigurationService;
use B13\Container\Domain\Service\ContainerService;
use TYPO3\CMS\Backend\Preview\StandardContentPreviewRenderer;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Backend\View\BackendLayout\Grid\Grid;
use TYPO3\CMS\Backend\View\BackendLayout\Grid\GridColumnItem;
use TYPO3\CMS\Backend\View\BackendLayout\Grid\GridRow;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\View\StandaloneView;
use TYPO3\CMS\Core\Service\FlexFormService;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Information\Typo3Version;


class T3sGridPreviewRenderer extends StandardContentPreviewRenderer
{

	/**
	* @var Registry
	*/
	protected $tcaRegistry;

	/**
	* @var ContainerFactory
	*/
	protected $containerFactory;

	/**
        * @var ContainerColumnConfigurationService
        */
    	protected $containerColumnConfigurationService;

        /**
        * @var ContainerService
     	*/
    	protected $containerService;

	
	public function __construct(
		Registry $tcaRegistry,
		ContainerFactory $containerFactory,
		ContainerColumnConfigurationService $containerColumnConfigurationService,
		ContainerService $containerService
	)
	{
		$this->tcaRegistry = $tcaRegistry;
		$this->containerFactory = $containerFactory;
		$this->containerColumnConfigurationService = $containerColumnConfigurationService;
		$this->containerService = $containerService;
	}


	/**
	* Dedicated method for rendering preview header HTML for
	* the page module only. Receives $item which is an instance of
	* GridColumnItem which has a getter method to return the record.
	*
	* @param GridColumnItem
	*/
	public function renderPageModulePreviewHeader(GridColumnItem $item): string
	{
		$record = $item->getRecord();
		$itemLabels = $item->getContext()->getItemLabels();
		$outHeader = '';

		$flexformService = GeneralUtility::makeInstance(FlexFormService::class);
		$flexconf = $flexformService->convertFlexFormContentToArray($record['tx_t3sbootstrap_grid_flexform']);

		if ($record['header']) {
			$infoArr = [];
			$this->getProcessedValue($item, 'header_position,header_layout,header_link', $infoArr);
			$hiddenHeaderNote = '';
			// If header layout is set to 'hidden', display an accordant note:
			if ($record['header_layout'] == 100) {
				$hiddenHeaderNote = ' <em>[' . htmlspecialchars($this->getLanguageService()
				->sL('LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:header_layout.I.6')) . ']</em>';
			}
			$outHeader = $record['date']
				? htmlspecialchars($itemLabels['date'] . ' ' . BackendUtility::date($record['date'])) . '<br />'
				: '';
			$outHeader .= '<strong>' . $this->linkEditContent($this->renderText($record['header']), $record)
				. $hiddenHeaderNote . '</strong><br />';
		}

		if ($record['subheader']) {
			$outHeader .= parent::linkEditContent(parent::renderText($record['subheader']), $record) . '<br />';
		}

		$info = '';
		$contentTypeLabels = $item->getContext()->getContentTypeLabels();
		$contentType = $contentTypeLabels[$record['CType']];

		switch ($record['CType']) {
			case 'tabs_tab':
			 	$info = '<div style="padding:5px; background-color:rgba(86, 61, 124, .5); color:#fff; margin-bottom:5px" >'.$contentType.'</div>';
				break;
			case 'collapsible_accordion':
			 	$info = '<div style="padding:5px; background-color:rgba(86, 61, 124, .5); color:#fff; margin-bottom:5px" >'.$contentType.'</div>';
				break;
			default:
				$info = '<div style="padding:5px; background-color:#563d7c; color:#fff; margin-bottom:5px" >'.$contentType.'</div>';
		}

		return $info.$outHeader;
	}


	public function renderPageModulePreviewContent(GridColumnItem $item): string
	{
		$typo3Version = new Typo3Version();

		$content = parent::renderPageModulePreviewContent($item);
		$context = $item->getContext();
		$record = $item->getRecord();
		$grid = GeneralUtility::makeInstance(Grid::class, $context);
		try {
			$container = $this->containerFactory->buildContainer((int)$record['uid']);
		} catch (Exception $e) {
			// not a container
			return $content;
		}

		$flexformService = GeneralUtility::makeInstance(FlexFormService::class);
		$flexconf = $flexformService->convertFlexFormContentToArray($record['tx_t3sbootstrap_grid_flexform']);
		$out = '';

		if ($record['CType'] == 'two_columns' || $record['CType'] == 'three_columns' || $record['CType'] == 'four_columns'
		 || $record['CType'] == 'six_columns' || $record['CType'] == 'row_columns') {

		 	if ($record['CType'] != 'row_columns') {
					if ( $flexconf['equalWidth'] ) {
					$out .= '<br />- Equal Width';
				}
			}
   			if ( $flexconf['horizontalGutters'] != 'gx-4' ) {
				$out .= '<br />- Horizontal gutters: '.$flexconf['horizontalGutters'];
			}
   			if ( $flexconf['verticalGutters'] != 'gy-4') {
				$out .= '<br />- Vertical gutters: '.$flexconf['verticalGutters'];
			}

			if ($record['CType'] == 'row_columns') {
				if ($flexconf['xs_rowclass']) {
					$out .= '<br />- row-cols-*: '.$flexconf['xs_rowclass'];
				}
				if ($flexconf['sm_rowclass']) {
					$out .= '<br />- row-cols-sm: '.$flexconf['sm_rowclass'];
				}
				if ($flexconf['md_rowclass']) {
					$out .= '<br />- row-cols-md: '.$flexconf['md_rowclass'];
				}
				if ($flexconf['lg_rowclass']) {
					$out .= '<br />- row-cols-lg: '.$flexconf['lg_rowclass'];
				}
				if ($flexconf['xl_rowclass']) {
					$out .= '<br />- row-cols-xl: '.$flexconf['xl_rowclass'];
				}
				if ($flexconf['xxl_rowclass']) {
					$out .= '<br />- row-cols-xxl: '.$flexconf['xxl_rowclass'];
				}
			}
		}

		$flexconfOut = '';
		if ($out)
		$flexconfOut .= parent::linkEditContent('<div>'.substr($out, 6).'</div>', $record);

		$containerGrid = $this->tcaRegistry->getGrid($record['CType']);

		foreach ($containerGrid as $row => $cols) {
			$rowObject = GeneralUtility::makeInstance(GridRow::class, $context);
			foreach ($cols as $col) {
				$newContentElementAtTopTarget = $this->containerService->getNewContentElementAtTopTargetInColumn($container, $col['colPos']);

                		if ($this->containerColumnConfigurationService->isMaxitemsReached($container, $col['colPos'])) {
                    			$columnObject = GeneralUtility::makeInstance(ContainerGridColumn::class, $context, $col, $container, $newContentElementAtTopTarget, false);
                		} else {
                 		   $columnObject = GeneralUtility::makeInstance(ContainerGridColumn::class, $context, $col, $container, $newContentElementAtTopTarget);
            		        }
			
				$rowObject->addColumn($columnObject);
				if (isset($col['colPos'])) {
					$records = $container->getChildrenByColPos($col['colPos']);
					foreach ($records as $contentRecord) {
						$columnItem = GeneralUtility::makeInstance(ContainerGridColumnItem::class, $context, $columnObject, $contentRecord, $container);
						$columnObject->addItem($columnItem);
					}
				}
			}
			$grid->addRow($rowObject);
		}

		$gridTemplate = $this->tcaRegistry->getGridTemplate($record['CType']);

		$view = GeneralUtility::makeInstance(StandaloneView::class);
		$view->setPartialRootPaths(['EXT:backend/Resources/Private/Partials/', 'EXT:container/Resources/Private/Partials/']);
		$view->setTemplatePathAndFilename($gridTemplate);

		$view->assign('hideRestrictedColumns', (bool)(BackendUtility::getPagesTSconfig($context->getPageId())['mod.']['web_layout.']['hideRestrictedCols'] ?? false));
		$view->assign('newContentTitle', $this->getLanguageService()->getLL('newContentElement'));
		$view->assign('newContentTitleShort', $this->getLanguageService()->getLL('content'));
		$view->assign('allowEditContent', $this->getBackendUser()->check('tables_modify', 'tt_content'));
		$view->assign('containerGrid', $grid);
		$view->assign('defaultRecordDirectory', $this->hasDefaultDirectory() ? 'RecordDefault' : 'Record');

		$rendered = $view->render();

		$typo3Version = new Typo3Version();
		$show = $typo3Version->getMajorVersion() == 10 ? 'in' : 'show';

		$newContent = '<p style="margin-top:8px;margin-left:5px">
		<a data-toggle="collapse" href="#collapseContainer-'.$record['uid'].'" role="button" aria-expanded="true" aria-controls="collapseContainer-'.$record['uid'].'">
		</a></p><div class="collapse '.$show.'" id="collapseContainer-'.$record['uid'].'"><div class="card card-body p-3">'.$rendered.'</div></div>';

		return $flexconfOut.$newContent;
	}


	/**
	 * Dedicated method for wrapping a preview header and body HTML.
	 *
	 * @param string $previewHeader
	 * @param string $previewContent
	 */
	public function wrapPageModulePreview($previewHeader, $previewContent, GridColumnItem $item): string
	{
			$content = '<span class="exampleContent" style="background-color: rgba(86, 61, 124, .1); display: block; padding:5px">'
			 . $previewHeader . $previewContent . '</span>';
			if ($item->isDisabled()) {
				 return '<span class="text-muted">' . $content . '</span>';
			 }

			 return $content;
	}


	/**
	 * Check TYPO3 version to see whether the default record templates
	 * are located in RecordDefault/ instead of Record/.
	 * See: https://review.typo3.org/c/Packages/TYPO3.CMS/+/69769
	 */
	protected function hasDefaultDirectory(): bool
	{
		$typo3Version = new Typo3Version();

		if ($typo3Version->getMajorVersion() === 10) {
			return version_compare((new Typo3Version())->getVersion(), '10.4.17', '>');
		}

		if ($typo3Version->getMajorVersion() === 11) {
			return version_compare((new Typo3Version())->getVersion(), '11.3.0', '>');
		}

		return false;
	}

}
