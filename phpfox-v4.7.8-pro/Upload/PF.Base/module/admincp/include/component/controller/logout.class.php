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
 * @version 		$Id: logout.class.php 1629 2010-06-06 07:28:54Z phpFox LLC $
 */
class Admincp_Component_Controller_Logout extends Phpfox_Component
{
	/**
	 * Controller
	 */
	public function process()
	{
		if (!Phpfox::getParam('core.admincp_do_timeout'))
		{
			Phpfox::getService('user.auth')->logout();
			
			$this->url()->send('');	
		}
		
		Phpfox::getService('user.auth')->logoutAdmin();
		
		$this->url()->send('admincp', null, _p('successfully_logged_out'));
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('admincp.component_controller_logout_clean')) ? eval($sPlugin) : false);
	}
}