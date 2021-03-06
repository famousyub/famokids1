<?php
/**
 * [PROWEBBER.ru - 2019]
 */

defined('PHPFOX') or exit('NO DICE!');
define('PHPFOX_SKIP_POST_PROTECTION', true);
/**
 * 
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Miguel Espinoza
 * @package 		Phpfox_Component
 * @version 		$Id: controller.class.php 103 2009-01-27 11:32:36Z phpFox LLC $
 */
class Friend_Component_Controller_Invoice extends Phpfox_Component
{
	/**
	 * Controller
	 */
	public function process()
	{
		if (($sId = $this->request()->get('item_number')) != '')
		{
		    $this->url()->send('friend.invoice',array(),_p('thank_you_for_your_purchase'));
		}
		
		$aInvoices = (Phpfox::isAppActive('Core_eGifts') ? Phpfox::getService('egift')->getSentEcards(Phpfox::getUserId ()) : array());


		$this->template()->setTitle(_p('invoices'))
			->setBreadCrumb(_p('friend'), $this->url()->makeUrl('friend'))
			->setBreadCrumb(_p('invoices'), $this->url()->makeUrl('friend.invoice'), true)
			->assign(array(
					'aInvoices' => $aInvoices
				)
			);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('egift.component_controller_index_clean')) ? eval($sPlugin) : false);
	}
}