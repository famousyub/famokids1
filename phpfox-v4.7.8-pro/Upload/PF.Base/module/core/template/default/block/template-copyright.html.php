<?php
 
defined('PHPFOX') or exit('NO DICE!'); 

?>

{param var='core.site_copyright'} &middot; <a href="#" id="select_lang_pack">{if Phpfox::getParam('language.display_language_flag') && !empty($sLocaleFlagId)}<img src="{$sLocaleFlagId}" alt="{$sLocaleName}" class="v_middle" /> {/if}{$sLocaleName}</a>
{if (defined('PHPFOX_TRIAL_MODE'))}
&middot; Powered by phpFox
{/if}