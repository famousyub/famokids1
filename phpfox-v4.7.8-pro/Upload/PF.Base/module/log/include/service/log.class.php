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
 * @version 		$Id: log.class.php 6897 2013-11-18 11:49:24Z phpFox LLC $
 */
class Log_Service_Log extends Phpfox_Service 
{

	public function getRecentLoggedInUsers()
	{
	    $iCacheRecentLogin = Phpfox::getParam('user.cache_recent_logged_in');
        if (!$iCacheRecentLogin) {
            $iCacheRecentLogin = 1;
        }
        
        $sCacheId = $this->cache()->set(array('user', 'recentloggedin'));

		if (false === ($aUsers = $this->cache()->get($sCacheId, $iCacheRecentLogin)))
		{
			$iFriendsOnly = (int) Phpfox::getComponentSetting(Phpfox::getUserId(), 'log.user_login_display_limit', 0);
			$iLimit = 10;
			(($sPlugin = Phpfox_Plugin::get('log.service_log_getrecentloggedinusers_1')) ? eval($sPlugin) : false);
			
			if ($iFriendsOnly === 1) {
				$aUsers = $this->database()->select(Phpfox::getUserField())
					->from(Phpfox::getT('friend'), 'f')
					->join(Phpfox::getT('user'), 'u', 'u.user_id = f.friend_user_id')
					->where('f.user_id = ' . Phpfox::getUserId() . ' AND is_invisible != 1')
					->order('u.last_login DESC')
					->limit($iLimit)
					->execute('getSlaveRows');
			} else {
				$aUsers = $this->database()->select(Phpfox::getUserField())
					->from(Phpfox::getT('user'), 'u')
					->order('u.last_login DESC')
					->where('u.user_id != ' . Phpfox::getUserId() .' AND is_invisible != 1 AND u.status_id = 0 AND u.view_id = 0')
					->limit($iLimit)
					->execute('getSlaveRows');
			}
            $this->cache()->save($sCacheId, $aUsers);
            Phpfox::getLib('cache')->group(  'user', $sCacheId);
		}
        
        if (isset($aUsers) && is_bool($aUsers)) {
            $aUsers = [];
        }
        
        return isset($aUsers) ? $aUsers : [];
	}
	
	public function getOnlineGuests($aConds, $sSort = '', $iPage = '', $iLimit = '')
	{	
		$iCnt = $this->database()->select('COUNT(*)')
			->from(Phpfox::getT('log_session'), 'ls')			
			->where($aConds)
			->order($sSort)
			->execute('getSlaveField');	
			
		$aItems = array();
		if ($iCnt > 0)
		{		
			$aItems = $this->database()->select('ls.*, b.ban_id')
				->from(Phpfox::getT('log_session'), 'ls')
				->leftJoin(Phpfox::getT('ban'), 'b', 'b.type_id = \'ip\' AND b.find_value = ls.ip_address')
                ->where($aConds)
                ->group('ip_address', true)
				->order($sSort)
				->limit($iPage, $iLimit, $iCnt)
				->execute('getSlaveRows');	
				
			foreach ($aItems as $iKey => $aItem)
			{
				$aItems[$iKey]['ip_address_search'] = str_replace('.', '-', $aItem['ip_address']);
			}
		}
							
		return array($iCnt, $aItems);
	}	
	
	/**
	 * If a call is made to an unknown method attempt to connect
	 * it to a specific plug-in with the same name thus allowing 
	 * plug-in developers the ability to extend classes.
	 *
	 * @param string $sMethod is the name of the method
	 * @param array $aArguments is the array of arguments of being passed
	 * @return mixed
	 */
	public function __call($sMethod, $aArguments)
	{
		/**
		 * Check if such a plug-in exists and if it does call it.
		 */
		if ($sPlugin = Phpfox_Plugin::get('log.service_log__call'))
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