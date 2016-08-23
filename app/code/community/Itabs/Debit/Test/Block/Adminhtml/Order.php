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
 * Block/Adminhtml/Order.php Test Class
 *
 * @group Itabs_Debit
 */
class Itabs_Debit_Test_Block_Adminhtml_Order extends EcomDev_PHPUnit_Test_Case_Controller
{
    /**
     * @var Itabs_Debit_Block_Adminhtml_Order
     */
    protected $_block;

    /**
     * Set up the test class
     */
    protected function setUp()
    {
        parent::setUp();
        $this->_block = self::app()->getLayout()->createBlock('debit/adminhtml_order');
    }

    /**
     * @test
     */
    public function testInstance()
    {
        $this->assertInstanceOf('Itabs_Debit_Block_Adminhtml_Order', $this->_block);
    }

    /**
     * @test
     */
    public function testInstanceWithExportRequirements()
    {
        $helperMock = $this->getHelperMock('debit/adminhtml', array());
        $helperMock->expects($this->any())
            ->method('hasExportRequirements')
            ->will($this->returnValue(true));
        $this->replaceByMock('helper', 'debit/adminhtml', $helperMock);

        $block = self::app()->getLayout()->createBlock('debit/adminhtml_order');
        $this->assertInstanceOf('Itabs_Debit_Block_Adminhtml_Order', $block);
    }
}
