<?php
/**
 * [PROWEBBER.ru - 2019]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * Class Phpfox_Queue
 */
class Phpfox_Queue
{
    /**
     * @return \Core\Queue\Manager
     */
    public static function instance()
    {
        return \Core\Queue\Manager::instance();
    }
}