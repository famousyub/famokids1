<?php 
/**
 * [PROWEBBER.ru - 2019]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		phpFox LLC
 * @package 		Phpfox
 * @version 		$Id: $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{foreach from=$aNotifications name=notifications item=aNotification}
	{template file='notification.block.entry'}
{/foreach}