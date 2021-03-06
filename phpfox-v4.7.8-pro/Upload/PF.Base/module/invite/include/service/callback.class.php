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
 * @package  		Module_Invite
 * @version 		$Id: callback.class.php 1496 2010-03-05 17:15:05Z phpFox LLC $
 */
class Invite_Service_Callback extends Phpfox_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('invite');
	}

	/**
	 * Action to take when user cancelled their account
	 * @param int $iUser
	 */
	public function onDeleteUser($iUser)
	{
		$aInvites = $this->database()
			->select('invite_id')
			->from($this->_sTable)
			->where('user_id = ' . (int)$iUser)
			->execute('getSlaveRows');

		foreach ($aInvites as $aInvite)
		{
            Phpfox::getService('invite.process')->delete($aInvite['invite_id'], $iUser);
		}
	}
	
	public function getDashboardActivity()
	{
		$aUser = Phpfox::getService('user')->get(Phpfox::getUserId(), true);
        
        return [
            _p('invites_activity') => $aUser['activity_invite']
        ];
    }
    
    public function getSiteStatsForAdmins()
	{
		$iToday = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		
		return array(
			'phrase' => _p('invites'),
			'value' => $this->database()->select('COUNT(*)')
				->from(Phpfox::getT('invite'))
				->where('time_stamp >= ' . $iToday)
				->execute('getSlaveField')
		);
	}

	public function getActivityPointField()
	{
		return array(
			_p('invites') => 'activity_invite'
		);
	}

    /**
     * @param $iUserId
     * @return array|bool
     */
    public function getUserStatsForAdmin($iUserId)
    {
        if (!$iUserId) {
            return false;
        }

        $iTotal = db()->select('COUNT(*)')
            ->from(':invite')
            ->where('user_id ='.(int)$iUserId)
            ->execute('getField');
        return [
            'total_name' => _p('invites'),
            'total_value' => $iTotal,
            'type' => 'item'
        ];
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
		if ($sPlugin = Phpfox_Plugin::get('invite.service_callback__call'))
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