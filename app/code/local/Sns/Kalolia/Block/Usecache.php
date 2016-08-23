<?php

class Sns_Kalolia_Block_Usecache extends Mage_Page_Block_Html_Wrapper {

    protected $_dependsOnChildren = true;
	protected $_cacheKeyArray = NULL;
    const CACHE_LIFETIME = 10000000;

    protected function _construct() {
        parent::_construct();
		$this->addData(array(
			'cache_tags'     => array(Mage_Catalog_Model_Product::CACHE_TAG),
            'cache_lifetime' => self::CACHE_LIFETIME,
		));
    }
	public function getCacheKeyInfo() {
		if (NULL === $this->_cacheKeyArray) {
			$this->_cacheKeyArray = array(
				'SNS_KALOLIA_BLOCK_USECACHE',
				Mage::app()->getStore()->getId(),
				Mage::getSingleton('core/session')->getFormKey(),
				Mage::getDesign()->getPackageName(),
				Mage::getDesign()->getTheme('template'),
				Mage::getSingleton('customer/session')->getCustomerGroupId(),
				'template' => $this->getTemplate(),
				'name' => $this->getNameInLayout(),
				(int)Mage::app()->getStore()->isCurrentlySecure(),
			);
		}
		return $this->_cacheKeyArray;
	}
	
    protected function _toHtml() {
        if(empty($this->_children)) {
        	$html = '';
        } else {
        	$html = (trim($this->getChildHtml('', true, true))) ? trim($this->getChildHtml('', true, true)) : '';
        }
        if ($this->_dependsOnChildren && empty($html)) {
            return '';
        }
        return $html;
    }
}
