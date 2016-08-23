<?php
/**
 * This file is part of the Itabs_Debit module.
 *
 * PHP version 5
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * @category  Itabs
 * @package   Itabs_Debit
 * @author    ITABS GmbH <info@itabs.de>
 * @copyright 2008-2014 ITABS GmbH (http://www.itabs.de)
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @version   1.1.0
 * @link      http://www.magentocommerce.com/magento-connect/debitpayment.html
 */
/**
 * Backend View for Bank Data List
 */
class Itabs_Debit_Block_Adminhtml_Bankdata extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    /**
     * Class constructor
     */
    public function __construct()
    {
        /* @var $helper Itabs_Debit_Helper_Data */
        $helper = Mage::helper('debit');

        $this->_controller = 'adminhtml_bankdata';
        $this->_blockGroup = 'debit';
        $this->_headerText = $helper->__('Debit Payment Bank Data');
        parent::__construct();
        $this->_removeButton('add');

        $this->_addButton('upload', array(
            'label'     => $helper->__('Upload'),
            'onclick'   => 'setLocation(\'' . $this->getUrl('*/*/upload') .'\')',
            'class'     => 'add',
        ));
    }
}
