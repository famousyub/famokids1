<?php
/**
 * [PROWEBBER.ru - 2019]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * Image Manipulation Library Loader
 * Loads the specified image manipulation library to be used based on admin settings.
 * Classes can be found: include/library/phpfox/image/library/
 * By default we use: GD
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author			phpFox LLC
 * @package 		Phpfox
 * @version 		$Id: image.class.php 1666 2010-07-07 08:17:00Z phpFox LLC $
 */
class Phpfox_Image
{
	/**
	 * Object for the image library
	 *
	 * @var object
	 */
	private static $_oObject = null;

	/**
	 * Class constructor. We load the image library the admin decided to use on their site.
	 *
	 */
	public function __construct()
	{
		if (!self::$_oObject)
		{			
			$sDriver = 'phpfox.image.library.gd';

			self::$_oObject = Phpfox::getLib($sDriver);
		}
	}	
	
	/**
	 * Returns the object of the image library we are using
	 *
	 * @return Phpfox_Image_Library_Gd
	 */
	public function &getInstance()
	{
		return self::$_oObject;
	}

    /**
     * @return Phpfox_Image_Library_Gd
     */
    public function factory()
    {
        return self::$_oObject;
	}

	/**
	 * @return Phpfox_Image_Library_Gd
	 */
	public static function instance() {
		if (!self::$_oObject) {
			new self();
		}

		return self::$_oObject;
	}
}