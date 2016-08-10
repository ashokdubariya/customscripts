<?php 
class Linksture_Deletecreditmemo_Block_Adminhtml_Sales_Creditmemo_Render_Delete extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row) {
		$getData = $row->getData();
		$message = Mage::helper('sales')->__('Are you sure you want to delete this credit memo?');
		$creditmemo_id = $getData['entity_id'];
        $view = $this->getUrl('*/sales_creditmemo/view',array('creditmemo_id' => $creditmemo_id));
		$delete = $this->getUrl('*/deletecreditmemo/delete',array('creditmemo_id' => $creditmemo_id));
		$link = '<a href="'.$view.'">View</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" onclick="deleteConfirm(\''.$message.'\', \'' . $delete . '\')">Delete</a>';
		return $link;
    }
}
?>
