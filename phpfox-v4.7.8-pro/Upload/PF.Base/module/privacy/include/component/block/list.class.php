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
 * @package  		Module_Privacy
 * @version 		$Id: list.class.php 225 2009-02-13 13:24:59Z phpFox LLC $
 */
class Privacy_Component_Block_List extends Phpfox_Component
{
	/**
	 * Controller
	 */
	public function process()
	{
		$aUsers = array();
		if ($this->getParam('id'))
		{
			$aUsers = Phpfox::getService('privacy')->get($this->getParam('type'), $this->getParam('id'));
		}
		
		$this->template()->assign(array(
				'aPrivacyUsers' => $aUsers,
				'sPrivacyInputName' => $this->getParam('input')
			)
		);		
	}
	 
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('privacy.component_block_list_clean')) ? eval($sPlugin) : false);
	}
}