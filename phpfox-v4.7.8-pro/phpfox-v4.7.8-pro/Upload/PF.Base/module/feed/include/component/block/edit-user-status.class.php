<?php
defined('PHPFOX') or exit('NO DICE!');

class Feed_Component_Block_Edit_User_Status extends Phpfox_Component
{
    public function process()
    {
        $iFeedId = $this->request()->get('id');
        $aFeedCallback = [];
        $module = $this->request()->get('module');
        if (!empty($module) && !in_array($module, ['photo', 'v', 'link'])) {
            $aFeedCallback = [
                'module' => $module,
                'table_prefix' => $module . '_',
                'item_id' => $this->request()->get('item_id') ? $this->request()->get('item_id') : $this->request()->get('id')
            ];
        }

        $aFeed = Phpfox::getService('feed')->getUserStatusFeed($aFeedCallback, $iFeedId, false);
        if (!$aFeed) {
            return false;
        }

        $userInfo = [];
        if (!empty($aFeed['parent_user_id'])) {
            $user = Phpfox::getService('user')->getUser($aFeed['parent_user_id'], 'u.user_id, u.profile_page_id');
            if (!empty($user) && (int)$user['profile_page_id'] == 0) {
                $userInfo = $user;
            }
            if (!empty($userInfo) && !defined('PHPFOX_IS_USER_PROFILE')) {
                define('PHPFOX_IS_USER_PROFILE', true);
            }
        }

        if (!empty($aFeedCallback)) {
            $this->template()->assign('aFeedCallback', [
                'callback_item_id' => $aFeed['parent_user_id'],
                'module' => $module,
                'item_id' => $aFeed['parent_user_id']
            ]);
        }

        // get tagged user ids for edit status
        $aTaggedFriends = Phpfox::getService('feed')->getTaggedUserIds($aFeed['item_id'], $aFeed['type_id']);
        if (!empty($aTaggedFriends)) {
            $aFeed['tagged_friends'] = implode(',', $aTaggedFriends);
        }

        $bIsUserStatus = false;
        switch ($aFeed['type_id']) {
            case 'user_status':
                if (!((Phpfox::getUserParam('feed.can_edit_own_user_status') && $aFeed['user_id'] == Phpfox::getUserId()) || Phpfox::getUserParam('feed.can_edit_other_user_status'))) {
                    return false;
                }
                $bIsUserStatus = true;
                break;
            case 'feed_comment':
                if ($aFeed['user_id'] != Phpfox::getUserId() && !Phpfox::isAdmin()) {
                    return false;
                }
                break;
            case 'pages_comment':
            case 'groups_comment':
            case 'event_comment':
                break;
            case 'v':
            case 'photo':
            case 'link':
                {
                    if (empty($userInfo) && empty($aFeedCallback)) {
                        $bIsUserStatus = true;
                    }
                    break;
                }
            default:
                return false;
        }

        $bLoadCheckIn = false;
        $bLoadTagFriends = false;
        // TODO check support in future, cause: issue about load data when edit and map load below popup => not suppor now
//        if (!defined('PHPFOX_IS_PAGES_VIEW') && !defined('PHPFOX_IS_EVENT_VIEW') && Phpfox::getParam('feed.enable_check_in') && Phpfox::getParam('core.google_api_key')) {
//            $bLoadCheckIn = true;
//        }
        if (Phpfox::getParam('feed.enable_tag_friends') && $this->getParam('allowTagFriends', true)) {
            $bLoadTagFriends = true;
        }

        $this->template()->assign([
            'iFeedId' => $iFeedId,
            'bLoadCheckIn' => $bLoadCheckIn,
            'bLoadTagFriends' => $bLoadTagFriends,
            'aForms' => $aFeed,
            'bIsUserStatus' => $bIsUserStatus,
            'mOnOtherUserProfile' => !empty($userInfo) ? true : false,
            'aUser' => $userInfo,
            'iUserProfileId' => !empty($userInfo) ? $userInfo['user_id'] : 0
        ]);

        if ($sPlugin = Phpfox_Plugin::get('feed.component_block_edit_user_status_end')) {
            eval($sPlugin);
        }

        return null;
    }
}
