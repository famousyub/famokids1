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
 * @package  		Module_Language
 * @version 		$Id: file.class.php 852 2009-08-10 18:05:32Z phpFox LLC $
 */
class Language_Component_Controller_Admincp_File extends Phpfox_Component 
{
	/**
	 * Controller
	 */
	public function process()
	{	
		Phpfox::getUserParam('language.can_manage_lang_packs', true);
		
		$aValidExt = array(
			'xml',
			'zip',
			'tar.gz'
		);		
		
		$oArchiveExport = Phpfox::getLib('archive.export')->set($aValidExt);		
		$oArchiveImport = Phpfox::getLib('archive.import')->set($aValidExt);		
		
		// Run the export routine
		if ($aVals = $this->request()->getArray('val'))
		{
			if ($sXml = Phpfox::getService('language')->export($aVals['language_id']))
			{
				$oArchiveExport->download($aVals['file_extension'], 'phpfox_language.xml', $sXml);
			}
		}

		// Run the import routine
		if ($this->request()->get('import'))
		{
			$aFile = $this->request()->get('file');
			
			if (isset($sXmlData) || ($sXmlData = $oArchiveImport->process($aFile)))
			{			
				$aParams = Phpfox::getLib('xml.parser')->parse($sXmlData);
				
				// Import the settings
				if (($iImported = Phpfox::getService('language.process')->import($aParams, ($this->request()->get('missing_phrases') ? true : false))))
				{
					// Settings imported, mention how many settings were imported.
					$this->url()->send('admincp', array('language', 'file'), _p('language_package_successfully_imported'));
				}				
			}
		}
		
		$aImports = array();

		// Assign needed vars to the template
		$this->template()->assign(array(
			'aProducts' => Phpfox::getService('admincp.product')->get(),
			'aLanguages' => Phpfox::getService('language')->get(),
			'aArchives' => $oArchiveExport->getSupported(),
			'sSupported' => $oArchiveImport->getSupported(),
			'aImports' => (isset($aImports['language']) ? $aImports['language'] : array())
		))->setBreadCrumb(_p('import_export'))
			->setTitle(_p('import_export'));
			
		(($sPlugin = Phpfox_Plugin::get('language.component_controller_admincp_file_process')) ? eval($sPlugin) : false);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('language.component_controller_admincp_file_clean')) ? eval($sPlugin) : false);
	}
}