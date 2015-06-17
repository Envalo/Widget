<?php
/** @noinspection PhpIncludeInspection */
require_once('Mage/Widget/controllers/Adminhtml/Widget/InstanceController.php');
class Envalo_Widget_Adminhtml_Widget_InstanceController
    extends Mage_Widget_Adminhtml_Widget_InstanceController
{
    public function pagesAction()
    {
        $selected = $this->getRequest()->getParam('selected', '');
        /* @var $chooser Envalo_Widget_Block_Cms_Page_Chooser */
        $chooser = $this->getLayout()
            ->createBlock('envalo_widget/cms_page_chooser');

        $chooser->setName(Mage::helper('core')->uniqHash('products_grid_'))
            ->setUseMassaction(true)
            ->setSelectedPages(explode(',', $selected));
        /* @var $serializer Mage_Adminhtml_Block_Widget_Grid_Serializer */
        $serializer = $this->getLayout()->createBlock('adminhtml/widget_grid_serializer');
        $serializer->initSerializerBlock($chooser, 'getSelectedProducts', 'selected_products', 'selected_products');
        $body = $chooser->toHtml().$serializer->toHtml();
        Mage::getSingleton('core/translate_inline')->processResponseBody($body);
        $this->getResponse()->setBody($body);
    }

    public function pageschooserAction()
    {
        $uniqId = $this->getRequest()->getParam('uniq_id');
        $massAction = $this->getRequest()->getParam('use_massaction', false);
        /* @var $pagesGrid Envalo_Widget_Block_Cms_Page_Chooser */
        $pagesGrid = $this->getLayout()->createBlock('envalo_widget/cms_page_chooser', '', array(
            'id'                => $uniqId,
            'use_massaction'    => $massAction
        ));

        $html = $pagesGrid->toHtml();

        $this->getResponse()->setBody($html);
    }
}