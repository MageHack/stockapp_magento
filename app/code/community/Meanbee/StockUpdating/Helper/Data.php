<?php
class Meanbee_StockUpdating_Helper_Data extends Mage_Core_Helper_Data {
    /**
     * @TODO Refactor.
     *
     * @return bool
     */
    public function doesBarcodeAttributeExist() {
        if ($this->_loadCache(Meanbee_StockUpdating_Helper_Cache::KEY_BARCODE_FOUND)) return true;

        /** @var $config Meanbee_StockUpdating_Helper_Config */
        $config = Mage::helper('meanbee_stockupdating/config');
        $attributes = Mage::getModel('catalog/product')->getAttributes();

        foreach ($attributes as $attribute) {
            if ($attribute->getAttributeCode() == $config->getBarcodeAttribute()) {
                $this->_saveCache(true, Meanbee_StockUpdating_Helper_Cache::KEY_BARCODE_FOUND);
                return true;
            }
        }

        return false;
    }

    public function log($message, $log = Zend_Log::DEBUG) {
        Mage::log($message, $log, 'meanbee_stockupdating.log', true);
    }
}