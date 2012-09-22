<?php
class Meanbee_StockUpdating_ApiController extends Mage_Core_Controller_Front_Action {
    public function preDispatch() {
        parent::preDispatch();

        $api_key = $this->getRequest()->getHeader('X-Api-Key');

        if ($api_key === false || $api_key != $this->_getConfig()->getApiKey()) {
            $this->setFlag('', self::FLAG_NO_DISPATCH, true);
            return $this->_error('Invalid credentials provided', 401);
        }
    }

    public function updateAction() {
        $barcode = $this->getRequest()->getParam('barcode');
        $qty     = $this->getRequest()->getParam('qty');

        if (empty($barcode)) {
            return $this->_error('Barcode required');
        }

        if (empty($qty)) {
            return $this->_error('Qty required');
        }

        if (!$this->_getHelper()->doesBarcodeAttributeExist()) {
            return $this->_error('Barcode attribute does not exist');
        }

        try {
            /** @var $product Mage_Catalog_Model_Product */
            $product = Mage::getModel('catalog/product')->loadByAttribute($this->_getConfig()->getBarcodeAttribute(), $barcode);

            if (!$product || !$product->getId()) {
                return $this->_error('Product not found');
            }

            /**
             * Get current stock level
             *
             * @var $stock_data Mage_CatalogInventory_Model_Stock_Item
             */
            $stock_data = Mage::getModel('cataloginventory/stock_item')->loadByProduct($product);
            $stock_data->addQty($qty);
            $stock_data->save();

            return $this->_success('Product (' . $product->getName() . ') updated successfully');
        } catch (Exception $e) {
            return $this->_error('An exception occurred: ' . $e->getMessage());
        }
    }

    protected function _error($message, $code = 403) {
        $this->_getHelper()->log("ERROR: $code - $message", Zend_Log::ERR);
        return $this->_return('ERROR', $message, $code);
    }

    protected function _success($message) {
        $this->_getHelper()->log("SUCCESS: $message", Zend_Log::INFO);
        return $this->_return('OK', $message, 200);
    }

    protected function _return($status, $message, $code) {
        $this->getResponse()->setHttpResponseCode($code);
        $this->getResponse()->setHeader('Content-type', 'application/json');
        $this->getResponse()->setBody(
            Zend_Json::encode(array(
                'status' => $status,
                'message' => $message
            ))
        );
    }

    /**
     * @return Meanbee_StockUpdating_Helper_Config
     */
    protected function _getConfig() {
        return Mage::helper('meanbee_stockupdating/config');
    }

    /**
     * @return Meanbee_StockUpdating_Helper_Data
     */
    protected function _getHelper() {
        return Mage::helper('meanbee_stockupdating');
    }
}