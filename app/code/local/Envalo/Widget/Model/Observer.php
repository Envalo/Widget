<?php

class Envalo_Widget_Model_Observer
{
    /**
     * @param $observer Varien_Event_Observer
     */
    public function addPageSpecificHandle($observer)
    {
        $event = $observer->getEvent();
        /* @var $page Mage_Cms_Model_Page */
        $page = $event->getData('page');
        /* @var $controller Mage_Core_Controller_Front_Action */
        $controller = $event->getData('controller_action');
        if($controller instanceof Mage_Core_Controller_Front_Action
            && $controller->getLayout() instanceof Mage_Core_Model_Layout
            && $controller->getLayout()->getUpdate() instanceof Mage_Core_Model_Layout_Update
            && $page instanceof Mage_Cms_Model_Page
            && $page->getId())
        {
            $controller->getLayout()->getUpdate()->addHandle('cms_page_' . $page->getId());
        }
    }
}