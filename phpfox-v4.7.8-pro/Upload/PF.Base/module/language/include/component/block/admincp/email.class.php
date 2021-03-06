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
 * @version 		$Id: form.class.php 1289 2009-12-02 16:13:11Z phpFox LLC $
 */
class Language_Component_Block_Admincp_Email extends Phpfox_Component
{
	/**
	 * Controller
	 */
	public function process()
	{
		$sLanguage = $this->request()->get('sLanguage');		

		$this->template()->assign(array(
				'sLanguage' => $sLanguage,
				'aPhrases' => []
			)
		);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('language.component_block_admincp_form_clean')) ? eval($sPlugin) : false);		
	}
}