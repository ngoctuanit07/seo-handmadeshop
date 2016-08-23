<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) Amasty (http://www.amasty.com)
 */

class Amasty_SeoRichData_Helper_DomManager extends Mage_Core_Helper_Abstract
{
    const ITEM_TYPE_PRODUCT_URL      = 'http://data-vocabulary.org/Product';
    const ITEM_TYPE_OFFER_URL        = 'http://data-vocabulary.org/Offer';
    const ITEM_TYPE_ORGANIZATION_URL = 'http://schema.org/Organization';
    const ITEM_TYPE_BREADCRUMB       = 'http://data-vocabulary.org/Breadcrumb';
    const ITEM_TYPE_REVIEW           = 'http://data-vocabulary.org/Review-aggregate';

    protected $_specialPriceIsApplied = false;

    protected $_customTag = 'amasty_seo';

    /* @var DOMXPath */
    protected $_xpathSearch;
    /* @var DOMDocument */
    protected $_document;
    protected $_type;

    public function apply($html, $types = array('product', 'rating', 'organization', 'breadcrumbs'))
    {
        $doc = new DOMDocument();

        libxml_use_internal_errors(true);
        $doc->loadHTML($html);
        libxml_clear_errors();
        libxml_use_internal_errors(false);

        $this->_document = $doc;
        $this->_xpathSearch = new DOMXPath($doc);

        foreach ($types as $type)
        {
            if (Mage::getStoreConfig('amseorichdata/' . $type .'/enabled'))
            {
                $methodName = '_add' . ucfirst(strtolower($type)) . 'Data';
                if (! method_exists($this, $methodName)) {
                    throw new Exception("Method $methodName is not implemented");
                }

                $this->_type = $type;
                $this->$methodName();
            }
        }

        return $doc->saveHTML();
    }

    protected function _addProductData()
    {
        $this->_addItemScope('container', self::ITEM_TYPE_PRODUCT_URL);

        $this
            ->_addProp('image')
            ->_addProp('description')
            ->_addProp('name')
        ;

        //price scope
        $priceAttributes = array(
            'itemprop' => 'offerDetails',
            'itemref'  => 'availability'
        );
        $this->_addItemScope('container_price', self::ITEM_TYPE_OFFER_URL, $priceAttributes);

        //special one
        $this->_applyPrice('price_special', true);
        //regular one
        $this->_applyPrice('price_regular');

        //availability
        /*class should contain in-stock or out-of-stock*/
        $this->_applyAvailability('availability');
    }

    protected function _addOrganizationData()
    {
        $this->_addItemScope('container', self::ITEM_TYPE_ORGANIZATION_URL);

        $this
            ->_addProp('name')
            ->_addProp('logo')
            ->_addProp('url')
        ;
    }

    protected function _addRatingData()
    {
        $product = Mage::registry('current_product');

        if (!$product || !$product->getRatingSummary())
            return false;

        $this->_addItemScope('review', self::ITEM_TYPE_REVIEW, array('itemprop' => 'review'));

        $selector = $this->_selector('review');

        if (!($results = $this->_query($selector))) {
            return false;
        }

        foreach ($results as $result)
        {
            $totalsModel = Mage::getSingleton('amseorichdata/source_reviews_totals');
            $showTotals = +Mage::getStoreConfig('amseorichdata/rating/totals');

            $this->_addMeta($result, array(
                'itemprop' => 'rating',
                'content' => round(($product->getRatingSummary()->getRatingSummary() * 5) / 100, 2)
            ));

            if ($showTotals & $totalsModel::TOTALS_REVIEWS)
            {
                $this->_addMeta($result, array(
                    'itemprop' => 'count',
                    'content' => $product->getRatingSummary()->getReviewsCount()
                ));
            }

            if ($showTotals & $totalsModel::TOTALS_VOTES)
            {
                $this->_addMeta($result, array(
                    'itemprop' => 'votes',
                    'content' => $this->_getProductVotes($product)
                ));
            }
            break;
        }
    }

    protected function _getProductVotes($product)
    {
        $adapter = $product->getResource()->getReadConnection();
        $select = $adapter->select()->from($product->getResource()->getTable('rating/rating_vote_aggregated'))
            ->columns('vote_count')
            ->where('store_id=?', Mage::app()->getStore()->getId())
            ->where('entity_pk_value=?', $product->getId())
            ->limit(1)
        ;

        return $adapter->fetchOne($select);
    }

    protected function _addMeta($element, $attributes)
    {
        $meta = $this->_document->createElement('meta');

        foreach ($attributes as $name => $value)
            $meta->setAttribute($name, $value);

        $element->appendChild($meta);

        return $this;
    }

    protected function _addBreadcrumbsData()
    {
        $this->_addItemScope('item', self::ITEM_TYPE_BREADCRUMB);

        $this
            ->_addProp('url')
            ->_wrap('title')
        ;
    }

    /**
     * Wraps selected elements with special tag
     *
     * @param $type
     * @return $this
     */

    protected function _wrap($type)
    {
        $selector = $this->_selector($type);

        if (!($results = $this->_query($selector))) {
            return false;
        }

        foreach ($results as $result)
        {
            $wrap = $this->_document->createElement($this->_customTag);
            $wrap->setAttribute('itemprop', $type);

            while ($result->childNodes->length > 0)
            {
                $child = $result->childNodes->item(0);

                $wrap->appendChild($child);
            }
            $result->appendChild($wrap);
        }

        return $this;
    }

    protected function _addProp($type)
    {
        $selector = $this->_selector($type);

        $this->_addTagToHtml($selector, 'itemprop', $type);

        return $this;
    }

    /**
     * Add scope tag to the container
     * Example:
     * <div containerClass itemscope="" itemtype="http://data-vocabulary.org/Product" />
     *
     * @param $block
     * @param $dictionaryUrl
     * @param array $additionalAttributes
     */
    protected function _addItemScope($block, $dictionaryUrl, $additionalAttributes = array())
    {
        $selector = $this->_selector($block);
        $attributes = array(
            'itemscope' => '',
            'itemtype'  => $dictionaryUrl
        );

        $attributes = $attributes + $additionalAttributes;

        $this->_addTagToHtml($selector, $attributes);
    }

    /**
     * Apply price info
     *
     * @param $block
     * @param bool $isSpecial
     *
     * @return bool
     */
    protected function _applyPrice($block, $isSpecial = false)
    {
        //check if special price was already defined
        if (! $isSpecial && $this->_specialPriceIsApplied) {
            return false;
        }

        $cssSelector = $this->_selector($block);

        $price = $this->_getElementText($cssSelector);
        if (! empty($price)) {
            $priceHtml    = '';
            $currencyCode = null;
            $price        = trim($price);
            $priceInfo    = preg_split('/(^\D+)/', $price, - 1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
            if (count($priceInfo) != 2) {
                $priceInfo = preg_split('/(\D+)$/', $price, - 1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
                if (count($priceInfo) == 2) {
                    if ($priceInfo[0]) {
                        $priceHtml .= "<{$this->_customTag} itemprop='price'>{$priceInfo[0]}</{$this->_customTag}>";
                    }

                    if ($priceInfo[1]) {
                        $code = Mage::app()->getStore()->getCurrentCurrencyCode();
                        $priceHtml .= "<{$this->_customTag} itemprop='currency' content='$code'>{$priceInfo[1]}</{$this->_customTag}>";
                    }
                }
            } else {
                if ($priceInfo[0]) {
                    $code = Mage::app()->getStore()->getCurrentCurrencyCode();
                    $priceHtml .= "<{$this->_customTag} itemprop='currency' content='$code'>{$priceInfo[0]}</{$this->_customTag}>";
                }

                if ($priceInfo[1]) {
                    $priceHtml .= "<{$this->_customTag} itemprop='price'>{$priceInfo[1]}</{$this->_customTag}>";
                }
            }

            if ($isSpecial) {
                $_product = null;
                if (! empty($priceHtml) &&
                    (($_product = Mage::registry('current_product')) || ($_product = Mage::registry('product')))
                ) {
                    if ($_product->getSpecialToDate()) {
                        $priceHtml .= '<time itemprop="priceValidUntil" datetime="' .
                            date('Y-m-d', strtotime($_product->getSpecialToDate())) . '" />';
                    }
                }

                $this->_specialPriceIsApplied = ! empty($priceHtml);
            }

            if (! empty($priceHtml)) {
                $this->_replaceHtml($cssSelector, $priceHtml);
            }
        }

        return true;
    }

    /**
     * Add content to availability tag
     *
     * @param $block
     *
     * @return bool
     */
    protected function _applyAvailability($block)
    {
        $cssSelector = $this->_selector($block);

        if (!($results = $this->_query($cssSelector))) {
            return false;
        }

        foreach ($results as $result) {
            $classes    = $result->getAttribute('class');
            $stockValue = in_array('in-stock', explode(' ', $classes)) ? 'in_stock' : 'out_of_stock';
            $result->setAttribute('itemprop', 'availability');
            $result->setAttribute('content', $stockValue);
            $result->setAttribute('id', 'availability');
            break;
        }

        return true;
    }

    /**
     * @param $cssSelector
     * @param $tagAttributes
     * @param string $tagValue
     *
     * @return bool
     */
    protected function _addTagToHtml($cssSelector, $tagAttributes, $tagValue = '')
    {
        if (!($results = $this->_query($cssSelector))) {
            return false;
        }

        if (!is_array($tagAttributes)) {
            $tagAttributes = array(
                $tagAttributes => $tagValue
            );
        }

        foreach ($results as $result) {
            foreach ($tagAttributes as $tagName => $tagValue) {
                $result->setAttribute($tagName, $tagValue);
            }
//            break;
        }

        return true;
    }

    /**
     * @param $selector
     * @param $html
     *
     * @return bool
     */
    protected function _replaceHtml($selector, $html)
    {
        if (!($results = $this->_query($selector))) {
            return false;
        }

        foreach ($results as $result) {
            while ($result->childNodes->length) {
                $result->removeChild($result->firstChild);
            }

            $fragment = $this->_document->createDocumentFragment();
            $fragment->appendXML($html);
            $result->appendChild($fragment);

            break;
        }

        return true;
    }

    /**
     * @param $selector
     *
     * @return bool|string
     */
    protected function _getElementText($selector)
    {
        if (!($results = $this->_query($selector))) {
            return false;
        }

        foreach ($results as $result) {
            return $result->textContent;
        }

        return '';
    }

    /**
     * @param $selector
     *
     * @return DOMNodeList
     */
    protected function _query($selector)
    {
        return $this->_xpathSearch->query(Zend_Dom_Query_Css2Xpath::transform($selector));
    }

    protected function _selector($block)
    {
        return Mage::getStoreConfig('amseorichdata/' . $this->_type . '/' . $block . '_selector');
    }
}
