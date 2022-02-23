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
 * @package  		Module_Invite
 * @version 		$Id: find.class.php 1161 2009-10-09 07:42:41Z phpFox LLC $
 */
class Invite_Component_Block_Find extends Phpfox_Component
{
	/**
	 * Controller
	 */
	public function process()
	{
		$this->template()->assign(array(
				'sHeader' => _p('find_friends'),
				'aRandomUsers' => Phpfox::getService('user')->getRandom()
			)
		);
		
		return 'block';
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('invite.component_controller_index_clean')) ? eval($sPlugin) : false);
	}
}