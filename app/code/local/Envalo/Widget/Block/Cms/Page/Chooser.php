<?php

/**
 * Class Envalo_Widget_Block_Cms_Page_Chooser
 * @method Envalo_Widget_Block_Cms_Page_Chooser setName($name)
 * @method Envalo_Widget_Block_Cms_Page_Chooser setUseMassaction($yes_no)
 * @method bool getUseMassAction()
 * @method setUseAjax($yes_no)
 */
class Envalo_Widget_Block_Cms_Page_Chooser extends Mage_Adminhtml_Block_Widget_Grid
{
    protected $_selectedPages = array();

    public function __construct($arguments=array())
    {
        parent::__construct($arguments);
        $this->setDefaultSort('title');
        $this->setUseAjax(true);
    }

    public function prepareElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
        $uniqId = Mage::helper('core')->uniqHash($element->getId());
        $sourceUrl = $this->getUrl('*/*/pageschooser', array(
            'uniq_id' => $uniqId,
            'use_massaction' => false,
        ));
        /* @var $chooser Mage_Widget_Block_Adminhtml_Widget_Chooser */
        /** @noinspection PhpUndefinedMethodInspection */
        $chooser = $this->getLayout()->createBlock('widget/adminhtml_widget_chooser')
            ->setElement($element)
            ->setTranslationHelper($this->getTranslationHelper())
            ->setConfig($this->getConfig())
            ->setFieldsetId($this->getFieldsetId())
            ->setSourceUrl($sourceUrl)
            ->setUniqId($uniqId);

        /** @noinspection PhpUndefinedMethodInspection */
        if ($element->getValue()) {
            /** @noinspection PhpUndefinedMethodInspection */
            $chooser->setLabel('');
        }

        $element->setData('after_element_html', $chooser->toHtml());
        return $element;
    }

    public function getCheckboxCheckCallback()
    {
        if ($this->getUseMassaction()) {
            return "function (grid, element) {
                $(grid.containerId).fire('product:changed', {element: element});
            }";
        }
        return '';
    }

    public function getRowClickCallback()
    {
        if (!$this->getUseMassaction()) {
            $chooserJsObject = $this->getId();
            return '
                function (grid, event) {
                    var trElement = Event.findElement(event, "tr");
                    var productId = trElement.down("td").innerHTML;
                    var productName = trElement.down("td").next().next().innerHTML;
                    var optionLabel = productName;
                    var optionValue = "product/" + productId.replace(/^\s+|\s+$/g,"");
                    if (grid.categoryId) {
                        optionValue += "/" + grid.categoryId;
                    }
                    if (grid.categoryName) {
                        optionLabel = grid.categoryName + " / " + optionLabel;
                    }
                    '.$chooserJsObject.'.setElementValue(optionValue);
                    '.$chooserJsObject.'.setElementLabel(optionLabel);
                    '.$chooserJsObject.'.close();
                }
            ';
        }
        return '';
    }

    /**
     * @param $column Mage_Adminhtml_Block_Widget_Grid_Column
     * @return $this
     */
    protected function _addColumnFilterToCollection($column)
    {
        if ($column->getId() == 'in_pages') {
            $selected = $this->getSelectedPages();
            /** @noinspection PhpUndefinedMethodInspection */
            if ($column->getFilter()->getValue()) {
                /** @noinspection PhpUndefinedMethodInspection */
                $this->getCollection()->addFieldToFilter('page_id', array('in'=>$selected));
            } else {
                /** @noinspection PhpUndefinedMethodInspection */
                $this->getCollection()->addFieldToFilter('page_id', array('nin'=>$selected));
            }
        } else {
            parent::_addColumnFilterToCollection($column);
        }
        return $this;
    }

    protected function _prepareCollection()
    {

        /* @var $collection Mage_Cms_Model_Resource_Page_Collection */
        $collection = Mage::getModel('cms/page')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        if ($this->getUseMassaction()) {
            $this->addColumn('in_pages', array(
                'header_css_class' => 'a-center',
                'type'      => 'checkbox',
                'name'      => 'in_pages',
                'inline_css' => 'checkbox entities',
                'field_name' => 'in_pages',
                'values'    => $this->getSelectedPages(),
                'align'     => 'center',
                'index'     => 'page_id',
                'use_index' => true,
            ));
        }

        $this->addColumn('page_id', array(
            'header'    => Mage::helper('cms')->__('ID'),
            'sortable'  => true,
            'width'     => '60px',
            'index'     => 'page_id'
        ));
        $this->addColumn('page_title', array(
            'header'    => Mage::helper('cms')->__('Title'),
            'name'      => 'page_title',
            'index'     => 'title'
        ));


        return parent::_prepareColumns();
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/pageschooser', array(
            '_current' => true,
            'uniq_id' => $this->getId(),
            'use_massaction' => $this->getUseMassaction()
        ));
    }
    /**
     * Setter
     *
     * @param array $selectedPages
     * @return Mage_Adminhtml_Block_Catalog_Product_Widget_Chooser
     */
    public function setSelectedPages($selectedPages)
    {
        $this->_selectedPages = $selectedPages;
        return $this;
    }

    /**
     * Getter
     *
     * @return array
     */
    public function getSelectedPages()
    {
        if ($selectedPages = $this->getRequest()->getParam('selected_products', null)) {
            $this->setSelectedPages($selectedPages);
        }
        return $this->_selectedPages;
    }
}