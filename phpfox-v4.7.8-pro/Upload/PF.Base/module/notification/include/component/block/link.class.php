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
 * @version 		$Id: link.class.php 2279 2011-01-25 19:40:27Z phpFox LLC $
 */
class Notification_Component_Block_Link extends Phpfox_Component
{	
	/**
	 * Controller
	 */
	public function process()
	{		
		$this->template()->assign(array(
				'aNotifications' => Phpfox::getService('notification')->get()
			)
		);		
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('notification.component_block_link_clean')) ? eval($sPlugin) : false);
	}
}