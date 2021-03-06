<?php
/**
 * [PROWEBBER.ru - 2019]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * Handles archives such as zip and tar.gz.
 * 
 * Example to compress a ZIP archive:
 * <code>
 * Phpfox::getLib('archive', 'zip')->compress('foo', 'bar');
 * </code>
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author			phpFox LLC
 * @package 		Phpfox
 * @version 		$Id: archive.class.php 1666 2010-07-07 08:17:00Z phpFox LLC $
 */
class Phpfox_Archive
{
	/**
	 * Holds the object of the extension class depending on what sort of archive
	 * we are working with.
	 *
	 * @var object
	 */
	private $_oObject = null;

    public function factory()
    {
        return $this;
	}

    public function get($sExt)
    {
        switch ($sExt)
        {
            case 'zip':
                $sObject = 'phpfox.archive.extension.zip';
                break;
            case 'tar.gz':
                $sObject = 'phpfox.archive.extension.tar';
                break;
            case 'xml':
                $sObject = 'phpfox.archive.extension.xml';
                break;
            default:
                $sObject = 'phpfox.archive.extension.zip';
        }

        return Phpfox::getLib($sObject);
	}
	
	/**
	 * Return the object of the extension class.
	 *
	 * @return object Object provided by the extension class we loaded earlier.
	 */
	public function &getInstance()
	{
		return $this->_oObject;
	}
}