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
 * @package        Phpfox_Component
 * @version        $Id: build.class.php 2621 2011-05-22 20:09:22Z phpFox LLC $
 */
class Privacy_Component_Block_Build extends Phpfox_Component
{
    /**
     * Controller
     */
    public function process()
    {
        $aPrivacySettings = Phpfox::getService('privacy')->get($this->getParam('privacy_module_id'), $this->getParam('privacy_item_id'));
        if (!count($aPrivacySettings)) {
            return false;
        }
        $this->template()->assign([
                'aPrivacySettings' => $aPrivacySettings,
                'sPrivacyArray' => $this->getParam('privacy_array', null)
            ]
        );
        return null;
    }

    /**
     * Garbage collector. Is executed after this class has completed
     * its job and the template has also been displayed.
     */
    public function clean()
    {
        (($sPlugin = Phpfox_Plugin::get('privacy.component_block_build_clean')) ? eval($sPlugin) : false);
        $this->template()->clean([
                'sPrivacyArray'
            ]
        );
        $this->clearParam('privacy_array');
    }
}