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
 * @package        Module_Track
 * @version        $Id: recent-views.class.php 2592 2011-05-05 18:51:50Z phpFox LLC $
 */
class Track_Component_Block_Recent_Views extends Phpfox_Component
{
    /**
     * Controller
     */
    public function process()
    {
        if (!$sTrackType = $this->getParam('sTrackType')) {
            return false;
        }

        if (($iTrackId = $this->getParam('iTrackId')) === null) {
            return false;
        }

        $iTrackUserId = $this->getParam('iTrackUserId');

        if (defined('PHPFOX_IS_USER_PROFILE') && !Phpfox::getService('user.privacy')->hasAccess($iTrackUserId, 'track.display_on_profile')) {
            return false;
        }

        if (!($aRows = Phpfox::getService('track')->getLatestUsers($sTrackType, $iTrackId, $iTrackUserId))) {
            return false;
        }

        $this->template()->assign([
                'aLatestUsers' => $aRows,
                'sHeader' => ($iTrackId === false ? _p('recent_visitors') : _p('recently_viewed_by')),
                'sBlockJsId' => 'profile_track_user'
            ]
        );

        if (Phpfox::getUserId() == $iTrackUserId) {
            $this->template()->assign('sDeleteBlock', 'profile');
        }

        (($sPlugin = Phpfox_Plugin::get('track.component_block_recent_views_process')) ? eval($sPlugin) : false);

        return 'block';
    }

    /**
     * Garbage collector. Is executed after this class has completed
     * its job and the template has also been displayed.
     */
    public function clean()
    {
        (($sPlugin = Phpfox_Plugin::get('track.component_block_recent_views_clean')) ? eval($sPlugin) : false);
    }
}