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
 * @version        $Id: block.class.php 103 2009-01-27 11:32:36Z phpFox LLC $
 */
class Link_Component_Block_Display extends Phpfox_Component
{
    /**
     * Controller
     */
    public function process()
    {
        $iLinkId = (int)$this->getParam('link_id');

        if (!($aLink = Phpfox::getService('link')->getLinkById($iLinkId))) {
            return false;
        }

        if (Phpfox::getParam('core.warn_on_external_links')) {
            if (!preg_match('/' . preg_quote(Phpfox::getParam('core.host')) . '/i', $aLink['link'])) {
                $aLink['custom_css'] = 'external_link_warning';
            }
        }

        if (substr($aLink['link'], 0, 7) != 'http://' && substr($aLink['link'], 0, 8) != 'https://') {
            $aLink['link'] = 'http://' . $aLink['link'];
        }

        $this->template()->assign(array(
                'aLink' => $aLink,
                'bIsAttachment' => ($this->getParam('attachment') ? true : false)
            )
        );
        return null;
    }

    /**
     * Garbage collector. Is executed after this class has completed
     * its job and the template has also been displayed.
     */
    public function clean()
    {
        (($sPlugin = Phpfox_Plugin::get('link.component_block_display_clean')) ? eval($sPlugin) : false);
    }
}

?>