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
 * @package  		Module_Theme
 * @version 		$Id: sample.class.php 3322 2011-10-20 07:19:13Z phpFox LLC $
 */
class Theme_Component_Controller_Sample extends Phpfox_Component 
{
	public function process()
	{
		Phpfox::isAdmin(true);
		$this->template()->bIsSample = true;
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('theme.component_controller_sample_clean')) ? eval($sPlugin) : false);
	}	
}