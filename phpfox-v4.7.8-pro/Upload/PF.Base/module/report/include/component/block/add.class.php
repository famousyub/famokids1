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
 * @package  		Module_Report
 * @version 		$Id: add.class.php 1179 2009-10-12 13:56:40Z phpFox LLC $
 */
class Report_Component_Block_Add extends Phpfox_Component 
{
	/**
	 * Controller
	 */
	public function process()
	{	
		Phpfox::isUser(true);
		
		$oReport = Phpfox::getService('report');
		$sType = $this->getParam('sType');
		$iItemId = $this->getParam('iItemId');		
		$bCanReport = $oReport->canReport($sType, $iItemId);
		
		$this->template()->assign(array(
				'aOptions' => ($bCanReport ? $oReport->getOptions($sType) : null),
				'sType' => $sType,
				'iItemId' => $iItemId,
				'bCanReport' => $bCanReport,
				'sTermsUrl' => $this->url()->makeUrl('terms')
			)
		);
	}
}