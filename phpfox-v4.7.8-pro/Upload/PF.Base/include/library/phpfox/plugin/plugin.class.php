<?php
/**
 * [PROWEBBER.ru - 2019]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * Plugins
 * Our product is built around a plug-in system that allows 3rd party
 * code to easily hook onto our core library and other modules without
 * the need to modify its code. This class takes care of creating the 
 * hook environment.
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author			phpFox LLC
 * @package 		Phpfox
 * @version 		$Id: plugin.class.php 6599 2013-09-06 08:18:37Z phpFox LLC $
 */
class Phpfox_Plugin
{
	/**
	 * ARRAY of plug-ins to be used.
	 *
	 * @var array
	 */
	public static $_aPlugins = array();

    /**
     * @var array
     */
	private static $_aValues  = [];

	public static function set()
	{		
		$aPlugins = array();	

		/** @var Phpfox_Cache_Storage_Driver $oCache */
		$oCache = Phpfox::getLib('cache');
		$iCacheId = $oCache->set('plugin_plugin');

		if ((Phpfox::getParam('core.cache_plugins') && (!(self::$_aPlugins = $oCache->getLocalFirst($iCacheId, 86000)))) || !Phpfox::getParam('core.cache_plugins'))
		{
			$oDb = Phpfox_Database::instance();
			
			$aRows = $oDb->select('p.call_name, p.php_code')
				->from(Phpfox::getT('plugin'), 'p')
				->join(Phpfox::getT('product'), 'product', 'p.product_id = product.product_id AND product.is_active = 1')
				->join(Phpfox::getT('plugin_hook'), 'ph', 'ph.call_name = p.call_name AND ph.is_active = 1')
				->join(Phpfox::getT('module'), 'm', 'm.module_id = p.module_id AND m.is_active = 1')
				->where('p.is_active = 1')
				->order('p.ordering ASC')
				->execute('getRows');				
			
			$oDb->freeResult();

			foreach ($aRows as $aRow)
			{
				$aRow['call_name'] = strtolower($aRow['call_name']);

				if (isset($aPlugins[$aRow['call_name']]))
				{
					$aPlugins[$aRow['call_name']] .= self::_cleanPhp($aRow['php_code']) . PHP_EOL;
				}
				else 
				{			
					$aPlugins[$aRow['call_name']] = self::_cleanPhp($aRow['php_code']) . PHP_EOL;
				}
			}
            foreach (Phpfox::getCoreApp()->all() as $app) {
                if (isset($app->webhooks)) {
                    foreach ($app->webhooks as $hook => $url) {
                        if (preg_match('/plugin:(.*)/i', $hook, $matches) && isset($matches[1])) {
                            $name = $matches[1];
                            $code = "(new \\Core\\Webhook('{$hook}', '{$url}'));";

                            if (isset($aPlugins[$name]))
                            {
                                $aPlugins[$name] .= $code . " \r\n ";
                            }
                            else
                            {
                                $aPlugins[$name] = $code . " \r\n ";
                            }
                        }
                    }
                }

                $dir = $app->path . 'hooks' . PHPFOX_DS;
                if (is_dir($dir)) {
                    foreach (scandir($dir) as $file) {
                        if (substr($file, -4) == '.php') {
                            $code = self::_cleanPhp(file_get_contents($dir . $file));
                            $name = substr_replace($file, '', -4);
                            if (isset($aPlugins[$name]))
                            {
                                $aPlugins[$name] .= $code . " \r\n ";
                            }
                            else
                            {
                                $aPlugins[$name] = $code . " \r\n ";
                            }
                        }
                    }
                }
            }

            $flavor_dir = flavor()->active->path . 'hooks' . PHPFOX_DS;
            if (is_dir($flavor_dir)) {
                foreach (scandir($flavor_dir) as $file) {
                    if (substr($file, -4) == '.php') {
                        $code = self::_cleanPhp(file_get_contents($flavor_dir . $file));
                        $name = substr_replace($file, '', -4);

                        if (isset($aPlugins[$name]))
                        {
                            $aPlugins[$name] .= $code . " \r\n ";
                        }
                        else
                        {
                            $aPlugins[$name] = $code . " \r\n ";
                        }
                    }
                }
            }

			$aModules = Phpfox_Module::instance()->getModules();
			foreach ($aModules as $sModule => $iModuleId)
			{
				if (is_dir(PHPFOX_DIR_MODULE . $sModule . PHPFOX_DS . PHPFOX_DIR_MODULE_PLUGIN . PHPFOX_DS))
				{
			       	if (!Phpfox::isModule($sModule))
			       	{
			       		continue;
			       	}
					
					$rHooks = opendir(PHPFOX_DIR_MODULE . $sModule . PHPFOX_DS . PHPFOX_DIR_MODULE_PLUGIN . PHPFOX_DS);
			       	while (($sHook = readdir($rHooks)) !== false)
					{
						if (substr($sHook, -4) != '.php')
						{
							continue;
						}
							
						$sHookContent = self::_cleanPhp(file_get_contents(PHPFOX_DIR_MODULE . $sModule . PHPFOX_DS . PHPFOX_DIR_MODULE_PLUGIN . PHPFOX_DS . $sHook));
						$sHookVarName = substr_replace($sHook, '', -4);
						
						if (isset($aPlugins[$sHookVarName]))
						{
							$aPlugins[$sHookVarName] .= $sHookContent . " \r\n ";
						}
						else 
						{			
							$aPlugins[$sHookVarName] = $sHookContent . " \r\n ";
						}
					}	  
					closedir($rHooks); 
				}
			}

			$hPlugin = opendir(PHPFOX_DIR_PLUGIN);
			while ($sProduct = readdir($hPlugin))
			{
				if ($sProduct == '.' || $sProduct == '..')
				{
					continue;
				}
				
				if (is_dir(PHPFOX_DIR_PLUGIN . $sProduct))
				{
					if (!Phpfox::getService('admincp.product')->isProduct($sProduct))
					{
						continue;
					}
					
					$hProduct = opendir(PHPFOX_DIR_PLUGIN . $sProduct);
					while ($sHook = readdir($hProduct))
					{
						if (substr($sHook, -4) != '.php')
						{
							continue;
						}
							
						$sHookContent = self::_cleanPhp(file_get_contents(PHPFOX_DIR_PLUGIN . $sProduct . PHPFOX_DS . $sHook));	
						$sHookVarName = substr_replace($sHook, '', -4);
						
						if (isset($aPlugins[$sHookVarName]))
						{
							$aPlugins[$sHookVarName] .= $sHookContent . " \r\n ";
						}
						else 
						{			
							$aPlugins[$sHookVarName] = $sHookContent . " \r\n ";
						}
					}
					closedir($hProduct);
				}
			}

	        foreach (array_keys($aPlugins) as $sKey)
			{
                self::$_aPlugins[$sKey] = $aPlugins[$sKey];
			}

			$oCache->saveBoth($iCacheId, self::$_aPlugins, 86000);

		}

        Phpfox::getService('user.group.setting')->loadAlias();
	}
	
	/**
	 * Get a specific plug-in.
	 *
	 * @param string $sCallName Name of the plug-in.
	 * @return mixed FALSE if we cannot find a plug-in, PHP code if we can which will then later be evaled.
	 */
	public static function get($sCallName)
	{

		if (isset(self::$_aPlugins[$sCallName]))
		{
            return self::$_aPlugins[$sCallName];
		}	

		return false;
	}
	
	/**
	 * Clean out any PHP that is causing problems when we eval the code.
	 *
	 * @param string $sHookContent PHP code to parse.
	 * @return string Fixed PHP code.
	 */
	private static function _cleanPhp($sHookContent)
	{
		$sHookContent = trim($sHookContent);		
		if (substr($sHookContent, 0, 5) == '<?php')
		{
			$sHookContent = substr_replace($sHookContent, '', 0, 5);
		}
		if (substr($sHookContent, 0, 2) == '<?')
		{
			$sHookContent = substr_replace($sHookContent, '', 0, 2);
		}
		if (substr($sHookContent, -2) == '?>')
		{
			$sHookContent = substr_replace($sHookContent, '', -2);
		}
		$sHookContent = trim($sHookContent);
		
		return $sHookContent;
	}
}