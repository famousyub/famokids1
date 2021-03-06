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
 * @version 		$Id: callback.class.php 3346 2011-10-24 15:20:05Z phpFox LLC $
 */
class Track_Service_Callback extends Phpfox_Service 
{
	public function getBlockDetailsRecentViews()
	{
		return array(
			'title' => _p('recent_visitors')
		);
	}

	public function hideBlockRecentViews($sType)
	{
		return array(
			'table' => 'user_design_order'
		);		
	}

	public function getProfileSettings()
	{
		return array(
			'track.display_on_profile' => array(
				'phrase' => _p('view_who_recently_viewed_your_profile')
			)
		);
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
		if ($sPlugin = Phpfox_Plugin::get('track.service_callback__call'))
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