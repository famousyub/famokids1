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
 * @version 		$Id: index.class.php 6113 2013-06-21 13:58:40Z phpFox LLC $
 */
class Admincp_Component_Controller_Stat_Index extends Phpfox_Component
{
	/**
	 * Controller
	 */
	public function process()
	{
		if (($iDeleteId = $this->request()->get('delete')))
		{
			if (Phpfox::getService('core.stat.process')->delete($iDeleteId))
			{
				$this->url()->send('admincp.stat', null, _p('stat_successfully_deleted'));
			}
		}
		
		$this->template()->setTitle(_p('manage_stats'))
			->setBreadCrumb(_p('manage_stats'), $this->url()->makeUrl('admincp.stat'))
			->setHeader(array(
					'drag.js' => 'static_script',
					'<script type="text/javascript">$Behavior.coreDragInit = function() { Core_drag.init({table: \'#js_drag_drop\', ajax: \'core.statOrdering\'}); }</script>'
				)
			)
			->assign(array(
					'aStats' => Phpfox::getService('core.stat')->get()
				)
			);		
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('admincp.component_controller_stat_index_clean')) ? eval($sPlugin) : false);
	}
}