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
class Notification_Component_Block_Feed extends Phpfox_Component
{
	/**
	 * Controller
	 */
	public function process()
	{		
		if (!Phpfox::isUser())
		{
			return false;
		}
		
		$aNotifications = Phpfox::getService('notification')->get();
		
		if (!count($aNotifications))
		{
			return false;
		}

		$this->template()->assign(array(
				'sHeader' => _p('notifications'),
				'aNotifications' => $aNotifications,
				'bNotifyIsInline' => false
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
		(($sPlugin = Phpfox_Plugin::get('notification.component_block_feed_clean')) ? eval($sPlugin) : false);
	}
	
	public function widget()
	{
		return true;
	}
}