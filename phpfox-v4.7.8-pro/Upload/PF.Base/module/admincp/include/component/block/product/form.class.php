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
 * @version 		$Id: form.class.php 798 2009-07-23 20:07:08Z phpFox LLC $
 */
class Admincp_Component_Block_Product_Form extends Phpfox_Component
{
	/**
	 * Controller
	 */
	public function process()
	{
		$this->template()->assign(array(
				'aProducts' => Phpfox::getService('admincp.product')->get(),
				'bUseClass' => $this->getParam('class'),
				'bProductIsRequired' => $this->getParam('product_form_required', true)
			)
		);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('admincp.component_block_product_form_clean')) ? eval($sPlugin) : false);
	}
}