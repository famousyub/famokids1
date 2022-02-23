<?php 
/**
 * [PROWEBBER.ru - 2019]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		phpFox LLC
 * @package 		Phpfox
 * @version 		$Id: share.html.php 7024 2014-01-07 14:54:37Z Fern $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<script type="text/javascript">
{literal}
	function sendFeed(oObj)
	{
		$('#btnShareFeed').attr('disabled', 'disabled');
		$('#imgShareFeedLoading').show();
		$(oObj).ajaxCall('feed.share');
		
		return false;
	}
{/literal}
</script>
<div class="activity_feed_share_form">
	<form class="form" method="post" action="#" onsubmit="return sendFeed(this);">
		<div><input type="hidden" name="val[parent_feed_id]" value="{$iFeedId}" /></div>
		<div><input type="hidden" name="val[parent_module_id]" value="{$sShareModule|clean}" /></div>
		<select class="form-control" name="val[post_type]" onchange="if (this.value == '1') {l} $('#js_feed_share_friend_holder').hide(); $('#js_feed_share_privacy_button').show(); {r} else {l} $('#js_feed_share_friend_holder').show(); $('#js_feed_share_privacy_button').hide(); {r}">
			<option value="1">{_p var='on_your_wall'}</option>
			<option value="2">{_p var='on_a_friend_s_wall'}</option>
		</select>
		<div class="p_top_8" id="js_feed_share_friend_holder" style="display:none;">
            {module name='friend.search-small' input_name='val[friends]'}
		</div>
		<div class="p_top_8">
			<textarea class="form-control" rows="4" name="val[post_content]"></textarea>
            {if isset($bLoadTagFriends) && $bLoadTagFriends == true}
                <script type="text/javascript">
                  oTranslations['with_name_and_name'] = "{_p var='with_name_and_name'}";
                  oTranslations['with_name'] = "{_p var='with_name'}";
                  oTranslations['with_name_and_number_others'] = "{_p var='with_name_and_number_others'}";
                  oTranslations['number_others'] = "{_p var='number_others'}";
                </script>
                <div class="js_tagged_review"></div>
            {/if}
            {if isset($bLoadTagFriends) && $bLoadTagFriends == true}
                {template file='feed.block.tagged'}
            {/if}
            {if isset($bLoadCheckIn) && $bLoadCheckIn == true}
                <script type="text/javascript">
                  oTranslations['at_location'] = "{_p var='at_location'}";
                </script>
                <div id="js_location_feedback" class="js_location_feedback">
                    {if !empty($aForms.location_name) }
                        {_p var='at_location' location=$aForms.location_name}
                    {/if}
                </div>
            {/if}
		</div>
        {if isset($bLoadCheckIn) && $bLoadCheckIn == true}
            <div id="js_location_input">
                <a class="btn btn-danger" href="#" onclick="$Core.Feed.cancelCheckIn(); return false;"><i class="fa fa-times"></i></a>
                <input type="text" id="hdn_location_name" {if !empty($aForms.location_name) }value="{$aForms.location_name}"{/if} autocomplete="off">
            </div>
        {/if}
        <div class="activity_feed_share_form_button_position">
            <div id="activity_feed_share_this_one" class="activity_feed_checkin">
                {assign var=iFeedId value=0}
                {if isset($bLoadTagFriends) && $bLoadTagFriends == true}
                    {template file='feed.block.with-friend'}
                {/if}
                {if isset($bLoadCheckIn) && $bLoadCheckIn == true}
                    {template file='feed.block.checkin'}
                {/if}
            </div>
            <div class="activity_feed_share_form_button_position_button">
                <input type="submit" id="btnShareFeed" value="{_p var='post'}" class="btn btn-primary" />
                {img theme='ajax/small.gif' style="display:none" id="imgShareFeedLoading"}
            </div>
            <div id="js_feed_share_privacy_button">
                {module name='privacy.form' privacy_name='privacy' privacy_type='mini' btn_size='normal' default_privacy='feed.default_privacy_setting'}
            </div>
        </div>
	</form>
</div>
<script type="text/javascript">
	$Core.loadInit();
</script>