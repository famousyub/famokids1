<?php 
/**
 * [PROWEBBER.ru - 2019]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		phpFox LLC
 * @package 		Phpfox
 * @version 		$Id: link.html.php 6238 2013-07-12 09:44:30Z phpFox LLC $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if count($aNotifications)}
	<ul id="js_new_notification_holder_drop">
		{foreach from=$aNotifications name=notifications item=aNotification}
			<li id="js_notification_read_{$aNotification.notification_id}" class="holder_notify_drop_data{if $phpfox.iteration.notifications == 1} first{/if}"><a href="{$aNotification.link}" class="main_link{if !$aNotification.is_seen} is_new{/if}">
					<div class="drop_data_image">
                        {if !isset($aNotification.no_profile_image)}
                            {img user=$aNotification max_width='50' max_height='50' suffix='_50_square' no_link=true}
                        {/if}
					</div>
					<div class="drop_data_content">
							{$aNotification.message}
						<div class="drop_data_time">
						{$aNotification.time_stamp|convert_time}
						</div>
					</div>
					<div class="clear"></div>
				</a>
			</li>
		{/foreach}
	</ul>
	{literal}
		<script type="text/javascript">
            $Behavior.initNotifications = function() {
                var $iTotalNotifications = parseInt($('#js_total_new_notifications').html());
                var $iNewTotalNotifications = 0;
                $('#js_new_notification_holder_drop li').each(function () {
                    $iNewTotalNotifications++;
                    $aNotificationOldHistory[$(this).attr('id').replace('js_notification_read_', '')] = true;
                });

                $iTotalNotifications = parseInt(($iTotalNotifications - $iNewTotalNotifications));
                if ($iTotalNotifications < 0) {
                    $iTotalNotifications = 0;
                }

                if ($iTotalNotifications === 0) {
                    $('span#js_total_new_notifications').html('').hide();
                } else {
                    $('span#js_total_new_notifications').html($iTotalNotifications);
                }
            }
		</script>
	{/literal}
{else}
<div class="drop_data_empty">
	{_p var='no_new_notifications'}
</div>
{/if}
<a href="{url link='notification'}" class="holder_notify_drop_link">{_p var='see_all_notifications'}</a>