<?php 
/**
 * [PROWEBBER.ru - 2019]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		phpFox LLC
 * @package 		Phpfox
 * @version 		$Id: controller.html.php 64 2009-01-19 15:05:54Z phpFox LLC $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{template file='friend.block.accept'}
{if count($aFriends)}
{moderation}
{pager}
{/if}