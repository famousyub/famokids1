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
 * @version 		$Id: ajax.class.php 225 2009-02-13 13:24:59Z phpFox LLC $
 */
class Admincp_Component_Ajax_Module_Ajax extends Phpfox_Ajax
{
	public function deleteMenu()
	{
		Phpfox::isUser(true);
		Phpfox::getUserParam('language.can_manage_lang_packs', true);
		
		if (Phpfox::getService('admincp.module.process')->deleteMenu($this->get('id'), $this->get('var')))
		{
			$this->call("$('#jsmenu_" . $this->get('var') . "').hide();");
		}
	}
}