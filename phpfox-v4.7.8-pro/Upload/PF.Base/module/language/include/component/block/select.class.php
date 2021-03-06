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
class Language_Component_Block_Select extends Phpfox_Component
{
	/**
	 * Controller
	 */
	public function process()
	{
		$aLanguages = Phpfox::getService('language')->get(array('l.user_select = 1'));
		
		$this->template()->assign(array(
				'aLanguages' => $aLanguages
			)
		);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('language.component_block_select_clean')) ? eval($sPlugin) : false);
	}
}