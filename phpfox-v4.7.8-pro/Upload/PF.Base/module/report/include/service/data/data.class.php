<?php
/**
 * [PROWEBBER.ru - 2019]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * 
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		phpFox LLC
 * @package 		Phpfox_Service
 * @version 		$Id: data.class.php 2525 2011-04-13 18:03:20Z phpFox LLC $
 */
class Report_Service_Data_Data extends Phpfox_Service 
{
    /**
     * Class constructor
     */
    public function __construct()
    {
        $this->_sTable = Phpfox::getT('report_data');
    }

    public function getReports($iId)
    {
        $aReport = $this->database()->select('item_id')
            ->from($this->_sTable)
            ->where('data_id = ' . (int) $iId)
            ->execute('getSlaveRow');

        if (!isset($aReport['item_id']) && !isset($aReport['feedback']))
        {
            return false;
        }

        $aReports = $this->database()->select('rd.*, r.message, ' . Phpfox::getUserField())
            ->from($this->_sTable, 'rd')
            ->join(Phpfox::getT('user'), 'u', 'u.user_id = rd.user_id')
            ->join(Phpfox::getT('report'), 'r', 'r.report_id = rd.report_id')
            ->where('item_id = \'' . $aReport['item_id'] . '\'')
            ->execute('getSlaveRows');

        return $aReports;
    }

    /**
     * Get number of report by report id
     * @param $iCategoryId
     * @return int|string
     */
    public function getReportsCountByCategoryId($iCategoryId)
    {
        return db()->select('count(*)')->from($this->_sTable)->where("report_id = ". (int) $iCategoryId)->executeField();
    }

    /**
     * If a call is made to an unknown method attempt to connect
     * it to a specific plug-in with the same name thus allowing
     * plug-in developers the ability to extend classes.
     *
     * @param string $sMethod is the name of the method
     * @param array $aArguments is the array of arguments of being passed
     */
    public function __call($sMethod, $aArguments)
    {
        /**
         * Check if such a plug-in exists and if it does call it.
         */
        if ($sPlugin = Phpfox_Plugin::get('report.service_data_data__call'))
        {
            eval($sPlugin);
            return null;
        }

        /**
         * No method or plug-in found we must throw a error.
         */
        Phpfox_Error::trigger('Call to undefined method ' . __CLASS__ . '::' . $sMethod . '()', E_USER_ERROR);
    }
}