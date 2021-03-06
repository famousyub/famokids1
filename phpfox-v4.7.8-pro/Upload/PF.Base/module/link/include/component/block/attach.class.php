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
 * @package 		Phpfox_Component
 * @version 		$Id: block.class.php 103 2009-01-27 11:32:36Z phpFox LLC $
 */
class Link_Component_Block_Attach extends Phpfox_Component
{
	/**
	 * Controller
	 */
	public function process()
	{
		Phpfox::isUser(true);	
		
		$this->template()->assign(array(
				'sAttachCategory' => $this->request()->get('category_id'),
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
		(($sPlugin = Phpfox_Plugin::get('link.component_block_attach_clean')) ? eval($sPlugin) : false);
	}
}