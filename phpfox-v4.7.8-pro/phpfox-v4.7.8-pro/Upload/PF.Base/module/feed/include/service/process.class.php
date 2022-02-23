<?php
defined('PHPFOX') or exit('NO DICE!');

/**
 * @copyright       [PHPFOX_COPYRIGHT]
 * @author          phpFox LLC
 * @package         Module_Feed
 */
class Feed_Service_Process extends Phpfox_Service
{
    /**
     * @var bool
     */
    private $_bAllowGuest = false;

    /**
     * @var int
     */
    private $_iLastId = 0;

    /**
     * @var array
     */
    private $_aCallback = [];

    /**
     * @var bool
     */
    private $_bIsCallback = false;

    /**
     * @var bool
     */
    private $_bIsNewLoop = false;

    /**
     * @var
     */
    private $_content;

    /**
     * @var int
     */
    private $_iNewLoopFeedId = 0;

    /**
     * Class constructor
     */
    public function __construct()
    {
        $this->_sTable = Phpfox::getT('feed');
    }

    /**
     * @param string $sType
     * @param int $iItemId
     *
     * @return void
     */
    public function clearCache($sType, $iItemId)
    {
        return;
    }

    /**
     * @param array $aCallback
     *
     * @return $this
     */
    public function callback($aCallback)
    {
        if (isset($aCallback['module'])) {
            $this->_bIsCallback = true;
            $this->_aCallback = $aCallback;
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function allowGuest()
    {
        $this->_bAllowGuest = true;
        return $this;
    }

    /**
     * @param string $sType
     * @param int $iItemId
     * @param int $iPrivacy
     * @param int $iPrivacyComment
     * @param int $iParentUserId
     * @param null|int $iOwnerUserId
     * @param bool|int $bIsTag
     * @param int $iParentFeedId
     * @param null|string $sParentModuleName
     * @param bool|int $bIsShare
     *
     * @return int
     */
    public function add(
        $sType,
        $iItemId = 0,
        $iPrivacy = 0,
        $iPrivacyComment = 0,
        $iParentUserId = 0,
        $iOwnerUserId = null,
        $bIsTag = false,
        $iParentFeedId = 0,
        $sParentModuleName = null,
        $bIsShare = false
    )
    {
        if (defined('NO_TWO_FEEDS_THIS_ACTION')) {
            if (defined('NO_TWO_FEEDS_THIS_ACTION_RAN')) {
                return true;
            } else {
                define('NO_TWO_FEEDS_THIS_ACTION_RAN', true);
            }
        }
        $isApp = false;
        $content = null;
        if (is_array($sType)) {
            $app = $sType;
            $sType = $app['type_id'];
            $isApp = true;
            $content = $app['content'];
            if (isset($app['privacy'])) {
                $iPrivacy = $app['privacy'];
            }

            if (isset($app['parent_user_id'])) {
                $iParentUserId = $app['item_id'];
            }
        }
        if (!empty($this->_content)) {
            $content = $this->_content;
        }
        //Plugin call
        if (($sPlugin = Phpfox_Plugin::get('feed.service_process_add__start'))) {
            eval($sPlugin);
        }

        if (!defined('PHPFOX_FEED_NO_CHECK')) {
            if (!$isApp && ((!Phpfox::isUser() && $this->_bAllowGuest === false) || (defined('PHPFOX_SKIP_FEED') && PHPFOX_SKIP_FEED))) {
                return false;
            }
        }

        if ($iParentUserId === null) {
            $iParentUserId = 0;
        }

        $iNewTimeStamp = PHPFOX_TIME;
        $aParentModuleName = explode('_', $sParentModuleName);
        $post_user_id = (defined('FEED_FORCE_USER_ID') ? FEED_FORCE_USER_ID : ($iOwnerUserId === null ? Phpfox::getUserId() : (int)$iOwnerUserId));
        $aInsert = [
            'privacy' => (int)$iPrivacy,
            'privacy_comment' => (int)$iPrivacyComment,
            'type_id' => $sType,
            'user_id' => $post_user_id,
            'parent_user_id' => $iParentUserId,
            'item_id' => $iItemId,
            'time_stamp' => $iNewTimeStamp,
            'parent_feed_id' => (int)$iParentFeedId,
            'parent_module_id' => ((Phpfox::isModule($aParentModuleName[0]) || Phpfox::isApps($sParentModuleName)) ? $this->database()->escape($sParentModuleName) : null),
            'time_update' => $iNewTimeStamp,
            'content' => $content
        ];

        if ($this->_bIsCallback && !isset($this->_aCallback['has_content'])) {
            unset($aInsert['content']);
        }

        if (!defined('PHPFOX_INSTALLER') && !$this->_bIsCallback && ((!Phpfox::getParam('feed.add_feed_for_comments') && preg_match('/^(.*)_comment$/i', $sType)) || $sType == 'feed_comment')) {
            if ($sType == 'feed_comment' && !$bIsTag && !$bIsShare) {
                $aInsert['feed_reference'] = 0;
            } else {
                $aInsert['feed_reference'] = 1;
            }
        }
        if ($bIsTag) {
            $aInsert['feed_reference'] = 1;
        }
        if (empty($aInsert['parent_module_id'])) {
            unset($aInsert['parent_module_id']);
        }
        if (defined('PHPFOX_APP_ID')) {
            $aInsert['app_id'] = PHPFOX_APP_ID;
        }

        //Plugin call
        if (($sPlugin = Phpfox_Plugin::get('feed.service_process_add__end'))) {
            eval($sPlugin);
        }

        if ($this->_bIsNewLoop) {
            $aInsert['feed_reference'] = (int)$bIsTag;
            $this->_iNewLoopFeedId = $this->database()->insert(Phpfox::getT('feed'), $aInsert);
            // Reset the loop in case mass action approve
            $this->_bIsNewLoop = false;
        } else {
            $tablePrefix = ($this->_bIsCallback ? $this->_aCallback['table_prefix'] : '');
            if($tablePrefix) {
                unset($aInsert['feed_reference']);
            }
            $this->_iLastId = $this->database()->insert(Phpfox::getT($tablePrefix . 'feed'), $aInsert);
            if ($this->_bIsCallback) {
                storage()->set('feed_callback_' . $this->_iLastId, $this->_aCallback);
            }
            //Loop Feed for main of pages/groups items
            if ($this->_bIsCallback && ($this->_aCallback['module'] == 'pages' || (isset($this->_aCallback['add_to_main_feed']) && $this->_aCallback['add_to_main_feed'])) && !$this->_bIsNewLoop && $iParentUserId > 0) {
                $aUser = $this->database()->select('u.user_id, p.view_id')
                    ->from(Phpfox::getT('user'), 'u')
                    ->join(Phpfox::getT('pages'), 'p', 'p.page_id = u.profile_page_id')
                    ->where('u.profile_page_id = ' . (int)$iParentUserId)
                    ->execute('getSlaveRow');

                if (!$iParentFeedId && defined('PHPFOX_PAGES_IS_PARENT_FEED')) {
                    $iParentFeedId = $this->_iLastId;
                }

                if (!$aUser['view_id']) {
                    $this->_content = $content;
                    $this->_bIsNewLoop = true;
                    $this->_bIsCallback = false;
                    $this->_aCallback = [];
                    if (isset($aUser['user_id']) && Phpfox::getUserId() == $aUser['user_id']) {
                        $this->add($sType, $iItemId, $iPrivacy, $iPrivacyComment, 0, null, 0, $iParentFeedId);
                    } else {
                        $this->add($sType, $iItemId, $iPrivacy, $iPrivacyComment, 0,
                            $iOwnerUserId === null ? Phpfox::getUserId() : $iOwnerUserId, 0, $iParentFeedId);
                    }
                    $this->_content = '';
                    defined('PHPFOX_NEW_FEED_LOOP_ID') || define('PHPFOX_NEW_FEED_LOOP_ID', $this->_iNewLoopFeedId);
                }
            }
            //End loop feed
        }

        if ($sPlugin = Phpfox_Plugin::get('feed.service_process_add__end2')) {
            eval($sPlugin);
        }

        return $this->_iLastId;
    }

    /**
     * @param string $sType
     * @param int $iItemId
     * @param int $iPrivacy
     * @param int $iPrivacyComment
     *
     * @return bool
     */
    public function update($sType, $iItemId, $iPrivacy = 0, $iPrivacyComment = 0)
    {
        $this->database()->update($this->_sTable, [
            'privacy' => (int)$iPrivacy,
            'privacy_comment' => (int)$iPrivacyComment,
        ], 'type_id = \'' . $this->database()->escape($sType) . '\' AND item_id = ' . (int)$iItemId
        );

        return true;
    }

    /**
     * Deletes an entry from the feeds
     *
     * @param string $sType module as defined in: type_id
     * @param integer $iId numeric as defined in item_id
     * @param int|bool $iUser
     *
     * @return void
     */
    public function delete($sType, $iId, $iUser = false)
    {
        $aFeeds = $this->database()->select('feed_id, user_id')
            ->from(Phpfox::getT(($this->_bIsCallback ? $this->_aCallback['table_prefix'] : '') . 'feed'))
            ->where('type_id = \'' . $sType . '\' AND item_id = ' . (int)$iId . ($iUser != false ? ' AND user_id = ' . (int)$iUser : ''))
            ->execute('getSlaveRows');

        foreach ($aFeeds as $aFeed) {
            if ($iUser != false) {
                $this->database()->delete(Phpfox::getT('feed'), 'feed_id = ' . $aFeed['feed_id']);
            }
        }
        if ($iUser == false) {
            $this->database()->delete(Phpfox::getT('feed'), 'type_id = \'' . $sType . '\' AND item_id = ' . (int)$iId);
        }
        if ($sPlugin = Phpfox_Plugin::get('feed.service_process_delete__end')) {
            eval($sPlugin);
        }
    }

    /**
     * @param string $sType
     * @param int $iId
     *
     * @return void
     */
    public function deleteChild($sType, $iId)
    {
        $this->database()->delete(Phpfox::getT('feed'),
            'type_id = \'' . $sType . '\' AND child_item_id = ' . (int)$iId);
    }

    /**
     * @param int $iId
     * @param null|string $sModule
     * @param int $iItem
     *
     * @return bool
     */
    public function deleteFeed($iId, $sModule = null, $iItem = 0)
    {
        $aCallback = null;
        if (!empty($sModule)) {
            if (Phpfox::hasCallback($sModule, 'getFeedDetails')) {
                $aCallback = Phpfox::callback($sModule . '.getFeedDetails', $iItem);
            } else {
                if ($sModule == 'photo' && Phpfox::getUserBy('profile_page_id')) { // login as page
                    $aCallback = [
                        'module' => 'pages',
                        'table_prefix' => 'pages_',
                        'item_id' => $iItem
                    ];
                }
            }
        }
        $aFeed = Phpfox::getService('feed')->callback($aCallback)->getFeed($iId);
        $sType = '';
        if (!$aFeed && ($cache = storage()->get('feed_callback_' . $iId))) {
            if (in_array($cache->value->module, ['pages', 'groups'])) {
                $aFeed = Phpfox::getService('feed')->callback($aCallback)->getFeed($iId, 'pages_');
                $sType = 'v_pages';
            }
        }

        if (!isset($aFeed['feed_id'])) {
            return false;
        }

        if (empty($sType)) {
            $sType = $aFeed['type_id'];
        }

        $iItemId = $aFeed['item_id'];
        if (!$iItemId) {
            $iItemId = $aFeed['feed_id'];
        }

        //Delete all shared items from this item
        $aSharedItems = $this->database()->select('feed_id')
            ->from(':feed')
            ->where('parent_module_id="' . $sType . '" AND parent_feed_id =' . (int)$iItemId)
            ->execute('getSlaveRows');

        if (is_array($aSharedItems) && count($aSharedItems)) {
            foreach ($aSharedItems as $aSharedItem) {
                if (isset($aSharedItem['feed_id'])) {
                    $this->deleteFeed($aSharedItem['feed_id']);
                }
            }
        }

        if ($sPlugin = Phpfox_Plugin::get('feed.service_process_deletefeed')) {
            eval($sPlugin);
        }

        $bCanDelete = false;
        if (Phpfox::getUserParam('feed.can_delete_own_feed') && ($aFeed['user_id'] == Phpfox::getUserId() || ($aFeed['parent_user_id'] == Phpfox::getUserId() && !defined('PHPFOX_IS_PAGES_VIEW')))) {
            $bCanDelete = true;
        }

        if (defined('PHPFOX_FEED_CAN_DELETE')) {
            $bCanDelete = true;
        }

        if (Phpfox::getUserParam('feed.can_delete_other_feeds')) {
            $bCanDelete = true;
        }

        if ($bCanDelete === true) {
            if (isset($aCallback['table_prefix'])) {
                $this->database()->delete(Phpfox::getT($aCallback['table_prefix'] . 'feed'), 'feed_id = ' . (int)$iId);
            }
            if ($aFeed['feed_reference'] == 0 || ($aFeed['user_id'] == Phpfox::getUserId())) { // remove all items of feed
                $this->database()->delete(Phpfox::getT('feed'), 'user_id = ' . $aFeed['user_id'] . ' AND type_id = \'' . $sType . '\' AND item_id = ' . $iItemId);
                if ($sType == 'link') {
                    $this->database()->delete(':link', 'link_id = ' . ($iItemId));
                }
            } else {
                $this->database()->delete(Phpfox::getT('feed'), 'feed_id = ' . $iId);
            }

            if (!(Phpfox::hasCallback($sType, 'ignoreDeleteLikesAndTagsWithFeed') && Phpfox::callback($sType . '.ignoreDeleteLikesAndTagsWithFeed'))) {
                // Delete likes that belonged to this feed
                $this->database()->delete(Phpfox::getT('like'),
                    'type_id = "' . $sType . '" AND item_id = ' . $iItemId);

                // Delete tags that belonged to this feed
                $this->database()->delete(Phpfox::getT('tag'),
                    'category_id = "' . $sType . '" AND item_id = ' . $iItemId);
            }

            if (in_array($sType, ['photo', 'user_status'])) {
                if ($aFeed['feed_reference'] == 0 && Phpfox::hasCallback($sType, 'deleteFeedItem')) {
                    Phpfox::callback($sType . '.deleteFeedItem', $iItemId, ($aCallback != null ? $aCallback['table_prefix'] : ''));
                }
            } elseif (!empty($sModule) && Phpfox::hasCallback($sModule, 'deleteFeedItem')) {
                Phpfox::callback($sModule . '.deleteFeedItem', [
                    'type_id' => $sType,
                    'item_id' => $iItemId,
                ]);
            }

            if ($sPlugin = Phpfox_Plugin::get('feed.service_process_deletefeed_end')) {
                eval($sPlugin);
            }

            return true;
        }

        return false;
    }

    /**
     * @param $aVals
     * @return bool|int
     * @throws Exception
     */
    public function addComment($aVals)
    {
        if (!Phpfox::getService('ban')->checkAutomaticBan($aVals['user_status'])) {
            return false;
        }
        $sStatus = Phpfox::getLib('parse.input')->prepare($aVals['user_status']);
        $aTagged = [];
        if (!empty($aVals['tagged_friends'])) {
            $aTagged = explode(',', $aVals['tagged_friends']);
        }
        $ownerId = Phpfox::getUserId();
        if (isset($aVals['feed_id'])) {
            $feedId = (int)$aVals['feed_id'];
            // update feed
            $sTablePrefix = $this->_bIsCallback ? $this->_aCallback['table_prefix'] : '';
            $feedCommentType = ($this->_bIsCallback ? ($this->_aCallback['module'] . '_') : 'feed_') . 'comment';
            $feed = Phpfox::getService('feed')->getUserStatusFeed($this->_aCallback, $feedId);
            if (!empty($feed)) {
                $iStatusId = (int)$feed['item_id'];
                $feedType = $feed['type_id'];
                $feedUserId = (int)$feed['user_id'];

                if (!isset($aVals['privacy_comment'])) {
                    $aVals['privacy_comment'] = $feed['privacy_comment'];
                }
                if (!isset($aVals['privacy'])) {
                    $aVals['privacy'] = $feed['privacy'];
                }
                if (!isset($aVals['parent_user_id'])) {
                    $aVals['parent_user_id'] = $feed['parent_user_id'];
                }

                if ($feedType == $feedCommentType) {
                    $bUpdate = db()->update(Phpfox::getT($sTablePrefix . 'feed_comment'), ['content' => $sStatus], 'feed_comment_id = ' . $iStatusId);
                    // clear cache
                    if ($bUpdate !== false) {
                        Phpfox_Cache::instance()->removeGroup('feed');
                    }
                } elseif ($feedType == 'link') {
                    db()->delete(Phpfox::getT('link'), 'link = ' . $iStatusId);
                    $insert = [
                        'user_id' => $feedUserId,
                        'parent_user_id' => (int)$aVals['parent_user_id'],
                        'privacy' => $aVals['privacy'],
                        'privacy_comment' => $aVals['privacy_comment'],
                        'content' => $sStatus,
                        'time_stamp' => $feed['time_stamp']
                    ];
                    $sTable = Phpfox::getT($sTablePrefix . 'feed_comment');
                    // check database table to insert location
                    if (isset($aVals['location_latlng']) && $aVals['location_name'] &&
                        db()->isField($sTable, 'location_latlng') && db()->isField($sTable, 'location_name')
                    ) {
                        $insert = array_merge($insert, [
                            'location_latlng' => $aVals['location_latlng'],
                            'location_name' => $aVals['location_name']
                        ]);
                    }

                    $iStatusId = $this->database()->insert($sTable, $insert);
                    db()->update(Phpfox::getT($sTablePrefix . 'feed'), ['type_id' => $feedCommentType, 'item_id' => $iStatusId], 'feed_id = ' . $feedId);
                    if ($this->_bIsCallback && in_array($this->_aCallback['module'], ['pages', 'groups'])) {
                        db()->update(Phpfox::getT('feed'), ['type_id' => $feedCommentType, 'item_id' => $iStatusId], 'type_id = "link" AND item_id = ' . $iStatusId);
                    }
                }

                $sOldContent = (isset($feed['feed_status']) && $feed['feed_status']) ? $feed['feed_status'] : '';
                $oldMentions = Phpfox::getService('user.process')->getIdFromMentions($sOldContent, true, false);
                $oldTagged = Phpfox::getService('feed')->getTaggedUserIds($iStatusId, $feedType);

                // update info of item belong to feed
                if (Phpfox::hasCallback($feedType, 'updateFeedItemInfo')) {
                    Phpfox::callback($feedType . '.updateFeedItemInfo', [
                        'content' => $sStatus,
                        'privacy' => $aVals['privacy'],
                        'item_id' => $iStatusId
                    ]);
                }
                // notification to tagged and mentioned friends
                if (!empty($this->_bIsCallback) && $feedType == $feedCommentType) {
                    if (!empty($this->_aCallback['notification_post_tag']) && Phpfox::isModule('notification')) {
                        $this->notifyTaggedIsCallbackFeed($sStatus, $feedId, $aTagged, $this->_aCallback, $oldMentions, $oldTagged);
                    }

                    if (isset($this->_aCallback['add_tag']) && $this->_aCallback['add_tag']) {
                        if (Phpfox::isModule('tag') && Phpfox::getParam('tag.enable_hashtag_support')) {
                            Phpfox::getService('tag.process')->add($this->_aCallback['feed_id'], $iStatusId, $feedUserId, $sStatus, true);
                        }
                    }
                } else {
                    $this->notifyTaggedInFeed($feedType, $sStatus, $iStatusId, $ownerId, $feedId, $aTagged, $aVals['privacy'], $aVals['parent_user_id'], $oldTagged, $oldMentions, ($this->_aCallback['module'] ? $this->_aCallback['module'] : ''));
                    if (Phpfox::isModule('tag') && Phpfox::getParam('tag.enable_hashtag_support')) {
                        Phpfox::getService('tag.process')->add($feedType, $iStatusId, $ownerId, $sStatus, true);
                    }
                }

                // update in table `feed` also
                Phpfox::getService('feed.process')->update($feedType, $iStatusId, $aVals['privacy'], $aVals['privacy_comment']);

                return true;
            }
        } else {
            if (!isset($aVals['privacy_comment'])) {
                $aVals['privacy_comment'] = 0;
            }
            if (!isset($aVals['privacy'])) {
                $aVals['privacy'] = 0;
            }
            if (!isset($aVals['parent_user_id'])) {
                $aVals['parent_user_id'] = 0;
            }
            $aInsert = [
                'user_id' => $ownerId,
                'parent_user_id' => (int)$aVals['parent_user_id'],
                'privacy' => $aVals['privacy'],
                'privacy_comment' => $aVals['privacy_comment'],
                'content' => $sStatus,
                'time_stamp' => PHPFOX_TIME
            ];
            $sTable = Phpfox::getT(($this->_bIsCallback ? $this->_aCallback['table_prefix'] : '') . 'feed_comment');
            // check database table to insert location
            if (isset($aVals['location_latlng']) && $aVals['location_name'] &&
                db()->isField($sTable, 'location_latlng') && db()->isField($sTable, 'location_name')
            ) {
                $aInsert = array_merge($aInsert, [
                    'location_latlng' => $aVals['location_latlng'],
                    'location_name' => $aVals['location_name']
                ]);
            }
            $iStatusId = $this->database()->insert($sTable, $aInsert);

            // add new feed
            if (!defined('PHPFOX_NEW_USER_STATUS_ID')) {
                define('PHPFOX_NEW_USER_STATUS_ID', $iStatusId);
            }

            if ($this->_bIsCallback) {
                if ($sPlugin = Phpfox_Plugin::get('feed.service_process_addcomment__1')) {
                    eval($sPlugin);
                }
                $sLink = $this->_aCallback['link'] . 'comment-id_' . $iStatusId . '/';
                if (is_array($this->_aCallback['message']) && isset($this->_aCallback['message'][1])) {
                    $this->_aCallback['message'][1]['link'] = $sLink;
                }
                if (!empty($this->_aCallback['notification']) && !Phpfox::getUserBy('profile_page_id')) {
                    Phpfox::getLib('mail')->to($this->_aCallback['email_user_id'])
                        ->subject($this->_aCallback['subject'])
                        ->message($this->_aCallback['message'])
                        ->notification(($this->_aCallback['notification'] == 'pages_comment' ? 'comment.add_new_comment' : $this->_aCallback['notification']))
                        ->send();

                    if (Phpfox::isModule('notification')) {
                        Phpfox::getService('notification.process')->add($this->_aCallback['notification'], $iStatusId, $this->_aCallback['email_user_id']);
                    }
                }
                // notification when user tag other on a feed's post
                if (!empty($this->_aCallback['notification_post_tag']) && Phpfox::isModule('notification')) {
                    $this->notifyTaggedIsCallbackFeed($sStatus, $iStatusId, $aTagged, $this->_aCallback);
                }
                $feedTypeId = $this->_aCallback['feed_id'];
                if (isset($this->_aCallback['add_tag']) && $this->_aCallback['add_tag']) {
                    if (Phpfox::isModule('tag') && Phpfox::getParam('tag.enable_hashtag_support')) {
                        Phpfox::getService('tag.process')->add($feedTypeId, $iStatusId, $ownerId, $sStatus, true);
                    }
                }
                if (Phpfox::isAppActive('Core_Activity_Points')) {
                    Phpfox::getService('activitypoint.process')->updatePoints($ownerId, 'share_item');
                }
                return $this->add($feedTypeId, $iStatusId, $aVals['privacy'], $aVals['privacy_comment'], (int)$aVals['parent_user_id']);
            }

            // No Callback Module
            $aUser = $this->database()->select('user_name')
                ->from(Phpfox::getT('user'))
                ->where('user_id = ' . (int)$aVals['parent_user_id'])
                ->execute('getSlaveRow');

            $sLink = Phpfox_Url::instance()->makeUrl($aUser['user_name'], ['comment-id' => $iStatusId]);

            if (Phpfox::isModule('tag') && Phpfox::getParam('tag.enable_hashtag_support')) {
                Phpfox::getService('tag.process')->add((isset($aVals['feed_type']) ? $aVals['feed_type'] : 'feed_comment'), $iStatusId, $ownerId, $sStatus, true);
            }
            /* When a user is tagged it needs to add a special feed */
            if (!isset($aVals['feed_reference']) || empty($aVals['feed_reference'])) {
                Phpfox::getLib('mail')->to($aVals['parent_user_id'])
                    ->subject([
                        'full_name_wrote_a_comment_on_your_wall',
                        ['full_name' => Phpfox::getUserBy('full_name')]
                    ])
                    ->message([
                        'full_name_wrote_a_comment_on_your_wall_message',
                        ['full_name' => Phpfox::getUserBy('full_name'), 'link' => $sLink]
                    ])
                    ->notification('comment.add_new_comment')
                    ->send();

                if (Phpfox::isModule('notification') && empty($aVals['egift_id'])) {
                    Phpfox::getService('notification.process')->add('feed_comment_profile', $iStatusId, $aVals['parent_user_id']);
                }
                if (isset($aVals['feed_type'])) {
                    if (Phpfox::isAppActive('Core_Activity_Points')) {
                        Phpfox::getService('activitypoint.process')->updatePoints($ownerId, 'share_item');
                    }
                    $feedId = $this->add($aVals['feed_type'], $iStatusId, $aVals['privacy'], $aVals['privacy_comment'], (int)$aVals['parent_user_id']);
                    // notification to tagged and mentioned friends
                    $this->notifyTaggedInFeed($aVals['feed_type'], $sStatus, $iStatusId, $ownerId, $feedId, $aTagged, $aVals['privacy'], (isset($aVals['parent_user_id']) ? (int)$aVals['parent_user_id'] : 0));
                    return $feedId;
                }
            } else { // This is a special feed
                if (Phpfox::isAppActive('Core_Activity_Points')) {
                    Phpfox::getService('activitypoint.process')->updatePoints($ownerId, 'share_item');
                }
                $feedType = 'feed_comment';
                $feedId = $this->add($feedType, $iStatusId, $aVals['privacy'], $aVals['privacy_comment'], (int)$aVals['parent_user_id'], null, $aVals['feed_reference']);
                // notification to tagged and mentioned friends
                $this->notifyTaggedInFeed($feedType, $sStatus, $iStatusId, $ownerId, $feedId, $aTagged, $aVals['privacy'], (isset($aVals['parent_user_id']) ? (int)$aVals['parent_user_id'] : 0));
                return $feedId;
            }

            if (Phpfox::isAppActive('Core_Activity_Points')) {
                if (!empty($aVals['parent_feed_id'])) {
                    Phpfox::getService('activitypoint.process')->updatePoints($ownerId, 'share_item');
                } elseif (!empty($aVals['parent_user_id'])) {
                    Phpfox::getService('activitypoint.process')->updatePoints($ownerId, 'feed_postonotherprofile');
                }
            }
            $feedType = 'feed_comment';
            $feedId = $this->add($feedType, $iStatusId, $aVals['privacy'],
                $aVals['privacy_comment'], (int)$aVals['parent_user_id'], null, false,
                (isset($aVals['parent_feed_id']) ? $aVals['parent_feed_id'] : 0),
                (isset($aVals['parent_module_id']) ? $aVals['parent_module_id'] : null),
                (isset($aVals['is_share']) ? $aVals['is_share'] : false));

            // notification to tagged and mentioned friends
            $this->notifyTaggedInFeed($feedType, $sStatus, $iStatusId, $ownerId, $feedId, $aTagged, $aVals['privacy'], (isset($aVals['parent_user_id']) ? (int)$aVals['parent_user_id'] : 0));
            return $feedId;
        }
    }

    public function notifyTaggedIsCallbackFeed($sStatus, $itemId, $aTagged, $callback, $oldMentions = [], $oldTagged = [])
    {
        $aMentions = Phpfox::getService('user.process')->getIdFromMentions($sStatus, true, false);
        Phpfox::getService('feed')->filterTaggedPrivacy($aMentions, $aTagged);
        $aMentions = array_diff($aMentions, $oldMentions); // remove oldMentions
        $aTagged = array_diff($aTagged, $oldTagged); // remove oldTaggedFriends
        $allTagged = array_unique(array_merge($aTagged, $aMentions));
        foreach ($allTagged as $userId) {
            Phpfox::getService('notification.process')->add($callback['notification_post_tag'], $itemId, $userId);
        }
    }

    public function getLastId()
    {
        return (int)$this->_iLastId;
    }

    /**
     * @param $feedType
     * @param $sContent
     * @param $iItemId
     * @param $iOwnerId
     * @param int $iFeedId
     * @param array $aTagged
     * @param int $iPrivacy
     * @param int $iParentUserId
     * @param array $oldTagged
     * @param array $oldMentions
     * @param string $moduleId
     * @return bool
     */
    public function notifyTaggedInFeed($feedType, $sContent, $iItemId, $iOwnerId, $iFeedId = 0, $aTagged = [], $iPrivacy = 0, $iParentUserId = 0, $oldTagged = [], $oldMentions = [], $moduleId = '')
    {
        return $this->updateFeedTaggedUsers([
            'feed_type' => $feedType,
            'content' => $sContent,
            'owner_id' => $iOwnerId,
            'privacy' => $iPrivacy,
            'tagged_friend' => $aTagged,
            'item_id' => $iItemId,
            'feed_id' => $iFeedId,
            'parent_user_id' => $iParentUserId,
            'old_tagged_friend' => $oldTagged,
            'old_mentioned_friend' => $oldMentions,
            'module_id' => $moduleId
        ]);
    }

    /**
     * @param $iFeedId
     * @param $sComment
     * @param array $aTaggedUsers
     * @return bool
     * @throws Exception
     */
    public function updateFeedComment($iFeedId, $sComment, $aTaggedUsers = [])
    {
        $aFeed = Phpfox::getService('feed')->getUserStatusFeed(null, $iFeedId);
        if (!$aFeed) {
            return false;
        }
        $ownerId = Phpfox::getUserId();
        $feedType = 'feed_comment';
        $itemId = (int)$aFeed['item_id'];
        $sOldContent = (isset($aFeed['feed_status']) && $aFeed['feed_status']) ? $aFeed['feed_status'] : '';
        $oldMentions = Phpfox::getService('user.process')->getIdFromMentions($sOldContent, true, false);
        $oldTagged = Phpfox::getService('feed')->getTaggedUserIds($itemId, $feedType);

        $this->notifyTaggedInFeed($feedType, $sComment, $itemId, $ownerId, $iFeedId, $aTaggedUsers, $aFeed['privacy'], $aFeed['parent_user_id'], $oldTagged, $oldMentions);
        if (Phpfox::isModule('tag') && Phpfox::getParam('tag.enable_hashtag_support')) {
            Phpfox::getService('tag.process')->add($feedType, $itemId, $ownerId, $sComment, true);
        }

        if (db()->update(':feed_comment', ['content' => $sComment], ['time_stamp' => $aFeed['time_stamp']])) {
            // clear cache
            $this->cache()->removeGroup('feed');
            return true;
        }
        return false;
    }

    /**
     *  Add/update tagged users in feed
     * @param $params
     * @return bool
     */
    public function updateFeedTaggedUsers($params)
    {
        if (!Phpfox::getParam('feed.enable_tag_friends')) {
            return false;
        }
        $sFeedType = $params['feed_type'];
        $aMentions = Phpfox::getService('user.process')->getIdFromMentions($params['content'], true, false);
        $aTagged = $params['tagged_friend'];
        $allTagged = array_unique(array_merge($aTagged, $aMentions));
        $iItemId = $params['item_id'];
        $oldMentionedFriends = isset($params['old_mentioned_friend']) ? $params['old_mentioned_friend'] : [];
        $oldTaggedFriends = isset($params['old_tagged_friend']) ? $params['old_tagged_friend'] : [];
        $allOldTagged = array_unique(array_merge($oldTaggedFriends, $oldMentionedFriends));
        $aRemoveTagged = array_diff($allOldTagged, $allTagged);

        if (array_filter($aRemoveTagged)) { // delete feed of tagged users
            db()->delete(Phpfox::getT('feed'), '`type_id` = \'' . $sFeedType . '\' AND `item_id` = ' . (int)$iItemId . ' AND `feed_reference` = 1 AND `parent_user_id` IN (' . implode(',', $aRemoveTagged) . ')');
            if ($sPlugin = Phpfox_Plugin::get('feed.service_process_delete__end')) {
                eval($sPlugin);
            }
        }

        Phpfox::getService('feed')->filterTaggedPrivacy($aMentions, $aTagged);

        if (count($oldTaggedFriends)) {
            $this->updateTaggedUsers($iItemId, $sFeedType, $aTagged);
        } else {
            $this->addTaggedUsers($iItemId, $aTagged, $sFeedType);
        }

        $aMentions = array_diff($aMentions, $oldMentionedFriends); // remove oldMentions
        $aTagged = array_diff($aTagged, $oldTaggedFriends); // remove oldTaggedFriends
        $allTagged = array_unique(array_merge($aTagged, $aMentions));

        $callbackModuleId = $sFeedType;
        if (in_array($callbackModuleId, ['user_status', 'feed_comment'])) {
            $callbackModuleId = 'user';
        }

        if (count($allTagged) && Phpfox::hasCallback($callbackModuleId, 'sendNotifyToTaggedUsers')) {
            $params['tagged_friend'] = $allTagged;
            Phpfox::callback($callbackModuleId . '.sendNotifyToTaggedUsers', $params);
        }
    }

    /**
     * Add tag when tag a friend using "With friend" feature
     * @param $iItemId
     * @param $aUserIds
     * @param $sType
     * @return bool
     */
    public function addTaggedUsers($iItemId, $aUserIds, $sType)
    {
        foreach ($aUserIds as $iUserId) {
            db()->insert(Phpfox::getT('feed_tag_data'),
                [
                    'user_id' => $iUserId,
                    'item_id' => $iItemId,
                    'type_id' => $sType
                ]);
        }
        $this->cache()->remove('tagged_users_' . $sType . '_' . $iItemId);
        return true;
    }

    /**
     * @param $iItemId
     * @param $iUserId
     * @param $sType
     * @return bool
     */
    public function deleteTaggedUser($iItemId, $iUserId, $sType)
    {
        db()->delete(Phpfox::getT('feed_tag_data'),
            [
                'user_id' => $iUserId,
                'item_id' => $iItemId,
                'type_id' => $sType
            ]);
        $this->cache()->remove('tagged_users_' . $sType . '_' . $iItemId);
        return true;
    }

    /**
     * Update tag when update status with tag
     * @param $iItemId
     * @param $aUserId
     * @param $sType
     * @return bool
     */
    public function updateTaggedUsers($iItemId, $sType, $aUserId = null)
    {
        db()->delete(Phpfox::getT('feed_tag_data'), 'item_id =' . (int)$iItemId . ' AND type_id = \'' . $sType . '\'');
        if (count($aUserId)) {
            return $this->addTaggedUsers($iItemId, $aUserId, $sType);
        } else {
            $this->cache()->remove('tagged_users_' . $sType . '_' . $iItemId);
        }
    }

    /**
     * If a call is made to an unknown method attempt to connect
     * it to a specific plug-in with the same name thus allowing
     * plug-in developers the ability to extend classes.
     *
     * @param string $sMethod is the name of the method
     * @param array $aArguments is the array of arguments of being passed
     *
     * @return null
     */
    public function __call($sMethod, $aArguments)
    {

        /**
         * Check if such a plug-in exists and if it does call it.
         */
        if ($sPlugin = Phpfox_Plugin::get('feed.service_process__call')) {
            eval($sPlugin);
            return null;
        }

        /**
         * No method or plug-in found we must throw a error.
         */
        Phpfox_Error::trigger('Call to undefined method ' . __CLASS__ . '::' . $sMethod . '()', E_USER_ERROR);
    }
}