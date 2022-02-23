<?php
/**
 * [PROWEBBER.ru - 2019]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * Default Server Handler
 * Not much done in this class since we use the default PHP 
 * $_SESSION handling.
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author			phpFox LLC
 * @package 		Phpfox
 * @version 		$Id: session.class.php 290 2009-03-08 18:07:34Z phpFox LLC $
 */
class Phpfox_Session_Handler_Default
{	
	/**
	 * Loads session handler. All we do here is start a session.
	 *
	 */
	public function init()
	{
		if(!isset($_SESSION))
		{
			session_start();
		}
	}
}