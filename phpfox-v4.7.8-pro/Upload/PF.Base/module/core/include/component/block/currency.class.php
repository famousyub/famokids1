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
 * @version 		$Id: currency.class.php 1559 2010-05-04 13:06:56Z phpFox LLC $
 */
class Core_Component_Block_Currency extends Phpfox_Component
{
	/**
	 * Controller
	 */
	public function process()
	{
        $aCurrencyValues = $this->getParam('currency_value_' . $this->getParam('currency_field_name'));
        if(empty($aCurrencyValues)){
            $aCurrencyValues =  $this->getParam('value_actual');
        }
		$aCurrencies = Phpfox::getService('core.currency')->get();

		foreach ($aCurrencies as $sKey => $aCurrency)
		{
			if (isset($aCurrencyValues[$sKey]))
			{
				$aCurrencies[$sKey]['value'] = $aCurrencyValues[$sKey];
			}
		}

		$this->template()->assign(array(
				'aCurrencies' => $aCurrencies,
				'sCurrencyFieldName' => $this->getParam('currency_field_name'),
				'aCurrencyValues' => $aCurrencyValues
			)
		);
	}

	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('core.component_block_currency_clean')) ? eval($sPlugin) : false);
	}
}