<?php
class Meanbee_StockUpdating_Test_Controller_Api extends EcomDev_PHPUnit_Test_Case_Controller {
    public function testSuccessfulUpdate() {
        $this->getRequest()->setQuery(array('barcode' => '123', 'qty' => 2));
        $this->dispatch('stockupdate/api/update');
        $this->assertResponseBodyJsonMatch(array('status' => 'OK'));
    }

    public function testBarcodeRequired() {
        $this->getRequest()->setQuery(array('qty' => 2));
        $this->dispatch('stockupdate/api/update');
        $this->assertResponseBodyJsonMatch(array('status' => 'ERROR'));
    }

    public function testQtyRequired() {
        $this->getRequest()->setQuery(array('barcode' => '123'));
        $this->dispatch('stockupdate/api/update');
        $this->assertResponseBodyJsonMatch(array('status' => 'ERROR'));
    }
}