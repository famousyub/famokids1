<?php
/**
 * [PROWEBBER.ru - 2019]
 */

defined('PHPFOX') or exit('NO DICE!');

class Log_Service_Staff extends Phpfox_Service 
{
	private $_aActions = array(
		'delete' => '1',
		'add' => '2',
		'update' => '3',
		'import' => '4'
	);
	
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = Phpfox::getT('log_staff');
	}
	
	public function add($sMethod, $sAction, $aExtra = array())
	{
		$aInsert = array(
			'user_id' => Phpfox::getUserId(),
			'type_id' => $this->_aActions[$sAction],
			'call_name' => $sMethod,
			'time_stamp' => PHPFOX_TIME,
			'ip_address' => Phpfox_Request::instance()->getIp()
		);
		
		if ($aExtra)
		{
			$aInsert['extra'] = serialize($aExtra);
		}		
		
		$this->database()->insert($this->_sTable, $aInsert);
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
		if ($sPlugin = Phpfox_Plugin::get('log.service_staff___call'))
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