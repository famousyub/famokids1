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
 * @package 		Phpfox_Component
 * @version 		$Id: index.class.php 3002 2011-09-04 16:55:01Z phpFox LLC $
 */
class Link_Component_Controller_Index extends Phpfox_Component
{
	/**
	 * Controller
	 */
	public function process()
	{
		if (($aLink = Phpfox::getService('link')->getLinkById($this->request()->getInt('req2'))))
		{
		    if(isset($aLink['redirect_link'])) {
                $this->url()->send($aLink['redirect_link']);
            }
            else {
                $this->url()->send($aLink['user_name'], array('link-id' => $aLink['link_id']));
            }
		}		
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('link.component_controller_index_clean')) ? eval($sPlugin) : false);
	}
}