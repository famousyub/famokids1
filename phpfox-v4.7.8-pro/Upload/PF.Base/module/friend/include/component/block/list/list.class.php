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
 * @package  		Module_Friend
 * @version 		$Id: list.class.php 2621 2011-05-22 20:09:22Z phpFox LLC $
 */
class Friend_Component_Block_List extends Phpfox_Component
{
	/**
	 * Controller
	 */
	public function process()
	{		
		$aLists = Phpfox::getService('friend.list')->get();
		
		$this->template()->assign(array(
				'aLists' => $aLists
			)
		);	
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('friend.component_block_list_clean')) ? eval($sPlugin) : false);
	}
}