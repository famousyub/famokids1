<?php
defined('PHPFOX') or exit('NO DICE!');

/**
 * Class Profile_Component_Block_Logo
 */
class Profile_Component_Block_Logo extends Phpfox_Component
{
    /**
     * Controller
     */
    public function process()
    {
        $bIsPages = ((defined('PHPFOX_IS_PAGES_VIEW')) ? true : false);
        // Used in the template to set the ajax call
        $sModule = 'user';
        $aUser = $this->getParam('aUser');
        if (empty($aUser) && $bIsPages) {
            $aUser = $this->getParam('aPage');
        }

        if ($bIsPages && !defined('loadedLogo') && isset($aUser['cover_photo_id'])) {
            $aUser['cover_photo'] = $aUser['cover_photo_id'];
            $aUser['cover_photo_top'] = isset($aUser['cover_photo_position']) ? $aUser['cover_photo_position'] : 0;

            $this->template()->assign(array(
                'sLogoPosition' => $aUser['cover_photo_top']
            ));
            $sModule = 'pages';
            define('loadedLogo', true);
        } else {
            if (!defined('PHPFOX_IS_USER_PROFILE')) {
                return false;
            }
        }
        $this->template()->assign(array('sAjaxModule' => $sModule));

        if (empty($aUser['cover_photo'])) {
            return false;
        }

        $aCoverPhoto = Phpfox::getService('photo')->getCoverPhoto($aUser['cover_photo']);

        if (!isset($aCoverPhoto['photo_id'])) {
            return false;
        }

        if (!$bIsPages && !Phpfox::getService('user.privacy')->hasAccess($aUser['user_id'], 'profile.view_profile')) {
            return false;
        }

        if ($bIsPages) {
            $aPage = $this->getParam('aPage');

            $this->template()->assign('sPagesLink', $aPage['link']);
        }

        $this->template()->assign(array(
            'aCoverPhoto' => $aCoverPhoto,
            'bRefreshPhoto' => ($this->request()->getInt('coverupdate') ? true : false),
            'bNewCoverPhoto' => ($this->request()->getInt('newcoverphoto') ? true : false),
            'sLogoPosition' => $aUser['cover_photo_top'],
            'bIsPages' => $bIsPages
        ));
        return null;
    }

    /**
     * Garbage collector. Is executed after this class has completed
     * its job and the template has also been displayed.
     */
    public function clean()
    {
        (($sPlugin = Phpfox_Plugin::get('profile.component_block_logo_clean')) ? eval($sPlugin) : false);
    }
}