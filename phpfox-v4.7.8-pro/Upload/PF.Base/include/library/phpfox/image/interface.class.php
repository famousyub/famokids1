<?php
/**
 * [PROWEBBER.ru - 2019]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * Image Manipulation Library Template
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author			phpFox LLC
 * @package 		Phpfox
 * @version 		$Id: interface.class.php 1666 2010-07-07 08:17:00Z phpFox LLC $
 */
interface Phpfox_Image_Interface
{
	/**
	 * Create a thumbnail for an image
	 *
	 * @param string $sImage Full path of the original image
	 * @param string $sDestination Full path for the newly created thumbnail
	 * @param int $nMaxW Max width of the thumbnail
	 * @param int $nMaxH Max height of the thumbnail
	 * @param bool $bRatio TRUE to keep the aspect ratio and FALSE to not keep it
	 * @param bool $bSkipCdn Skip the CDN routine
	 * @return mixed FALSE on failure, TRUE or NULL on success
	 */	
	public function createThumbnail($sImage, $sDestination, $nMaxW, $nMaxH);	
}