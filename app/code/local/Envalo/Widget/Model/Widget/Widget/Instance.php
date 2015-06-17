<?php

class Envalo_Widget_Model_Widget_Widget_Instance extends Mage_Widget_Model_Widget_Instance {
    const SPECIFIC_PAGE_LAYOUT_HANDLE     = 'cms_page_{{ID}}';
    const ALL_PAGE_LAYOUT_HANDLE          = 'cms_page_view';
    protected function _construct()
    {
        parent::_construct();
        $this->_layoutHandles['specific_cms_page'] = self::ALL_PAGE_LAYOUT_HANDLE;
        $this->_specificEntitiesLayoutHandles['specific_cms_page'] = self::SPECIFIC_PAGE_LAYOUT_HANDLE;

    }
}