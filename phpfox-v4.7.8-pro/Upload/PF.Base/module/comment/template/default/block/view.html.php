<?php 
/**
 * [PROWEBBER.ru - 2019]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		phpFox LLC
 * @package  		Module_Comment
 * @version 		$Id: view.html.php 1347 2009-12-22 18:10:30Z phpFox LLC $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<div class="main_break"></div>
<div id="js_comment_listing">
	<a name="comment-view"></a>
	<div id="js_new_comment" style="display:none;"></div>
	{if count($aRows)}	
	{parse_image width=500 height=400}
	{foreach from=$aRows item=aRow}
		{template file='comment.block.entry'}
	{/foreach}
	{parse_image clear=true}
	{if isset($bViewComment) && $bViewComment}
	{if $iTotalComments > 0}
	<a href="{url link='current' comment=0}" id="feed_view_more">{{_p var='view_all_comments_total' total=$iTotalComments}</a>
	{/if}
	{else}
	<div class="t_right p_top_8">
		{pager}
	</div>
	{/if}
	{else}
	<div id="js_no_comments" class="t_center">
		{if (!$bCanPostOnItem || !Phpfox::getUserParam('comment.can_post_comments')) && !Phpfox::getUserId()}
		{_p var='comments_must_login_signup' login=$sLoginLink register=$sSignupLink}
		{else}
		{if $bCanPostOnItem}
		{_p var='comments'}
		{else}
		{_p var='no_comments_added'}
		{/if}
		{/if}
		<br />
		<br />
	</div>
	{/if}
</div>