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
 * @version 		$Id: ajax.class.php 852 2009-08-10 18:05:32Z phpFox LLC $
 */
class Admincp_Component_Ajax_Maintain_Ajax extends Phpfox_Ajax
{	
	public function cacheView()
	{
		if (!Phpfox::isUser())
		{
			exit;
		}
		
		if (!Phpfox::getUserParam('admincp.can_clear_site_cache'))
		{
			exit;
		}		
		
		$mData = Phpfox::getLib('cache')->getData($this->get('cache_id'));
		
		if ($mData === false)
		{
			return false;
		}
		
		highlight_string('<?php ' . $mData . ' ?>');

        return null;
	}
}