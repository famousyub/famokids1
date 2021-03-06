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
{add_script key='attach.js' value='module_link'}
<div class="js_preview_link_attachment_custom_add_parent">
	<div class="js_preview_link_attachment_custom_add">
		<div class="js_preview_link_attachment_custom_error"></div>
		<div class="table form-group">
			<div class="table_right">
				<input type="text" name="val[link][url]" value="http://" class="js_global_attach_value_custom global_link_input" onfocus="if (this.value == 'http://') {l} this.value = ''; {r}" onblur="if (this.value == '') {l} this.value = 'http://' {r}" />

				<div class="extra_info">
					{_p var='paste_a_link_you_would_like_to_attach'}
				</div>
			</div>
		</div>
		<div class="table_clear">
			<input type="button" value="{_p var='attach'}" onclick="$Core.attachmentLink(this);" class="global_link_input_button button btn_attach_link" />

			<span class="js_global_attach_link_ajax" class="v_middle" style="display:none; padding-left:4px;">{img theme='ajax/add.gif'}</span>
		</div>
	</div>
	<div class="js_preview_link_attachment_custom_holder" style="display:none;">
		<form method="post" action="#" onsubmit="return $Core.attachmentLinkAdd(this);">
			<div><input type="hidden" name="val[link][url]" value="" class="js_hidden_link_id" /></div>
			<div><input type="hidden" name="val[category_id]" value="{$sAttachCategory}" /></div>
			<div><input type="hidden" name="val[attachment_obj_id]" value="{$sAttachmentObjId}" /></div>
			{if $bIsAttachmentInline}
			<div><input type="hidden" name="val[attachment_inline]" value="true" /></div>
			{/if}
			<div class="js_preview_link_attachment_custom_form"></div>
			<div class="attachment_link_button"><input type="submit" onClick="$bIsAdded = false; $bIsPreview = false;" id="btn_submit_attach_link" value="{_p var='attach_link'}" class="button" /><span class="js_global_attach_link_ajax_add" class="v_middle" style="display:none; padding-left:4px;">{img theme='ajax/add.gif'}</span></div>
		</form>
	</div>
</div>