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
 * @version 		$Id: backup.class.php 1268 2009-11-23 20:45:36Z phpFox LLC $
 */
class Admincp_Component_Controller_Sql_Backup extends Phpfox_Component
{
	/**
	 * Controller
	 */
	public function process()
	{
        $bCanBackup = Phpfox_Database::instance()->canBackup();
        $sDefaultPath = PHPFOX_DIR_FILE . 'log' . PHPFOX_DS;   
        
        if (($sPath = $this->request()->get('path')) && $bCanBackup)
        {
        	if (($sBackupPath = Phpfox_Database::instance()->backup($sPath)))
        	{
        		$this->url()->send('admincp.sql.backup', null, _p('sql_backup_successfully_created_and_can_be_downloaded_here_path', array('path' => $sBackupPath)));
        	}
        }
		
		$this->template()->setTitle(_p('sql_maintenance_title'))
        	->setBreadCrumb(_p('sql_maintenance_title'), $this->url()->makeUrl('admincp.sql'))
        	->setBreadCrumb(_p('backup'), null, true)
        	->assign(array(
        		'bCanBackup' => $bCanBackup,
        		'sDefaultPath' => $sDefaultPath
        	)
        );		
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('admincp.component_controller_sql_backup_clean')) ? eval($sPlugin) : false);
	}
}