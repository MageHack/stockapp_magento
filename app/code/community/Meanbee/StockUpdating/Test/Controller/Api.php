<?php
class Meanbee_StockUpdating_Test_Controller_Api extends EcomDev_PHPUnit_Test_Case_Controller {

    public function setUp() {
        parent::setUp();

        $this->_setupMockObjects();;
    }

    /**
     * @loadFixture ~/general.yaml
     */
    public function testAuthFailure() {
        $this->getRequest()->setHeader('X-Api-Key', 'thisisNOTmyapikey');
        $this->getRequest()->setQuery(array('barcode' => '123', 'qty' => 2));
        $this->dispatch('stockupdate/api/update');
        $this->assertResponseBodyJsonMatch(array('status' => 'ERROR', 'message' => 'Invalid credentials provided'));
    }

    /**
     * @fixture ~/general.yaml
     */
    public function testAuthSuccess() {
        $this->getRequest()->setHeader('X-Api-Key', 'thisismyapikey');
        $this->getRequest()->setQuery(array('barcode' => '123', 'qty' => 2));
        $this->dispatch('stockupdate/api/update');
        $this->assertResponseBodyJsonMatch(array('status' => 'OK'));
    }

    /**
     * @fixture ~/general.yaml
     */
    public function testBarcodeRequired() {
        $this->getRequest()->setHeader('X-Api-Key', 'thisismyapikey');
        $this->getRequest()->setQuery(array('qty' => 2));
        $this->dispatch('stockupdate/api/update');
        $this->assertResponseBodyJsonMatch(array('status' => 'ERROR'));
    }

    /**
     * @fixture ~/general.yaml
     */
    public function testQtyRequired() {
        $this->getRequest()->setHeader('X-Api-Key', 'thisismyapikey');
        $this->getRequest()->setQuery(array('barcode' => '123'));
        $this->dispatch('stockupdate/api/update');
        $this->assertResponseBodyJsonMatch(array('status' => 'ERROR'));
    }

    /**
     * @fixture ~/general.yaml
     */
    public function testStockUpdated() {

        $stock_model = $this->getModelMock('cataloginventory/stock_item', array('addQty'));
        $stock_model->expects($this->once())
            ->method('addQty')
            ->will($this->returnValue(true));
        $this->replaceByMock('model', 'cataloginventory/stock_item', $stock_model);

        $this->getRequest()->setHeader('X-Api-Key', 'thisismyapikey');
        $this->getRequest()->setQuery(array('barcode' => '123', 'qty' => 2));
        $this->dispatch('stockupdate/api/update');
        $this->assertResponseBodyJsonMatch(array('status' => 'OK'));
    }

    protected function _setupMockObjects() {
        $helper = $this->getHelperMock('meanbee_stockupdating/data');
        $helper->expects($this->any())
            ->method('doesBarcodeAttributeExist')
            ->will($this->returnValue(true));

        $this->replaceByMock('helper', 'meanbee_stockupdating', $helper);

        $product_model = $this->getModelMock('catalog/product');
        $product_model->expects($this->any())
            ->method('getId')
            ->will($this->returnValue(1));
        $product_model->expects($this->any())
            ->method('loadByAttribute')
            ->will($this->returnValue($product_model));

        $this->replaceByMock('model', 'catalog/product', $product_model);
    }
}