<?php
/**
 * @author: A.A.Treitjak
 * @copyright: 2012 - 2013 BelVG.com
 */

class Belvg_Cartclear_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * Configurate key
     */
    const XML_CONFIG_PATH = 'belvg_cartclear/settings/';

    /**
     * Check module.
     *
     * @param null $store
     *
     * @return bool
     */
    public function isEnabled($store = NULL)
    {
        return (bool) $this->_getConfigValue('enabled', $store);
    }

    public function getConfigValue($key, $store = '')
    {
        return $this->_getConfigValue($key, $store);
    }

    protected function _getConfigValue($key, $store = NULL)
    {
        return Mage::getStoreConfig(self::XML_CONFIG_PATH . $key, $store);
    }
}