<?php
/**
 * [PROWEBBER.ru - 2019]
 */

defined('PHPFOX') or exit('NO DICE!');

class Core_Service_Stat_Stat extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('site_stat');	
	}
    
    /**
     * @return array
     */
	public function get()
	{
		$aStats = $this->database()->select('ss.*')
			->from($this->_sTable, 'ss')		
			->join(Phpfox::getT('module'), 'm', 'm.module_id = ss.module_id AND m.is_active = 1')
			->join(Phpfox::getT('product'), 'p', 'p.product_id = ss.product_id AND p.is_active = 1')
			->order('ss.ordering ASC')
			->execute('getSlaveRows');
			
		return $aStats;
	}
    
    /**
     * @param int $iStartTime
     * @param int $iEndTime
     *
     * @return array
     */
	public function getSiteStatsForAdmin($iStartTime, $iEndTime)
	{
        $aStats = [];
        
        $aCallback = Phpfox::massCallback('getSiteStatsForAdmin', $iStartTime, $iEndTime);
		$sSetting = Phpfox::getParam('core.official_launch_of_site');
		$aParams = explode('/', $sSetting);

		if (isset($aParams[0]) && isset($aParams[1]))
		{
			$iDiff = round(abs(mktime(0, 0, 0, $aParams[0], $aParams[1], $aParams[2]) - PHPFOX_TIME) / 86400);		
		}
		
		foreach ($aCallback as $iKey => $aValue)
		{
			if (isset($aValue[0]))
			{
				foreach ($aValue as $aSubValue)
				{
					$aCallback[] = $aSubValue;
				}
				
				unset($aCallback[$iKey]);
			}			
		}
		
		foreach ($aCallback as $aValue)
		{			
			if (empty($aValue['total']))
			{
				continue;
			}
			
			if (isset($iDiff))
			{
				$aValue['average'] = round((int) $aValue['total'] / ($iDiff == 0 ? 1 : $iDiff), 2);
			}
			
			$aStats[] = $aValue;
		}
				
		return $aStats;
	}
    
    /**
     * @return array
     */
	public function getSiteStats()
	{		
		$sCacheQueryId = $this->cache()->set('stat_query');

		if (false === ($aStats = $this->cache()->get($sCacheQueryId)))
		{
			$aStats = $this->database()->select('ss.*')
				->from($this->_sTable, 'ss')
				->where('ss.is_active = 1')
				->join(Phpfox::getT('module'), 'm', 'm.module_id = ss.module_id AND m.is_active = 1')
				->join(Phpfox::getT('product'), 'p', 'p.product_id = ss.product_id AND p.is_active = 1')			
				->order('ss.ordering ASC')
				->execute('getSlaveRows');
				
			$this->cache()->save($sCacheQueryId, $aStats);
            Phpfox::getLib('cache')->group( 'stat', $sCacheQueryId);
		}
		
		$aCached = array();
		$bRun = true;
		if (Phpfox::getParam('core.cache_site_stats'))
		{			
			$sCacheCountId = $this->cache()->set('stat_count');
			if (false !== ($aCached = $this->cache()->get($sCacheCountId)))
			{
				$bRun = false;				
			}
		}		
			
		if ($bRun === true)
		{
			foreach ($aStats as $aStat)
			{
				eval('$aStat[\'count\'] = ' . $aStat['php_code'] . '');		
				
				unset($aStat['php_code']);
				
				$aCached[] = $aStat;
			}
			
			if (Phpfox::getParam('core.cache_site_stats'))
			{
				$this->cache()->save($sCacheCountId, $aCached);
                Phpfox::getLib('cache')->group( 'stat', $sCacheQueryId);
			}
		}
		
		return $aCached;
	}
    
    /**
     * @param int $iId
     *
     * @return string|array
     */
	public function getForEdit($iId)
	{
		$aStat = $this->database()->select('*')
			->from($this->_sTable)
			->where('stat_id = ' . (int) $iId)
			->execute('getSlaveRow');
			
		if (!isset($aStat['stat_id']))
		{
			return Phpfox_Error::set(_p('unable_to_find_the_stat_you_want_to_edit'));
		}		
			
		return $aStat;
	}
    
    /**
     * @param string      $sProductId
     * @param null|string $sModule
     *
     * @return bool
     */
	public function export($sProductId, $sModule = null)
	{
		$aSql = array();
		$aSql[] = "ss.product_id = '" . $sProductId . "'";
		if ($sModule !== null)
		{
			$aSql[] = "AND ss.module_id = '" . $sModule . "'";
		}

		$aRows = $this->database()->select('ss.*')
			->from($this->_sTable, 'ss')
			->where($aSql)
			->execute('getSlaveRows');

		if (!count($aRows))
		{
			return false;
		}
			
		$oXmlBuilder = Phpfox::getLib('xml.builder');
		$oXmlBuilder->addGroup('stats');

		foreach ($aRows as $aRow)
		{
			$oXmlBuilder->addTag('stat', $aRow['php_code'], array(
					'module_id' => $aRow['module_id'],
					'phrase_var' => $aRow['phrase_var'],
					'stat_link' => $aRow['stat_link'],
					'stat_image' => $aRow['stat_image'],
					'is_active' => $aRow['is_active']
				)
			);
		}
		$oXmlBuilder->closeGroup();

		return true;
	}
    
    /**
     * If a call is made to an unknown method attempt to connect
     * it to a specific plug-in with the same name thus allowing
     * plug-in developers the ability to extend classes.
     *
     * @param string $sMethod    is the name of the method
     * @param array  $aArguments is the array of arguments of being passed
     *
     * @return null
     */
	public function __call($sMethod, $aArguments)
	{
		/**
		 * Check if such a plug-in exists and if it does call it.
		 */
		if ($sPlugin = Phpfox_Plugin::get('core.service_stat_stat__call'))
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