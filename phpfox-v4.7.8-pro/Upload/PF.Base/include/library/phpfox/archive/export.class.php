<?php
/**
 * [PROWEBBER.ru - 2019]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * Used to export data such as a 3rd party product or language package and
 * compress it into a ZIP archive and force the user to download the package
 * on the spot.
 *
 * An example of how we would compress a language package and then send it to the user:
 * <code>
 * Phpfox::getLib('archive.export')->download('language-package', 'zip', 'english1');
 * </code>
 *
 * @copyright        [PHPFOX_COPYRIGHT]
 * @author            phpFox LLC
 * @package        Phpfox
 * @version        $Id: export.class.php 4316 2012-06-21 13:57:37Z phpFox LLC $
 */
class Phpfox_Archive_Export
{
    /**
     * Supported methods of download for the specific data we plan on passing to the user
     *
     * @var array
     */
    private $_aArchives = [];

    /**
     * Constructor
     *
     */
    public function __construct()
    {
    }

    /**
     * @return Phpfox_Archive_Export
     */
    public static function instance()
    {
        return Phpfox::getLib('archive.export');
    }

    /**
     * Set all the support archives you want to allow the user to download the data
     *
     * @param array $aArchives Array of support archives
     * @return Phpfox_Archive_Export
     */
    public function set($aArchives)
    {
        foreach ($aArchives as $sArchive) {
            if ($sArchive != 'xml') {
                $aSupported = Phpfox::getLib('archive.support')->get($sArchive);
                if (!Phpfox::getLib('archive.extension.' . $aSupported['class'])->test()) {
                    continue;
                }
            }

            $this->_aArchives[] = $sArchive;
        }

        (($sPlugin = Phpfox_Plugin::get('archive_export_set')) ? eval($sPlugin) : false);

        return $this;
    }

    /**
     * Based on the supported archives allowed with the set() method this returns all of them
     * but based on what the server can actually support as well.
     *
     * @return array List of all the allowed archive.
     */
    public function getSupported()
    {
        return $this->_aArchives;
    }

    /**
     * Method used to compress data and then send it to the user to download on the spot.
     *
     * @param string $sName Name of the archive
     * @param string $sExt File extension of the archive (zip, tar.gz, xml)
     * @param string $sFolder Folder to compress. Must be located within the "file/cache/" folder.
     * @return bool Only returns false if we were unable to compress the data
     */
    public function download($sName, $sExt, $sFolder, $iServerId = 0)
    {
        if (!($sNewFile = Phpfox::getLib('phpfox.archive')->get($sExt)->compress($sName, $sFolder))) {
            return false;
        }

        Phpfox::getLib('cdn')->put($sNewFile);

        if (is_dir(PHPFOX_DIR_CACHE . $sFolder . PHPFOX_DS)) {
            Phpfox_File::instance()->delete_directory(PHPFOX_DIR_CACHE . $sFolder . PHPFOX_DS);
        }

        (($sPlugin = Phpfox_Plugin::get('archive_export_download')) ? eval($sPlugin) : false);

        Phpfox_File::instance()->forceDownload($sNewFile, $sName . '.' . $sExt, '', '', $iServerId);
        return null;
    }
}