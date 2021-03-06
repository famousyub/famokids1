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
 * @package  		Module_Friend
 * @version 		$Id: top.class.php 1135 2009-10-05 12:59:10Z phpFox LLC $
 */
class Friend_Component_Block_Remove extends Phpfox_Component
{
	/**
	 * Controller
	 */
	public function process()
	{
		if (!defined('PHPFOX_IS_USER_PROFILE') && !Phpfox::isUser())
		{
			return false;
		}

		if (!Phpfox::getUserParam('friend.link_to_remove_friend_on_profile')){
            return false;
        }

		$aUser = $this->getParam('aUser');
		if (empty($aUser))
		{
			return false;
		}

		if (!$aUser['is_friend'])
		{
			return false;
		}
        return null;
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('friend.component_block_top_clean')) ? eval($sPlugin) : false);
	}	
}