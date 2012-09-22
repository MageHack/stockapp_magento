<?php
class Meanbee_StockUpdating_Helper_Config extends Mage_Core_Helper_Abstract {
    const XML_ENABLED = 'cataloginventory/meanbee_stockupdating/active';
    const XML_API_KEY = 'cataloginventory/meanbee_stockupdating/api_key';
    const XML_BARCODE = 'cataloginventory/meanbee_stockupdating/barcode_attribute';

    /**
     * @return bool
     */
    public function isActive() {
        return Mage::getStoreConfigFlag(self::XML_ENABLED);
    }

    /**
     * @return string
     */
    public function getApiKey() {
        return Mage::getStoreConfig(self::XML_API_KEY);
    }

    /**
     * @return string
     */
    public function getBarcodeAttribute() {
        return Mage::getStoreConfig(self::XML_BARCODE);
    }
}