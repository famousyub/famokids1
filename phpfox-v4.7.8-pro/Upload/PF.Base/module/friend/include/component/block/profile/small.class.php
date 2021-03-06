<?php
/**
 * [PROWEBBER.ru - 2019]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 *
 *
 * @copyright        [PHPFOX_COPYRIGHT]
 * @author        phpFox LLC
 * @package        Module_Friend
 * @version        $Id: small.class.php 2760 2011-07-27 13:39:18Z phpFox LLC $
 */
class Friend_Component_Block_Profile_Small extends Phpfox_Component
{
    /**
     * Controller
     */
    public function process()
    {
        $aUser = (PHPFOX_IS_AJAX ? Phpfox::getService('user')->get(Phpfox::getUserId(), true) : $this->getParam('aUser'));
        if (!$aUser) {
            $aUser = Phpfox::getService('user')->get(Phpfox::getUserId(), true);
        }
        if (!$aUser || !Phpfox::getService('user.privacy')->hasAccess($aUser['user_id'], 'friend.view_friend')) {
            return false;
        }

        $iTotal = (int)Phpfox::getComponentSetting($aUser['user_id'], 'friend.friend_display_limit_profile', Phpfox::getParam('friend.friend_display_limit'));
        $aRows = Phpfox::getService('friend')->get('friend.is_page = 0 AND friend.user_id = ' . $aUser['user_id'], 'friend.is_top_friend DESC, friend.ordering ASC, RAND()', 0, $iTotal, false);
        $iCount = count($aRows);

        if (!$iCount) {
            return false;
        }
        $sFriendsLink = Phpfox::getService('user')->getLink($aUser['user_id'], $aUser['user_name'], 'friend');
        $this->template()->assign([
                'aFriends' => $aRows,
                'sFriendsLink' => $sFriendsLink,
                'sBlockJsId' => 'profile_friend',
                'aFriendLists' => Phpfox::getService('friend.list')->getListForProfile($aUser['user_id']),
                'aSubject' => $aUser,
                'bShowFriendInfo' => true,
                'aUserFriendFeed' => null
            ]
        );

        $this->setParam([
            'mutual_list' => true
        ]);

        return null;
    }

    /**
     * Garbage collector. Is executed after this class has completed
     * its job and the template has also been displayed.
     */
    public function clean()
    {
        (($sPlugin = Phpfox_Plugin::get('friend.component_block_profile_small_clean')) ? eval($sPlugin) : false);
    }

    public function widget()
    {
        return true;
    }
}