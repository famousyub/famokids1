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
 * @version 		$Id: upload.class.php 6949 2013-11-29 11:08:23Z phpFox LLC $
 */
class Attachment_Component_Block_Upload extends Phpfox_Component 
{
	/**
	 * Controller
	 */
	public function process()
	{
		$iMaxFileSize = (Phpfox::getUserParam('attachment.item_max_upload_size') === 0 ? null : (Phpfox::getUserParam('attachment.item_max_upload_size') * 1024));
		$iMaxFileSize = Phpfox_File::instance()->filesize($iMaxFileSize);
		$this->template()->assign(array(
				'bIsAllowed' => Phpfox::getService('attachment')->isAllowed(),
				'sCategoryId' => (PHPFOX_IS_AJAX ? $this->request()->get('category_id') : $this->getParam('sCategoryId')),
				'aValidExtensions' => Phpfox::getService('attachment.type')->getTypes(),
				'iMaxFileSize' => $iMaxFileSize,
				'sAttachmentInput' => $this->request()->get('input'),
				'sVideoFileExt' => '',
                'id'=>$this->request()->get('id'),
				'bIsAttachmentInline' => (bool) $this->request()->get('attachment_inline'),
				'sAttachmentObjId' => $this->request()->get('attachment_obj_id')
			)
		);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('attachment.component_block_upload_clean')) ? eval($sPlugin) : false);
	}
}