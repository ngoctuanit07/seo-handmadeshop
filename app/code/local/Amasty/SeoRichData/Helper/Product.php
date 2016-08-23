<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) Amasty (http://www.amasty.com)
 */

class Amasty_SeoRichData_Helper_Product extends Mage_Core_Helper_Abstract
{
    const ITEM_TYPE_OFFER_URL        = 'http://schema.org/Offer';

    protected $_priceApplied = false;

    public function applyPrice($html)
    {
        if ($this->_priceApplied)
            return $html;

        $product = Mage::registry('current_product');

        $priceSelector = Mage::getStoreConfig('amseorichdata/product/container_price_selector');

        $dom = new Amasty_SeoRichData_Model_Dom($html);

        if ($priceBox = $dom->query($priceSelector))
        {
            $priceBox->setAttribute('itemscope', '');
            $priceBox->setAttribute('itemtype', self::ITEM_TYPE_OFFER_URL);
            $priceBox->setAttribute('itemprop', 'offers');

            $dom->appendElement($priceBox, 'link', array(
                'itemprop' => 'availability',
                'href' => $product->isAvailable() ? 'http://schema.org/InStock' : 'http://schema.org/OutOfStock'
            ));

            $dom->appendElement($priceBox, 'meta', array(
                'itemprop' => 'priceCurrency',
                'content' => Mage::app()->getStore()->getCurrentCurrencyCode()
            ));

            $dom->appendElement($priceBox, 'meta', array(
                'itemprop' => 'price',
                'content' => (float)$product->getFinalPrice()
            ));

            if ($product->getSpecialToDate() && $product->getPrice() != $product->getFinalPrice())
            {
                $dom->appendElement($priceBox, 'time', array(
                    'itemprop' => 'priceValidUntil',
                    'datetime' => date('Y-m-d', strtotime($product->getSpecialToDate()))
                ));
            }

            $html = $dom->save();
            $html = html_entity_decode($html, ENT_QUOTES, "UTF-8");

            $this->_priceApplied = true;
        }

        return $html;
    }

    public function applyImage($html)
    {
        $pattern = '|(\<img)([^>]+src=[^>]+/image/[^>]+\>)|i';
        $replace = '${1} itemprop="image" ${2}';

        return preg_replace($pattern, $replace, $html, 1);
    }
}
