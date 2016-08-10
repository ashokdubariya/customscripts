<?php
class Linksture_Deletecreditmemo_Block_Adminhtml_Sales_Creditmemo_Grid extends Mage_Adminhtml_Block_Sales_Creditmemo_Grid
{
	public function __construct()
    {
        parent::__construct();
        $this->setId('sales_creditmemo_grid');
        $this->setDefaultSort('created_at');
        $this->setDefaultDir('DESC');
    }

    /**
     * Retrieve collection class
     *
     * @return string
     */
    protected function _getCollectionClass()
    {
        return 'sales/order_creditmemo_grid_collection';
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getResourceModel($this->_getCollectionClass());
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }


    protected function _prepareColumns()
    {
		parent::_prepareColumns();
        
		$this->addColumn('increment_id', array(
            'header'    => Mage::helper('sales')->__('Credit Memo #'),
            'index'     => 'increment_id',
            'type'      => 'text',
        ));

        $this->addColumn('created_at', array(
            'header'    => Mage::helper('sales')->__('Created At'),
            'index'     => 'created_at',
            'type'      => 'datetime',
        ));

        $this->addColumn('order_increment_id', array(
            'header'    => Mage::helper('sales')->__('Order #'),
            'index'     => 'order_increment_id',
            'type'      => 'text',
        ));

        $this->addColumn('order_created_at', array(
            'header'    => Mage::helper('sales')->__('Order Date'),
            'index'     => 'order_created_at',
            'type'      => 'datetime',
        ));

        $this->addColumn('billing_name', array(
            'header' => Mage::helper('sales')->__('Bill to Name'),
            'index' => 'billing_name',
        ));

        $this->addColumn('state', array(
            'header'    => Mage::helper('sales')->__('Status'),
            'index'     => 'state',
            'type'      => 'options',
            'options'   => Mage::getModel('sales/order_creditmemo')->getStates(),
        ));

        $this->addColumn('grand_total', array(
            'header'    => Mage::helper('customer')->__('Refunded'),
            'index'     => 'grand_total',
            'type'      => 'currency',
            'align'     => 'right',
            'currency'  => 'order_currency_code',
        ));

        $this->addColumn('action',
            array(
                'header'    => Mage::helper('sales')->__('Action'),
                'width'     => '50px',
                'type'      => 'action',
                'getter'     => 'getId',
                'actions'   => array(
                    array(
                        'caption' => Mage::helper('sales')->__('View'),
                        'url'     => array('base'=>'*/sales_creditmemo/view'),
                        'field'   => 'creditmemo_id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'is_system' => true,
				'renderer'  => 'Linksture_Deletecreditmemo_Block_Adminhtml_Sales_Creditmemo_Renderer_Delete'
				
        ));
		
		
		/* $this->addColumn('action',
			array(
				'header'    => Mage::helper('sales')->__('Action'),
				'width'     => '100px',
				'type'      => 'action',
				'getter'    => 'getId',
				'renderer'  => 'Linksture_Deletecreditmemo_Block_Adminhtml_Sales_Creditmemo_Renderer_Delete',
				'filter'    => false,
				'sortable'  => false,
				'index'     => 'stores',
				'is_system' => true,
		)); */

        $this->addExportType('*/*/exportCsv', Mage::helper('sales')->__('CSV'));
        $this->addExportType('*/*/exportExcel', Mage::helper('sales')->__('Excel XML'));

        return $this;
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('creditmemo_ids');
        $this->getMassactionBlock()->setUseSelectAll(false);

        $this->getMassactionBlock()->addItem('pdfcreditmemos_order', array(
             'label'=> Mage::helper('sales')->__('PDF Credit Memos'),
             'url'  => $this->getUrl('*/sales_creditmemo/pdfcreditmemos'),
        ));
	
		$this->getMassactionBlock()->addItem('delete_creditmemos', array(
             'label'=> Mage::helper('sales')->__('Delete Creditmemos'),
             'url'  => $this->getUrl('*/deletecreditmemo/massDelete'),
			 'confirm'  => Mage::helper('sales')->__('Are you sure you want to delete creditmemo?')
        ));
		
        return $this;
    }

    public function getRowUrl($row)
    {
        if (!Mage::getSingleton('admin/session')->isAllowed('sales/order/creditmemo')) {
            return false;
        }

        return $this->getUrl('*/sales_creditmemo/view',
            array(
                'creditmemo_id'=> $row->getId(),
            )
        );
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/*', array('_current' => true));
    }
}