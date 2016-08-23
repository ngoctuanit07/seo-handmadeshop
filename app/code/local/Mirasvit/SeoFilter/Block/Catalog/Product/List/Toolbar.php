<?php
/**
 * Mirasvit
 *
 * This source file is subject to the Mirasvit Software License, which is available at http://mirasvit.com/license/.
 * Do not edit or add to this file if you wish to upgrade the to newer versions in the future.
 * If you wish to customize this module for your needs.
 * Please refer to http://www.magentocommerce.com for more information.
 *
 * @category  Mirasvit
 * @package   Advanced SEO Suite
 * @version   1.3.0
 * @build     1041
 * @copyright Copyright (C) 2015 Mirasvit (http://mirasvit.com/)
 */


if (Mage::helper('mstcore')->isModuleInstalled('GoMage_Navigation') && class_exists('GoMage_Navigation_Block_Product_List_Toolbar')) {
    abstract class Mirasvit_SeoFilter_Block_Catalog_Product_List_Toolbar_Abstract extends GoMage_Navigation_Block_Product_List_Toolbar {

    }
} elseif (Mage::helper('mstcore')->isModuleInstalled('Amasty_Sorting') && class_exists('Amasty_Sorting_Block_Catalog_Product_List_Toolbar')) {
    abstract class Mirasvit_SeoFilter_Block_Catalog_Product_List_Toolbar_Abstract extends Amasty_Sorting_Block_Catalog_Product_List_Toolbar {
    }
} else {
    abstract class Mirasvit_SeoFilter_Block_Catalog_Product_List_Toolbar_Abstract extends Mage_Catalog_Block_Product_List_Toolbar {

    }
}


class Mirasvit_SeoFilter_Block_Catalog_Product_List_Toolbar extends Mirasvit_SeoFilter_Block_Catalog_Product_List_Toolbar_Abstract
{

    public function getConfig() {
        return Mage::getModel('seofilter/config');
    }

    /**
     * Overwritten method. Does not use the _current-method of URL models anymore. Retrieves a speaking filter url from
     * own model.
     *
     * @see Mage_Catalog_Block_Product_List_Toolbar::getPagerUrl($params)
     * @param array $params The params to be added to current url
     * @return string The resulting speaking url to be used in toolbar.
     */
    public function getPagerUrl($params=array())
    {
        if ($identifier = Mage::helper('seo')->isOnLandingPage()) {
            return Mage::helper('amlanding/url')->getLandingUrl($params);
        }

        if ($tagUrl = Mage::helper('seo')->getTagProductListUrl($params)) {
            return $tagUrl;
        }

        if(!$this->getConfig()->isEnabled()) {
            return parent::getPagerUrl($params);
        }

        $category = Mage::registry('current_category');
        if(!is_object($category)){
            return parent::getPagerUrl($params);
        }

        $url = Mage::getModel('seofilter/catalog_layer_filter_item')->getSpeakingFilterUrl(FALSE, TRUE, $params);
        return $url;
    }
}