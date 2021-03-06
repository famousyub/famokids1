<?php
/**
 * [PROWEBBER.ru - 2019]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * Module Service Parent
 * This class is the parent class for all module services. Services handle all database
 * interactions and any PHP logic outside the scope of a component (block/controller).
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author			phpFox LLC
 * @package 		Phpfox
 * @version 		$Id: service.class.php 2323 2011-03-03 18:24:00Z phpFox LLC $
 */
class Phpfox_Service
{	
	/**
	 * Holds the default database table we are working with in this service.
	 *
	 * @var string
	 */
	protected $_sTable;

	/**
	 * @return $this
     * @deprecated  since 4.7.0
	 */
	public static function instance() {
		$name = get_called_class();
		$name = strtolower($name);
		$name = str_replace('service_', '', $name);
		$parts = explode('_', $name);
        if (isset($parts[0]) && !Phpfox::isModule($parts[0]) && !defined('PHPFOX_INSTALLER')){
          return null;
        }
		if (count($parts) > 2) {
			if ($parts[1] == $parts[2]) {
				unset($parts[2]);
			}
		}
		$className = implode('.', $parts);
		return Phpfox::getService($className);
	}
	    
	/**
	 * Extends the database object.
	 *
	 * @see Phpfox_Database
	 * @return Phpfox_Database_Driver_Mysql
	 */
    protected function database()
    {
    	return Phpfox_Database::instance();
    }
    
    /**
     * Extends the cache object
     *
     * @see Phpfox_Cache
     * @return Phpfox_Cache_Abstract
     */
    protected function cache()
    {
    	return Phpfox::getLib('cache');
    }
    
    /**
     * Extends the pre-parsing object.
     *
     * @see Phpfox_Parse_Input
     * @return Phpfox_Parse_Input
     */
    protected function preParse()
    {
    	return Phpfox::getLib('parse.input');
    }
    
    /**
     * Extends the validation/sanity check object.
     *
     * @see Phpfox_Validator
     * @return Phpfox_Validator
     */
    protected function validator()
    {
    	return Phpfox_Validator::instance();
    }
    
    /**
     * Extends the search check object.
     *
     * @see Phpfox_Search
     * @return Phpfox_Search
     */    
    protected function search()
    {
    	return Phpfox_Search::instance();
    }
    
	/**
	 * Extends the request class and returns its class object.
	 *
	 * @see Phpfox_Request
	 * @return Phpfox_Request
	 */
	protected function request()
	{
		return Phpfox_Request::instance();
	}	    
}