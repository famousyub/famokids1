<?php
/**
 * [PROWEBBER.ru - 2019]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * Display a 404 error
 *
 * @copyright        [PHPFOX_COPYRIGHT]
 * @author        phpFox LLC
 * @package        Module_Error
 * @version        $Id: 404.class.php 5846 2013-05-09 10:47:40Z phpFox LLC $
 */
class Error_Component_Controller_404 extends Phpfox_Component
{
    /**
     * Controller
     */
    public function process()
    {
        if (\Core\Route\Controller::$isApi) {
            header('Content-type: application/json');

            echo json_encode([
                'error' => 404,
                'uri' => $_SERVER['REQUEST_URI']
            ]);
            exit;
        }

        $aRequests = Phpfox_Request::instance()->getRequests();

        if ($sPlugin = Phpfox_Plugin::get('error.component_controller_notfound_1')) {
            eval($sPlugin);
            if (isset($mReturnPlugin)) {
                return $mReturnPlugin;
            }
        }

        $aNewRequests = array();
        $iCnt = 0;
        foreach ($aRequests as $sKey => $sValue) {
            if (!preg_match('/req[0-9]/', $sKey)) {
                $aNewRequests[$sKey] = $sValue;

                continue;
            }

            if ($sValue == 'public') {
                continue;
            }

            $iCnt++;

            $aNewRequests['req' . $iCnt] = $sValue;
        }

        if (isset($aNewRequests['req1'])) {
            if ($aNewRequests['req1'] == 'gallery') {
                $aNewRequests['req1'] = 'photo';
            } elseif ($aNewRequests['req1'] == 'browse') {
                $aNewRequests['req1'] = 'user';
            } elseif ($aNewRequests['req1'] == 'groups') {
                $aNewRequests['req1'] = 'group';
            } elseif ($aNewRequests['req1'] == 'videos') {
                $aNewRequests['req1'] = 'video';
            } elseif ($aNewRequests['req1'] == 'listing') {
                $aNewRequests['req1'] = 'marketplace';
            }
        }

        if (isset($aNewRequests['req1']) && Phpfox::isModule($aNewRequests['req1']) && Phpfox::hasCallback($aNewRequests['req1'], 'legacyRedirect')) {
            $sRedirect = Phpfox::callback($aNewRequests['req1'] . '.legacyRedirect', $aNewRequests);
        }

        if (isset($sRedirect) && $sRedirect !== false && !defined('PHPFOX_IS_FORCED_404')) {
            header('HTTP/1.1 301 Moved Permanently');

            if (is_array($sRedirect)) {
                $this->url()->send($sRedirect[0], $sRedirect[1]);
            }

            $this->url()->send($sRedirect);
        }

        if (Phpfox::getParam(array('balancer', 'enabled'))) {
            $sDo = $this->request()->get(PHPFOX_GET_METHOD);

            if (preg_match('/\/file\/css\/(.*)_(.*)/i', $sDo, $aMatches)) {
                $sContent = fox_get_contents(Phpfox::getLib('server')->getServerUrl($aMatches[1]) . ltrim($sDo, '/'));

                $hFile = fopen(PHPFOX_DIR . ltrim($sDo, '/'), 'w+');
                fwrite($hFile, $sContent);
                fclose($hFile);

                header("Content-type: text/css");
                echo $sContent;
                exit;
            }
        }

        header("HTTP/1.0 404 Not Found");

        $sUrl = (isset($_SERVER['REDIRECT_URL']) ? $_SERVER['REDIRECT_URL'] : '');
        $sCurrentUrl = $_SERVER['REQUEST_URI'];
        $aParts = explode('?', $sCurrentUrl);
        $sNewUrl = $aParts[0];

        if (substr($sNewUrl, -3) == '.js') {
            exit(_p('javascript_file_not_found_dot'));
        } elseif (substr($sNewUrl, -4) == '.css') {
            exit(_p('css_file_not_found_dot'));
        }

        if ($sUrl) {
            // If its an image lets create a small "not found" image
            if (substr($sUrl, -4) == '.gif' || substr($sUrl, -4) == '.png' || substr($sUrl, -4) == '.jpg' || substr($sUrl, -5) == '.jpeg') {
                exit;
            }
        }

        $this->template()->errorClearAll();
        $this->template()->setTitle(_p('page_not_found'));
        $this->template()->setBreadCrumb(_p('page_not_found'));
        $this->template()->assign('aFilterMenus', array());
        return null;
    }
}