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
 * @version 		$Id: index.class.php 7084 2014-02-03 14:00:47Z Fern $
 */
class Admincp_Component_Controller_Sql_Index extends Phpfox_Component
{
	/**
	 * Controller
	 */
	public function process()
	{
		if (($aTables = $this->request()->getArray('tables')))
		{
			if ($this->request()->get('optimize'))
			{
				foreach ($aTables as $sTable)
				{
					Phpfox_Database::instance()->optimizeTable($sTable);
				}
				
				$this->url()->send('admincp.sql', null, _p('table_s_successfully_optimized'));
			}
			elseif ($this->request()->get('repair'))
			{
				foreach ($aTables as $sTable)
				{
					Phpfox_Database::instance()->repairTable($sTable);
				}
				
				$this->url()->send('admincp.sql', null, _p('table_s_successfully_repaired'));
			}			
		}
		
		$aItems = Phpfox_Database::instance()->getTableStatus();
        if ($aItems === false)
        {
            return Phpfox_Error::display(_p('Sorry but this feature isn\'t supported for this database driver: {{ driver }}', ['driver' => db()->getServerInfo()]));
        }
        $iSize = 0;
        $iOverhead = 0;
        foreach ($aItems as $iKey => $aItem)
        {
        	$iSize += $aItem['Data_length'];
            $iOverhead += $aItem['Data_free'];
        }
		
        $this->template()->setTitle(_p('sql_maintenance_title'))
        	->setBreadCrumb(_p('sql_maintenance_title'), $this->url()->makeUrl('admincp.sql'))
        	->assign(array(
        		'aItems' => $aItems,
            	'iSize' => $iSize,
            	'iOverhead' => $iOverhead,
            	 'iCnt' => count($aItems)
        	)
        );
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('admincp.component_controller_sql_index_clean')) ? eval($sPlugin) : false);
	}
}