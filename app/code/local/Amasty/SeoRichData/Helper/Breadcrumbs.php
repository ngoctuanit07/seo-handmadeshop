<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) Amasty (http://www.amasty.com)
 */

class Amasty_SeoRichData_Helper_Breadcrumbs extends Mage_Core_Helper_Abstract
{
    const ITEM_TYPE_BREADCRUMB       = 'http://data-vocabulary.org/Breadcrumb';

    public function apply($html)
    {
        $itemSelector = Mage::getStoreConfig('amseorichdata/breadcrumbs/item_selector');
        $urlSelector = Mage::getStoreConfig('amseorichdata/breadcrumbs/url_selector');
        $titleSelector = Mage::getStoreConfig('amseorichdata/breadcrumbs/title_selector');

        $dom = new Amasty_SeoRichData_Model_Dom($html);

        foreach ($dom->queryAll($itemSelector) as $item)
        {
            $item->setAttribute('itemscope', '');
            $item->setAttribute('itemtype', self::ITEM_TYPE_BREADCRUMB);
        }

        foreach ($dom->queryAll($urlSelector) as $url)
            $url->setAttribute('itemprop', 'url');

        $customTag = Mage::helper('amseorichdata/htmlManager')->getCustomTag();
        foreach ($dom->queryAll($titleSelector) as $title)
        {
            $wrap = $dom->getDocument()->createElement($customTag);
            $wrap->setAttribute('itemprop', 'title');

            while ($title->childNodes->length > 0)
            {
                $child = $title->childNodes->item(0);

                $wrap->appendChild($child);
            }
            $title->appendChild($wrap);
        }

        return $dom->save();
    }
}
