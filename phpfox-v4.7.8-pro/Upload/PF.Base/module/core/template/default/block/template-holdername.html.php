<?php 
/**
 * [PROWEBBER.ru - 2019]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		phpFox LLC
 * @package 		Phpfox
 * @version 		$Id: template-holdername.html.php 2817 2011-08-08 16:59:43Z phpFox LLC $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if defined('PHPFOX_IS_USER_PROFILE') || defined('PHPFOX_IS_PAGES_VIEW')}id="js_is_user_profile"{else}id="js_controller_{$sFullControllerName}"{/if}