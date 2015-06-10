<?php
class Envalo_Widget_Block_Widget_Adminhtml_Widget_Instance_Edit_Tab_Main_Layout extends Mage_Widget_Block_Adminhtml_Widget_Instance_Edit_Tab_Main_Layout {

    /**
     * Retrieve Display On options array.
     * - Categories (anchor and not anchor)
     * - Products (product types depend on configuration)
     * - Generic (predefined) pages (all pages and single layout update)
     *
     * @return array
     */
    protected function _getDisplayOnOptions()
    {
        $options = parent::_getDisplayOnOptions();
        /* @var $ch Mage_Core_Helper_Data */
        $ch = Mage::helper('core');
        /* @var $wh Mage_Widget_Helper_Data */
        $wh = Mage::helper('widget');
        $options[count($options) - 1]['value'][] =
                array(
                    'value' => 'specific_cms_page',
                    'label' => $ch->jsQuoteEscape($wh->__('Specific CMS Pages'))
                );
        return $options;

    }
    /**
     * Generate array of parameters for every container type to create html template
     *
     * @return array
     */
    public function getDisplayOnContainers()
    {
        $container = parent::getDisplayOnContainers();
        $container['specific_cms_page'] = array(
            'label' => 'CMS Pages',
            'code' => 'pages',
            'name' => 'specific_cms_page',
            'layout_handle' => 'default,cms_page',
            'is_anchor_only' => 1,
            'product_type_id' => ''
        );
        return $container;
    }
}