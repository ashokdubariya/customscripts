<?php
class Linksture_Deletecreditmemo_Adminhtml_DeletecreditmemoController extends Mage_Adminhtml_Controller_Action
{

	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('deleteorder/items')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));
		
		return $this;
	}   
    
    protected function _initCreditmemo() {
        $id = $this->getRequest()->getParam('creditmemo_id');
        $creditmemo = Mage::getModel('sales/order_creditmemo')->load($id);

        if (!$creditmemo->getId()) {
            $this->_getSession()->addError($this->__('This Credit Memo no longer exists.'));
            $this->_redirect('*/*/');
            $this->setFlag('', self::FLAG_NO_DISPATCH, true);
            return false;
        }
        Mage::register('sales_creditmemo', $creditmemo);
        Mage::register('current_creditmemo', $creditmemo);
        return $creditmemo;
    }

	public function indexAction() {
		$this->_initAction()->renderLayout();
	}

	public function deleteAction() {
		if($creditmemo = $this->_initCreditmemo()) {
			try {
     		    /* $creditmemo->delete(); */
				if($this->_remove($this->getRequest()->getParam('creditmemo_id'))){
					$creditmemo->delete();
					Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Credit Memo was successfully deleted'));
					$this->_redirectUrl(Mage::helper('adminhtml')->getUrl('adminhtml/sales_creditmemo'));
				}
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('creditmemo_ids')));
			}
		}
		$this->_redirectUrl(Mage::helper('adminhtml')->getUrl('adminhtml/sales_creditmemo/index'));
	}

    public function massDeleteAction() {
        $creditmemoIds = $this->getRequest()->getParam('creditmemo_ids');
		if(!is_array($creditmemoIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
                foreach ($creditmemoIds as $creditmemoId) {
					if($this->_remove($creditmemoId)){
						Mage::getModel('sales/order_creditmemo')->load($creditmemoId)->delete()->unsetAll();
					}
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($creditmemoIds)
                    )
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
		$this->_redirectUrl(Mage::helper('adminhtml')->getUrl('adminhtml/sales_creditmemo/index'));
    }
	
	public function _remove($creditmemo_id) {
		$creditmodel 		=  Mage::getModel('sales/order_creditmemo')->load($creditmemo_id);		
		$credit_items_model 	=  Mage::getModel('sales/order_creditmemo_item')->getCollection()
							      ->addAttributeToFilter('parent_id', $creditmemo_id);
		 
		foreach($credit_items_model as $credit_item_model)
		{
			
			$refunded_qty 		=  $credit_item_model->getQty();
			$order_item_id		=  $credit_item_model->getOrderItemId();
			$order_item 		=   Mage::getModel('sales/order_item')->load($order_item_id);
		
			$order_producttype  =  $order_item->getProductType();
			$order_qty_refunded =  $order_item->getQtyRefunded();
			$qty_refunded 		=  ($order_qty_refunded - $refunded_qty);
			if($qty_refunded >= 0.0000) {
				$order_item->setQtyRefunded($qty_refunded); 
				$order_item->save();
			}
		} 
		/* echo $refunded_qty ."-----". $order_item_id; exit; */
		/* sales/order_creditmemo_item */
		$orderId	 	=  $creditmodel->getOrderId(); 
		$ordermodel	 	=  Mage::getModel('sales/order')->load($orderId);
		
		/***** Credit memo Table fields *****/
		
		$refund_basediscountamount 		= $creditmodel->getBaseDiscountAmount();
		$refund_baseshippingamount 		= $creditmodel->getBaseShippingAmount();
		$refund_baseshippingtaxamount 	= $creditmodel->getBaseShippingTaxAmount();
		$refund_basesubtotal 			= $creditmodel->getBaseSubtotal();
		$refund_basetaxamount		 	= $creditmodel->getBaseTaxAmount();
		$refund_basegrandtotal 			= $creditmodel->getBaseGrandTotal();
		$refund_discountamount 			= $creditmodel->getDiscountAmount();
		$refund_shippingamount 			= $creditmodel->getShippingAmount();
		$refund_shippingtaxamount 		= $creditmodel->getShippingTaxAmount();
		$refund_subtotal		 		= $creditmodel->getSubtotal();
		$refund_taxamount		 		= $creditmodel->getTaxAmount();
		$refund_grandtotal		 		= $creditmodel->getGrandTotal();
		
		/***** Order Table fields *****/
		
		$order_basediscountrefunded  	= $ordermodel->getBaseDiscountRefunded();
		$order_baseshippingrefunded  	= $ordermodel->getBaseShippingRefunded();
		$order_baseshippingtaxrefunded  = $ordermodel->getBaseShippingTaxRefunded();
		$order_basesubtotalrefunded  	= $ordermodel->getBaseSubtotalRefunded();
		$order_basetaxrefunded  		= $ordermodel->getBaseTaxRefunded();
		$order_basetotalofflinerefunded = $ordermodel->getBaseTotalOfflineRefunded();
		$order_basetotalonlinerefunded  = $ordermodel->getBaseTotalOnlineRefunded();
		$order_basetotalrefunded  		= $ordermodel->getBaseTotalRefunded();
		$order_discountrefunded  		= $ordermodel->getDiscountRefunded();
		$order_shippingrefunded  		= $ordermodel->getShippingRefunded();
		$order_shippingtaxrefunded 		= $ordermodel->getShippingTaxRefunded();
		$order_subtotalrefunded  		= $ordermodel->getSubtotalRefunded();
		$order_taxrefunded  			= $ordermodel->getTaxRefunded();
		$order_totalofflinerefunded  	= $ordermodel->getTotalOfflineRefunded();
		$order_totalonlinerefunded  	= $ordermodel->getTotalOnlineRefunded();
		$order_totalrefunded  			= $ordermodel->getTotalRefunded();
		
		/************** Check difference in order and creditmemo detail **********/
		
		$base_discount_refunded 		= $order_basediscountrefunded - $refund_basediscountamount;
		$base_shipping_refunded 		= $order_baseshippingrefunded - $refund_baseshippingamount;
		$base_shipping_tax_refunded 	= $order_baseshippingtaxrefunded - $refund_baseshippingtaxamount;
		$base_subtotal_refunded			= $order_basesubtotalrefunded - $refund_basesubtotal;
		$base_tax_refunded				= $order_basetaxrefunded - $refund_basetaxamount;
		$base_total_offline_refunded 	= $order_basetotalofflinerefunded - $refund_basegrandtotal;
		$base_total_online_refunded		= $order_basetotalonlinerefunded - $refund_basegrandtotal;
		$base_total_refunded			= $order_basetotalrefunded - $refund_basegrandtotal;
		$discount_refunded				= $order_discountrefunded - $refund_discountamount;
		$shipping_refunded				= $order_shippingrefunded - $refund_shippingamount;
		$shipping_tax_refunded			= $order_shippingtaxrefunded - $refund_shippingtaxamount;
		$subtotal_refunded				= $order_subtotalrefunded - $refund_subtotal;
		$tax_refunded					= $order_taxrefunded - $refund_taxamount;
		$total_offline_refunded			= $order_totalofflinerefunded - $refund_grandtotal;
		$total_online_refunded			= $order_totalonlinerefunded - $refund_grandtotal;
		$total_refunded					= $order_totalrefunded - $refund_grandtotal;
		
		if($base_discount_refunded == 0.0000)
		{
			$ordermodel->setBaseDiscountRefunded(Null);
		}
		else
		{
			if($base_discount_refunded > 0.0000){
				$ordermodel->setBaseDiscountRefunded($base_discount_refunded);
			}
		}
		
		if($base_shipping_refunded == 0.0000)
		{
			$ordermodel->setBaseShippingRefunded(Null);
		}
		else
		{
			if($base_shipping_refunded > 0.0000){
				$ordermodel->setBaseShippingRefunded($base_shipping_refunded);
			}
		}
		
		if($base_shipping_tax_refunded == 0.0000)
		{
			$ordermodel->setBaseShippingTaxRefunded(Null);
		}
		else
		{
			if($base_shipping_tax_refunded > 0.0000){
				$ordermodel->setBaseShippingTaxRefunded($base_shipping_tax_refunded);
			}
		}
		
		if($base_subtotal_refunded == 0.0000)
		{
			$ordermodel->setBaseSubtotalRefunded(Null);
		}
		else
		{
			if($base_subtotal_refunded > 0.0000){
				$ordermodel->setBaseSubtotalRefunded($base_subtotal_refunded);
			}
		}
		
		if($base_tax_refunded == 0.0000)
		{
			$ordermodel->setBaseTaxRefunded(Null);
		}
		else
		{
			if($base_tax_refunded > 0.0000){
				$ordermodel->setBaseTaxRefunded($base_tax_refunded);
			}
		}
		
		if($base_total_offline_refunded == 0.0000)
		{
			$ordermodel->setBaseTotalOfflineRefunded(Null);
		}
		else
		{
			if($base_total_offline_refunded > 0.0000){
				$ordermodel->setBaseTotalOfflineRefunded($base_total_offline_refunded);
			}
		}
		
		if($base_total_online_refunded == 0.0000)
		{
			$ordermodel->setBaseTotalOnlineRefunded(Null);
		}
		else
		{
			if($base_total_online_refunded > 0.0000){
				$ordermodel->setBaseTotalOnlineRefunded($base_total_online_refunded);
			}
		}
		
		if($base_total_refunded == 0.0000)
		{
			$ordermodel->setBaseTotalRefunded(Null);
		}
		else
		{
			if($base_total_refunded > 0.0000){
				$ordermodel->setBaseTotalRefunded($base_total_refunded);
			}
		}
		
		if($discount_refunded == 0.0000)
		{
			$ordermodel->setDiscountRefunded(Null);
		}
		else
		{
			if($discount_refunded > 0.0000){
				$ordermodel->setDiscountRefunded($discount_refunded);
			}
		}
		
		if($shipping_refunded == 0.0000)
		{
			$ordermodel->setShippingRefunded(Null);
		}
		else
		{
			if($shipping_refunded > 0.0000){
				$ordermodel->setShippingRefunded($shipping_refunded);
			}
		}
		
		if($shipping_tax_refunded == 0.0000)
		{
			$ordermodel->setShippingTaxRefunded(Null);
		}
		else
		{
			if($shipping_tax_refunded > 0.0000){
				$ordermodel->setShippingTaxRefunded($shipping_tax_refunded);
			}
		}
		
		if($subtotal_refunded == 0.0000)
		{
			$ordermodel->setSubtotalRefunded(Null);
		}
		else
		{
			if($subtotal_refunded > 0.0000){
				$ordermodel->setSubtotalRefunded($subtotal_refunded);
			}
		}
		
		if($tax_refunded == 0.0000)
		{
			$ordermodel->setTaxRefunded(Null);
		}
		else
		{
			if($tax_refunded > 0.0000){
				$ordermodel->setTaxRefunded($tax_refunded);
			}
		}
		
		if($total_offline_refunded == 0.0000)
		{
			$ordermodel->setTotalOfflineRefunded(Null);
		}
		else
		{
			if($total_offline_refunded > 0.0000){
				$ordermodel->setTotalOfflineRefunded($total_offline_refunded);
			}
		}
		
		if($total_online_refunded == 0.0000)
		{
			$ordermodel->setTotalOnlineRefunded(Null);
		}
		else
		{
			if($total_online_refunded > 0.0000){
				$ordermodel->setTotalOnlineRefunded($total_online_refunded);
			}
		}
		
		if($total_refunded == 0.0000)
		{
			$ordermodel->setTotalRefunded(Null);
		}
		else
		{
			if($total_refunded > 0.0000){
				$ordermodel->setTotalRefunded($total_refunded);
			}
		}
		$ordermodel->save();
		
		return true;
	}
	
}