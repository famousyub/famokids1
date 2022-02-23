<?php
/**
 * [PROWEBBER.ru - 2019]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 *
 *
 * @copyright        [PHPFOX_COPYRIGHT]
 * @author           phpFox LLC
 * @package          Module_Admincp
 * @version          $Id: index.class.php 7202 2014-03-18 13:38:56Z phpFox LLC $
 */
class Admincp_Component_Controller_Upload extends Phpfox_Component
{

    /**
     * upload package to collate.
     */
    public function process()
    {
        // check authorization
        Phpfox::isUser(true);
        Phpfox::getUserParam('admincp.has_admin_access', true);

        $this->template()->setTitle(_p('Import Module'));
    }

    /**
     * Garbage collector. Is executed after this class has completed
     * its job and the template has also been displayed.
     */
    public function clean()
    {
        (($sPlugin = Phpfox_Plugin::get('admincp.component_controller_upload_clean')) ? eval($sPlugin) : false);
    }
}