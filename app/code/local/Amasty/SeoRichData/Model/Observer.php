<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) Amasty (http://www.amasty.com)
 */

class Amasty_SeoRichData_Model_Observer
{
    protected $_handleBlocksOutput = null;

    public function sendResponseBefore($observer)
    {
        if (Mage::app()->getRequest()->getModuleName() == 'api')
            return;

        if ($observer->getFront()->getAction()->getRequest()->isAjax())
            return;

        $response = $observer->getFront()->getAction()->getResponse();

        $html = $response->getBody();

        if ($html)
            $html = Mage::helper('amseorichdata/htmlManager')->apply($html);

        $response->setBody($html);
    }

    public function handleBlockOutput($observer)
    {
        $block = $observer->getBlock();

        if ($block instanceof Mage_Page_Block_Html_Breadcrumbs)
        {
            if (Mage::getStoreConfig('amseorichdata/breadcrumbs/enabled'))
            {
                $transport = $observer->getTransport();
                $html = trim($transport->getHtml());

                if ($html)
                {
                    $html = Mage::helper('amseorichdata/breadcrumbs')->apply($html);

                    $transport->setHtml($html);
                }
            }
        }

        if ($this->_handleBlocksOutput === false)
            return;

        if ($this->_handleBlocksOutput === null)
        {
            $request = Mage::app()->getRequest();
            $this->_handleBlocksOutput =
                $request->getControllerName() == 'product' && $request->getActionName() == 'view';
        }

        if ($this->_handleBlocksOutput)
        {
            if ($block instanceof Mage_Review_Block_Helper)
            {
                if (Mage::getStoreConfig('amseorichdata/rating/enabled'))
                {
                    $product = Mage::registry('current_product');

                    if ($block->getProduct() && $block->getProduct()->getId() == $product->getId())
                    {
                        $transport = $observer->getTransport();
                        $html = $transport->getHtml();

                        $html = Mage::helper('amseorichdata/rating')->addSnippets($html);

                        $transport->setHtml($html);

                    }
                }
            }
            if ($block instanceof Mage_Catalog_Block_Product_Price)
            {
                if (Mage::getStoreConfig('amseorichdata/product/enabled'))
                {
                    $product = Mage::registry('current_product');

                    if ($block->getProduct() && $block->getProduct()->getId() == $product->getId())
                    {
                        $transport = $observer->getTransport();
                        $html = $transport->getHtml();

                        if (trim(strip_tags($html)))
                        {

                            $html = Mage::helper('amseorichdata/product')->applyPrice($html);

                            $transport->setHtml($html);
                        }
                    }
                }
            }
            if ($block instanceof Mage_Catalog_Block_Product_View_Media)
            {
                if (Mage::getStoreConfig('amseorichdata/product/enabled'))
                {
                    $product = Mage::registry('current_product');

                    if ($block->getProduct() && $block->getProduct()->getId() == $product->getId())
                    {
                        if ($product->getImage() != 'no_selection' && $product->getImage())
                        {
                            $transport = $observer->getTransport();
                            $html = $transport->getHtml();

                            $html = Mage::helper('amseorichdata/product')->applyImage($html);

                            $transport->setHtml($html);
                        }
                    }
                }
            }
        }
    }
}
