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
 * @package  		Module_Admincp
 * @version 		$Id: add.class.php 1931 2010-10-25 11:58:06Z phpFox LLC $
 */
class Admincp_Component_Controller_Setting_Group_Add extends Phpfox_Component 
{
	/**
	 * Controller
	 */
	public function process()
	{		
		$aValidation = array(
			'var_name' => _p('add_a_title_for_the_group'),
			'info' => _p('add_information_regarding_group')
		);		
		
		$oValid = Phpfox_Validator::instance()->set(array('sFormName' => 'js_setting_form', 'aParams' => $aValidation));
		
		if ($aVals = $this->request()->getArray('val'))
		{			
			if ($oValid->isValid($aVals))
			{
				if ($sVarName = Phpfox::getService('admincp.setting.group.process')->add($aVals))
				{
					$this->url()->send('admincp.setting.group.add', null, _p('added') . ': ' . $sVarName);
				}
			}
		}		
		
		$this->template()->setBreadCrumb(_p('add_setting_group'))
			->setTitle(_p('add_setting_group'))
			->assign(array(
				'aProducts' => Phpfox::getService('admincp.product')->get(),
				'sCreateJs' => $oValid->createJS(),
				'sGetJsForm' => $oValid->getJsForm(),
				'aModules' => Phpfox_Module::instance()->getModules()
			)
		);
			
		(($sPlugin = Phpfox_Plugin::get('admincp.component_controller_setting_group_add_process')) ? eval($sPlugin) : false);		
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('admincp.component_controller_setting_group_add_clean')) ? eval($sPlugin) : false);
	}
}