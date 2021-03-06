<?php
/**
 * [PROWEBBER.ru - 2019]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 *
 *
 * @copyright        [PHPFOX_COPYRIGHT]
 * @author        phpFox LLC
 * @package        Phpfox_Service
 * @version        $Id: service.class.php 67 2009-01-20 11:32:45Z phpFox LLC $
 */
class Notification_Service_Process extends Phpfox_Service
{
    /**
     * Class constructor
     */
    public function __construct()
    {
        $this->_sTable = Phpfox::getT('notification');
    }

    public function add($sType, $iItemId, $iOwnerUserId, $iSenderUserId = null, $force = false)
    {
        if ($force === false && $iOwnerUserId == Phpfox::getUserId()) {
            return true;
        }

        if ($sPlugin = Phpfox_Plugin::get('notification.service_process_add')) {
            eval($sPlugin);
        }

        if (isset($bDoNotInsert) || defined('SKIP_NOTIFICATION')) {
            return true;
        }

        $aInsert = [
            'type_id' => $sType,
            'item_id' => $iItemId,
            'user_id' => $iOwnerUserId,
            'owner_user_id' => ($iSenderUserId === null ? Phpfox::getUserId() : $iSenderUserId),
            'time_stamp' => time()
        ];

        // Edit code for cloud message.
        $iId = $this->database()->insert($this->_sTable, $aInsert);

        if ($sPlugin = Phpfox_Plugin::get('notification.service_process_add_end')) {
            eval($sPlugin);
        }

        return true;
    }

    public function delete($sType, $iItemId, $iUserId)
    {
        $this->database()->delete($this->_sTable, "type_id = '" . $this->database()->escape($sType) . "' AND item_id = " . (int)$iItemId . " AND user_id = " . (int)$iUserId);

        return true;
    }

    public function deleteByOwner($sType, $iItemId, $iUserId)
    {
        $this->database()->delete($this->_sTable, "type_id = '" . $this->database()->escape($sType) . "' AND owner_user_id = " . (int)$iItemId . " AND user_id = " . (int)$iUserId);

        return true;
    }

    public function deleteAllOfItem($sTypes, $iItemId)
    {
        if (is_array($sTypes)) {
            $sTypes = implode(',', array_map(function ($sType) {
                $sType = $this->database()->escape($sType);
                return "'{$sType}'";
            }, $sTypes));
        }
        $sTypes = trim($sTypes, ',');
        $this->database()->delete($this->_sTable, "type_id IN (" . $sTypes . ") AND item_id = " . (int)$iItemId);

        return true;
    }

    public function deleteById($iId)
    {
        $this->database()->delete($this->_sTable, 'notification_id = ' . (int)$iId . ' AND user_id = ' . Phpfox::getUserId());

        return true;
    }

    public function updateSeen($iId)
    {
        $this->database()->update($this->_sTable, ['is_seen' => 1], 'notification_id = ' . (int)$iId . ' AND user_id = ' . Phpfox::getUserId());
    }

    public function markAllRead()
    {
        db()->update($this->_sTable, ['is_read' => 1], 'user_id = ' . Phpfox::getUserId());
    }

    public function markAsRead($iNotificationId)
    {
        db()->update($this->_sTable, ['is_read' => 1], ['notification_id' => $iNotificationId]);
    }

    public function hide($iId)
    {
        $this->database()->delete($this->_sTable, 'notification_id = ' . (int)$iId . ' AND user_id = ' . Phpfox::getUserId());

        return true;
    }

    public function deleteAll()
    {
        $this->database()->delete($this->_sTable, 'user_id = ' . Phpfox::getUserId());

        return true;
    }


    /**
     * If a call is made to an unknown method attempt to connect
     * it to a specific plug-in with the same name thus allowing
     * plug-in developers the ability to extend classes.
     *
     * @param string $sMethod is the name of the method
     * @param array $aArguments is the array of arguments of being passed
     */
    public function __call($sMethod, $aArguments)
    {
        /**
         * Check if such a plug-in exists and if it does call it.
         */
        if ($sPlugin = Phpfox_Plugin::get('notification.service_process__call')) {
            return eval($sPlugin);
        }

        /**
         * No method or plug-in found we must throw a error.
         */
        Phpfox_Error::trigger('Call to undefined method ' . __CLASS__ . '::' . $sMethod . '()', E_USER_ERROR);
    }
}