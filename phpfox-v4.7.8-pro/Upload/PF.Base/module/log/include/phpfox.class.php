<?php
/**
 * [PROWEBBER.ru - 2019]
 */

defined('PHPFOX') or exit('NO DICE!');

class Module_Log 
{
	public static $aDevelopers = array(
		array(
			'name' => 'phpFox LLC',
			'website' => ''
		)
	);
	
	public static $aTables = array(
		'session',
		'log_session',
		'log_staff',
		'log_view'
	);
}