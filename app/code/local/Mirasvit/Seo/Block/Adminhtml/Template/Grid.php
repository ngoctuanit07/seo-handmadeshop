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


class Mirasvit_Seo_Block_Adminhtml_Template_Grid extends Mage_Adminhtml_Block_Widget_Grid {
    public function __construct() {
        parent::__construct();
        $this->setId('templateGrid');
        $this->setDefaultSort('template_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('seo/template')
            ->getCollection();

        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('template_id', array(
                'header'    => Mage::helper('seo')->__('ID'),
                'align'     => 'right',
                'width'     => '50px',
                'index'     => 'template_id',
            )
        );

        $this->addColumn('name', array(
                'header'    => Mage::helper('seo')->__('Internal rule name'),
                'align'     => 'left',
                'index'     => 'name',
            )
        );

        $this->addColumn('meta_title', array(
                'header'    => Mage::helper('seo')->__('Meta title'),
                'align'     => 'left',
                'index'     => 'meta_title',
            )
        );

        $this->addColumn('meta_keywords', array(
                'header'    => Mage::helper('seo')->__('Meta keywords'),
                'align'     => 'left',
                'index'     => 'meta_keywords',
            )
        );

        $this->addColumn('meta_description', array(
                'header'    => Mage::helper('seo')->__('Meta description'),
                'align'     => 'left',
                'index'     => 'meta_description',
            )
        );

        $this->addColumn('title', array(
                'header'    => Mage::helper('seo')->__('Title (H1)'),
                'align'     => 'left',
                'index'     => 'title',
            )
        );

        $this->addColumn('description', array(
                'header'    => Mage::helper('seo')->__('SEO description'),
                'align'     => 'left',
                'index'     => 'description',
            )
        );

        $this->addColumn('short_description', array(
                'header'    => Mage::helper('seo')->__('Product short description'),
                'align'     => 'left',
                'index'     => 'short_description',
            )
        );

        $this->addColumn('full_description', array(
                'header'    => Mage::helper('seo')->__('Product description'),
                'align'     => 'left',
                'index'     => 'full_description',
            )
        );

        $this->addColumn('rule_type', array(
            'header'    => Mage::helper('seo')->__('Rule type'),
            'align'     => 'left',
            'index'     => 'rule_type',
            'type'      => 'options',
            'options'   => array(
                Mirasvit_Seo_Model_Config::PRODUCTS_RULE                   => Mage::helper('seo')->__('Products'),
                Mirasvit_Seo_Model_Config::CATEGORIES_RULE                 => Mage::helper('seo')->__('Categories'),
                Mirasvit_Seo_Model_Config::RESULTS_LAYERED_NAVIGATION_RULE => Mage::helper('seo')->__('Layered navigation'),
            ),
        ));

        $this->addColumn('sort_order', array(
                'header'    => Mage::helper('seo')->__('Sort Order'),
                'align'     => 'left',
                'width'     => '30px',
                'index'     => 'sort_order',
            )
        );

        $this->addColumn('stop_rules_processing', array(
            'header'    => Mage::helper('seo')->__('Stop Further Rules Processing'),
            'align'     => 'left',
            'width'     => '80px',
            'index'     => 'stop_rules_processing',
            'type'      => 'options',
            'options'   => array(
                1 => Mage::helper('seo')->__('Yes'),
                0 => Mage::helper('seo')->__('No'),
            ),
        ));

        $this->addColumn('is_active', array(
            'header'    => Mage::helper('seo')->__('Status'),
            'align'     => 'left',
            'width'     => '80px',
            'index'     => 'is_active',
            'type'      => 'options',
            'options'   => array(
                1 => Mage::helper('seo')->__('Enabled'),
                0 => Mage::helper('seo')->__('Disabled'),
            ),
        ));

        return parent::_prepareColumns();
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('template_id');
        $this->getMassactionBlock()->setFormFieldName('template_id');

        $this->getMassactionBlock()->addItem('enable', array(
            'label'    => Mage::helper('seo')->__('Enable'),
            'url'      => $this->getUrl('*/*/massEnable')
        ));

        $this->getMassactionBlock()->addItem('disable', array(
            'label'    => Mage::helper('seo')->__('Disable'),
            'url'      => $this->getUrl('*/*/massDisable')
        ));

        $this->getMassactionBlock()->addItem('delete', array(
            'label'    => Mage::helper('seo')->__('Delete'),
            'url'      => $this->getUrl('*/*/massDelete'),
            'confirm'  => Mage::helper('seo')->__('Are you sure?')
        ));

        return $this;
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

}