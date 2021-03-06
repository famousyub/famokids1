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
 * @version 		$Id: add.class.php 2000 2010-10-29 11:24:24Z phpFox LLC $
 */
class Admincp_Component_Controller_Privacy_Index extends Phpfox_Component
{
	/**
	 * Controller
	 */
	public function process()
	{
		if (($iDeleteId = $this->request()->getInt('delete')) && Phpfox::getService('admincp.process')->deletePrivacyRule($iDeleteId))
		{
			$this->url()->send('admincp.privacy', array(), 'Successfully deleted this rule.');
		}
		
		if (($aVals = $this->request()->getArray('val')))
		{
			if (Phpfox::getService('admincp.process')->addNewPrivacyRule($aVals))
			{
				$this->url()->send('admincp.privacy', array(), 'Successfully added a new rule.');	
			}
		}
		
		$this->template()
            ->setTitle(_p('admincp_priacy_control'))
			->setBreadCrumb(_p('admincp_priacy_control'))
			->assign(array(
					'aUserGroups' => Phpfox::getService('user.group')->get(),
					'aRules' => Phpfox::getService('admincp')->getAdmincpRules()
				)
			);
	}
}