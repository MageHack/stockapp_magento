<?php
class Meanbee_StockUpdating_Model_System_Config_Source_Attribute {
    public function toOptionArray() {
        $options = array(array('label' => '', 'value' => ''));

        $attributes = Mage::getModel('catalog/product')->getAttributes();
        foreach ($attributes as $attribute) {
            $options[] = array(
                'label' => $attribute->getAttributeCode(),
                'value' => $attribute->getAttributeCode()
            );
        }
        
        return $options;
    }
}