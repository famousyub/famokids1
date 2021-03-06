<?php
/**
 * [PROWEBBER.ru - 2019]
 */

defined('PHPFOX') or exit('NO DICE!');

class Core_Component_Block_New_Setting extends Phpfox_Component
{
	/**
	 * Controller
	 */
	public function process()
	{
		$this->template()->assign(array(
				'aModuleItems' => Phpfox::getService('core')->getNewMenu(true)
			)
		);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('core.component_block_new_setting_clean')) ? eval($sPlugin) : false);
	}
}