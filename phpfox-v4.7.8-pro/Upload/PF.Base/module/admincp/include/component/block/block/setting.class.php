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
 * @version 		$Id: setting.class.php 2228 2010-12-02 21:02:59Z phpFox LLC $
 */
class Admincp_Component_Block_Block_Setting extends Phpfox_Component
{
	/**
	 * Controller
	 */
	public function process()
	{
		$aSubBlocks = Phpfox::getService('admincp.block')->get($this->request()->get('m_connection'), $this->request()->get('style_id', 0));
		$aModules = array();
		foreach ($aSubBlocks as $iKey => $aRow)
		{
			$aModules[$aRow['location']][] = $aRow;
		}		
		
		$this->template()->assign(array(
				'aModules' => $aModules,
				'sConnection' => $this->request()->get('m_connection'),
				'iStyleId' => $this->request()->get('style_id', 0)
			)
		);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('admincp.component_block_block_setting_clean')) ? eval($sPlugin) : false);
	}
}