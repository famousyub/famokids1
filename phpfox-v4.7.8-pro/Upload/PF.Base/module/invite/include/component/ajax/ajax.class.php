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
 * @package  		Module_Invite
 * @version 		$Id: ajax.class.php 3342 2011-10-21 12:59:32Z phpFox LLC $
 */
class Invite_Component_Ajax_Ajax extends Phpfox_Ajax
{
	public function moderation()
	{
		Phpfox::isUser(true);
		
		$aInvite = $this->get('item_moderate');
		if (is_array($aInvite) && count($aInvite))
		{
			foreach ($aInvite as $iInvite)
			{
				Phpfox::getService('invite.process')->delete($iInvite, Phpfox::getUserId());
				$this->remove('#js_invite_' . $iInvite);	
			}			
		}
		
		$this->alert(_p('successfully_removed_invites'), _p('moderation'), 300, 150, true);
		$this->hide('.moderation_process');				
	}
}