<?php
/**
 * [PROWEBBER.ru - 2019]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * 
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		phpFox LLC
 * @package  		Module_Attachment
 * @version 		$Id: add.class.php 4444 2012-07-02 10:23:15Z phpFox LLC $
 */
class Attachment_Component_Block_Add extends Phpfox_Component 
{
	/**
	 * Controller
	 */
	public function process()
	{	
		$sCategoryId = (PHPFOX_IS_AJAX ? $this->request()->get('category_id') : $this->getParam('sCategoryId'));
		$sCached = $this->getParam('sAttachments');
		$attachment_custom = $this->getParam('attachment_custom');
		$iUserId = Phpfox::getUserId();
        $id =  $this->getParam('id');
		$aRows1 = array();
		$aRows2 = array();
		
		if ($sCategoryId == 'page')
		{
			if (Phpfox::getUserParam('page.can_manage_custom_pages'))
			{
				$iUserId = false;
			}
		}
		
		if ($iItemId = $this->getParam('iItemId'))
		{
			list($iCnt, $aRows1) = Phpfox::getService('attachment')->get(array("AND attachment.item_id = " . (int) $iItemId . " AND attachment.category_id = '" . Phpfox_Database::instance()->escape($sCategoryId) . "'" . ($iUserId !== false ?" AND attachment.user_id = " . $iUserId . "" : "") . ""));
		}		
			
		if (!empty($sCached))
		{			
			$sCacheQuery = '';
			$aParts = explode(',', $sCached);				
			foreach ($aParts as $iPart)
			{
				$iPart = trim($iPart);
				if (!is_numeric($iPart))
				{
					continue;
				}
					
				$sCacheQuery .= $iPart . ',';
			}
			$sCachedQuery = rtrim($sCacheQuery, ',');
			
			if (!empty($sCachedQuery))
			{
				list($iCnt, $aRows2) = Phpfox::getService('attachment')->get(array("AND attachment.attachment_id IN(" . $sCachedQuery . ") AND attachment.category_id = '" . Phpfox_Database::instance()->escape($sCategoryId) . "'" . ($iUserId !== false ?" AND attachment.user_id = " . $iUserId . "" : "") . ""));
			}
		}

		$aRows = array_merge($aRows1, $aRows2);
		
		if (isset($aRows))
		{
			$sAttachments = '';
			foreach ($aRows as $aRow)
			{
				$sAttachments .= $aRow['attachment_id'] . ',';
			}		
		}

		if (!empty($sAttachments))
		{
			$this->template()->assign(array(
					'sAttachments' => rtrim($sAttachments, ',')
				)
			);
		}		

		if ($this->getParam('bFixToken'))
		{
			$this->template()->assign(array('bFixToken' => true));
		}		
		
		$this->template()->assign(array(
				'sCategoryId' => $sCategoryId,
				'sAttachmentInput' => $this->request()->get('input'),
				'sCustomAttachment' => $this->request()->get('attachment_custom'),
				'attachment_custom' => $attachment_custom,
                'id'=>$id,
			)
		);		
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('attachment.component_block_add_clean')) ? eval($sPlugin) : false);
	}
}