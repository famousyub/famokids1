<?php
/**
 * [PROWEBBER.ru - 2019]
 */

defined('PHPFOX') or exit('NO DICE!');

class Request_Component_Controller_View extends Phpfox_Component
{
    /**
     * Controller
     */
    public function process()
    {
        $sUrl = Phpfox::hasCallback($this->request()->get('req3'), 'getRedirectRequest') ? Phpfox::callback($this->request()->get('req3') . '.getRedirectRequest', $this->request()->get('id')) : '';
        if (empty($sUrl)) {
            return Phpfox_Error::display(_p('invalid_request_redirect'));
        }

        $this->url()->forward($sUrl);
    }

    /**
     * Garbage collector. Is executed after this class has completed
     * its job and the template has also been displayed.
     */
    public function clean()
    {
        (($sPlugin = Phpfox_Plugin::get('request.component_controller_view_clean')) ? eval($sPlugin) : false);
    }
}
