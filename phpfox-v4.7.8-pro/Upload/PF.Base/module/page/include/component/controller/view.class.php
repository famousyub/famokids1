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
 * @package  		Module_Page
 * @version 		$Id: view.class.php 3693 2011-12-06 15:19:12Z phpFox LLC $
 */
class Page_Component_Controller_View extends Phpfox_Component
{
	/**
	 * Controller
	 */
	public function process()
	{
		$oCache = Phpfox::getLib('cache');
		$sRequest = $this->request()->get('req1');
		$sCacheId = $oCache->set('page_' . md5($sRequest));
		$bIsCached = false;
		
		if (!($aPage = $oCache->get($sCacheId)))
		{
			$aPage = Phpfox::getService('page')->getPage($sRequest, true);
			$bIsCached = true;
		}		
		
		if (!isset($aPage['page_id']))
		{
			return Phpfox_Module::instance()->setController('error.404');
		}

		if (!Phpfox::isModule($aPage['module_id']) || $aPage['is_active'] == 0)
		{			
			return Phpfox_Module::instance()->setController('error.404');
		}
	
		if ($bIsCached && !$aPage['add_view'])
		{
			$oCache->save($sCacheId, $aPage);
            Phpfox::getLib('cache')->group(  'page', $sCacheId);
		}
		
		if (!empty($aPage['disallow_access']))
		{
			$aUserGroups = unserialize($aPage['disallow_access']);					
			if (in_array(Phpfox::getUserBy('user_group_id'), $aUserGroups))
			{
				$this->url()->send('subscribe');
			}
		}		

		$aPage['bookmark_url'] = $this->url()->makeUrl($aPage['title_url']);
		
		if (!$aPage['is_active'] && Phpfox::getUserParam('page.can_manage_custom_pages') && Phpfox::getUserParam('admincp.has_admin_access'))
		{
			return Phpfox_Module::instance()->setController('error.404');
		}		
		
		if ($aPage['add_view'] && Phpfox::getUserId() && !$aPage['has_viewed'])
		{
			Phpfox::getService('track.process')->add('page', $aPage['page_id']);
			Phpfox::getService('page.process')->updateView($aPage['page_id']);
		}
		
		if ($aPage['total_tag'] > 0 && Phpfox::isModule('tag'))
		{			
			$aTags = Phpfox::getService('tag')->getTagsById('page', $aPage['page_id']);
			if (isset($aTags[$aPage['page_id']]))
			{
				$aPage['tag_list'] = $aTags[$aPage['page_id']];
			}		
		}
				
		if (!empty($aPage['keyword']))
		{
			$this->template()->setMeta('keywords', $aPage['keyword']);
		}
		
		if (!empty($aPage['description']))
		{
			$this->template()->setMeta('description', $aPage['description']);	
		}		
		
		(($sPlugin = Phpfox_Plugin::get('page.component_controller_view_process')) ? eval($sPlugin) : false);
		
		$this->template()->setTitle(($aPage['is_phrase'] ? _p($aPage['title']) : $aPage['title']))
			->assign(array(
				'aPage' => $aPage
			)
		);
        return null;
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('page.component_controller_view_clean')) ? eval($sPlugin) : false);
	}
}