<?php
/**
 * [PROWEBBER.ru - 2019]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * Display a "Share" link on items
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		phpFox LLC
 * @package  		Module_Share
 * @version 		$Id: link.class.php 5442 2013-02-27 13:53:48Z phpFox LLC $
 */
class Share_Component_Block_Link extends Phpfox_Component
{
	/**
	 * Controller
	 */
	public function process()
	{
	    if (!Phpfox::getUserParam('share.can_share_items')) {
	        return false;
        }
		$sUrl = rtrim($this->getParam('url'), '/');
		$sUrl .= '/t_' . PHPFOX_TIME . '/';

		$sShareModule = $this->getParam('sharemodule');
        
		// Assign template vars passed via module call
		$this->template()->assign(array(
				'sBookmarkType' => $this->getParam('type'),
				'sBookmarkUrl' => urlencode($sUrl),
				'sBookmarkTitle' => urlencode($this->getParam('title')),
				'sBookmarkDisplay' => $this->getParam('display'),
				'bIsFirstLink' => $this->getParam('first'),
				'sFeedShareId' => $this->getParam('sharefeedid'),
				'sShareModuleId' => $sShareModule,
				'sExtraContent' => $this->getParam('extra_content', '')
			)
		);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('share.component_block_link_clean')) ? eval($sPlugin) : false);
		
		$this->clearParam('type');
	}
}