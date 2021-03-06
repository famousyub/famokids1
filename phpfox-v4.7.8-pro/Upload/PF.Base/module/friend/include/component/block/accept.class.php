<?php
/**
 * [PROWEBBER.ru - 2019]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * Displays requests that need to either need to be approved or denied.
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		phpFox LLC
 * @package  		Module_Friend
 * @version 		$Id: accept.class.php 2632 2011-05-26 19:28:02Z phpFox LLC $
 */
class Friend_Component_Block_Accept extends Phpfox_Component
{
	/**
	 * Controller
	 */
	public function process()
	{
		list($iCnt, $aFriends) = Phpfox::getService('friend.request')->get();
		
		$this->template()->assign(array(
				'aFriends' => $aFriends
			)
		);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('friend.component_block_accept_clean')) ? eval($sPlugin) : false);
	}
}