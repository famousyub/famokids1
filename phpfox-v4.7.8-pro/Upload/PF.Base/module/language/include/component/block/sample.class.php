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
 * @version 		$Id: sample.class.php 1297 2009-12-04 23:18:17Z phpFox LLC $
 */
class Language_Component_Block_Sample extends Phpfox_Component
{
	/**
	 * Controller
	 */
	public function process()
	{
		$this->template()->assign(array(
				'sCachePhrase' => $this->request()->get('phrase')
			)
		);	
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('language.component_block_sample_clean')) ? eval($sPlugin) : false);
	}
}