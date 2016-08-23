<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) Amasty (http://www.amasty.com)
 */

class Amasty_SeoRichData_Block_Category_Richdata extends Mage_Core_Block_Template
{
    const ITEM_TYPE_OFFER_AGGREGATE = 'http://schema.org/AggregateOffer';

    protected $_reviewSummaryInfo;

    protected function _construct()
    {
        parent::_construct();

        $this->setTemplate('amasty/amseorichdata/catalog/category/richdata.phtml');

        $this->addData(array(
            'cache_tags'        => array(Mage_Catalog_Model_Product::CACHE_TAG),

            'product_schema' => Amasty_SeoRichData_Helper_HtmlManager::ITEM_TYPE_PRODUCT_URL,
            'offer_schema' => self::ITEM_TYPE_OFFER_AGGREGATE,
            'reviews_schema' => Amasty_SeoRichData_Helper_Rating::ITEM_TYPE_REVIEW,
        ));
    }

    protected function _toHtml()
    {
        if (Mage::getStoreConfig('amseorichdata/category/enabled'))
            return parent::_toHtml();
    }

    public function getCategory()
    {
        return Mage::registry('current_category');
    }

    public function getMinimalPrice()
    {
        /** @var Mage_Catalog_Model_Category $category */

        $category = $this->getCategory();

        $collection = clone $category->getProductCollection();

        $collection->addPriceData();

        $collection->getSelect()
            ->order('min_price ASC')
            ->limit(1)
        ;

        $price = 0;

        if ($product = $collection->getFirstItem())
        {
            $price = Mage::helper('tax')->getPrice($product, $product->getPrice());
        }

        return Mage::getModel('directory/currency')->format(
            $price,
            array('display' => Zend_Currency::NO_SYMBOL),
            false
        );
    }

    protected function _getSummaryInfo()
    {
        if (!$this->_reviewSummaryInfo)
        {
            $select = clone $this->getCategory()->getProductCollection()->getSelect();
            $resource = $this->getCategory()->getResource();

            $select
                ->reset(Varien_Db_Select::COLUMNS)
                ->reset(Varien_Db_Select::LIMIT_COUNT)
                ->reset(Varien_Db_Select::LIMIT_OFFSET)
                ->join(
                    array('summary' => $resource->getTable('review/review_aggregate')),
                    'summary.entity_pk_value = e.entity_id',
                    array('rating' => 'AVG(rating_summary)', 'reviews' => 'SUM(reviews_count)')
                )
                ->where('summary.store_id = ?', Mage::app()->getStore()->getId())
                ->where('reviews_count > 0')
            ;

            $this->_reviewSummaryInfo = new Varien_Object();
            $this->_reviewSummaryInfo->setData($resource->getReadConnection()->fetchRow($select));
        }

        return $this->_reviewSummaryInfo;
    }

    public function getReviewsCount()
    {
        return $this->_getSummaryInfo()->getReviews();
    }

    public function getRatingSummary()
    {
        return $this->_getSummaryInfo()->getRating();
    }

    public function getVotesCount()
    {
        $select = clone $this->getCategory()->getProductCollection()->getSelect();

        $resource = $this->getCategory()->getResource();

        $select
            ->reset(Varien_Db_Select::COLUMNS)
            ->reset(Varien_Db_Select::LIMIT_COUNT)
            ->reset(Varien_Db_Select::LIMIT_OFFSET)
            ->join(
                array('votes' => $resource->getTable('rating/rating_vote_aggregated')),
                'votes.entity_pk_value = e.entity_id',
                array('vote_count' => 'SUM(vote_count)')
            )
            ->where('votes.store_id=?', Mage::app()->getStore()->getId());

        return $resource->getReadConnection()->fetchOne($select);
    }
}
