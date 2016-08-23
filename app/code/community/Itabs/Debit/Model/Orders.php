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
 * Model for Export Orders
 *
 * @method int getEntityId()
 * @method Itabs_Debit_Model_Orders setEntityId(int $value)
 * @method int getStoreId()
 * @method Itabs_Debit_Model_Orders setStoreId(int $value)
 * @method int getCustomerId()
 * @method Itabs_Debit_Model_Orders setCustomerId(int $value)
 * @method float getGrandTotal()
 * @method Itabs_Debit_Model_Orders setGrandTotal(float $value)
 * @method string getIncrementId()
 * @method Itabs_Debit_Model_Orders setIncrementId(string $value)
 * @method string getOrderCurrencyCode()
 * @method Itabs_Debit_Model_Orders setOrderCurrencyCode(string $value)
 * @method string getBillingName()
 * @method Itabs_Debit_Model_Orders setBillingName(string $value)
 * @method string getCreatedAt()
 * @method Itabs_Debit_Model_Orders setCreatedAt(string $value)
 * @method int getStatus()
 * @method Itabs_Debit_Model_Orders setStatus(int $value)
 * @method string getDebitType()
 * @method Itabs_Debit_Model_Orders setDebitType(string $value)
 */
class Itabs_Debit_Model_Orders extends Mage_Core_Model_Abstract
{
    /**
     * Init model and resource model
     */
    protected function _construct()
    {
        $this->_init('debit/orders');
    }
}
