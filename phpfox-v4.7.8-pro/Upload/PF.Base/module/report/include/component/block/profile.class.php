<?php
/**
 * [PROWEBBER.ru - 2019]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 *
 *
 * @copyright       [PHPFOX_COPYRIGHT]
 * @author          phpFox LLC
 * @package         Phpfox_Component
 */
class Report_Component_Block_Profile extends Phpfox_Component
{
    /**
     * Controller
     */
    public function process()
    {
        (($sPlugin = Phpfox_Plugin::get('report.component_block_profile_process')) ? eval($sPlugin) : false);

        if (isset($bHideReportLink)) {
            return false;
        }

        $viewer_id = Phpfox::getUserId();
        $aUser = $this->getParam('aUser');
        if (isset($aUser['is_page']) && $aUser['is_page'] || $aUser['user_id'] == $viewer_id) {
            return false;
        }

        $isRequest = false;
        $isFriend = (Phpfox::isModule('friend') ? Phpfox::getService('friend')->isFriend($viewer_id, $aUser['user_id']) : false);
        if (!$isFriend) {
            $isRequest = Phpfox::getService('friend.request')->isRequested($viewer_id, $aUser['user_id']);
        }

        $this->template()->assign([
            'aUser' => $aUser,
            'bIsFriend' => $isFriend,
            'bIsRequest' => $isRequest,
            'bIsBlocked' => (Phpfox::isUser() ? Phpfox::getService('user.block')->isBlocked($viewer_id, $aUser['user_id']) : false)
        ]);

        return null;
    }

    /**
     * Garbage collector. Is executed after this class has completed
     * its job and the template has also been displayed.
     */
    public function clean()
    {
        (($sPlugin = Phpfox_Plugin::get('report.component_block_profile_clean')) ? eval($sPlugin) : false);
    }
}
