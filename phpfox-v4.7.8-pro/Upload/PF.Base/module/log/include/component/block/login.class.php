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
 * @version 		$Id: login.class.php 3248 2011-10-07 12:29:57Z phpFox LLC $
 */
class Log_Component_Block_Login extends Phpfox_Component
{
	/**
	 * Controller
	 */
	public function process()
	{
		$aUsers = Phpfox::getService('log')->getRecentLoggedInUsers();
		
		if (!count($aUsers))
		{
			return false;
		}
		
		$this->template()->assign(array(
				'sHeader' => _p('recent_logins'),
				'aLoggedInUsers' => $aUsers,
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
		$this->template()->clean(array(
				'sHeader',
				'aLoggedInUsers'
			)
		);
	
		(($sPlugin = Phpfox_Plugin::get('log.component_block_login_clean')) ? eval($sPlugin) : false);
	}
}