<?php
/**
 * [PROWEBBER.ru - 2019]
 */

defined('PHPFOX') or exit('NO DICE!');

class Core_Component_Ajax_Admincp_Ajax extends Phpfox_Ajax
{
    public function updateNote()
    {
        Phpfox::getService('core.admincp.process')->updateNote($this->get('admincp_note'));
        $this->call("$('#js_admincp_note').data('value', $('#js_admincp_note').val());");
        $this->hide('#js_save_note');
    }

    public function viewAdminLogin()
    {
        Phpfox::getBlock('core.view-admincp-login');
    }

    public function countryChildTranslate()
    {
        Phpfox::getBlock('core.translate-child-country');
    }

    public function translateCountryChildProcess()
    {
        if (Phpfox::getService('core.country.child.process')->translate($this->get('val'))) {

        }
    }

    public function countryTranslate()
    {
        Phpfox::getBlock('core.translate-country');
    }

    public function translateCountryProcess()
    {
        if (Phpfox::getService('core.country.process')->translate($this->get('val'))) {
        }
    }
}