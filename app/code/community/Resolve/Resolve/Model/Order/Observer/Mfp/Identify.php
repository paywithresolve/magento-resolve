<?php
/**
 * OnePica
 * NOTICE OF LICENSE
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to codemaster@onepica.com so we can send you a copy immediately.
 *
 * @category    Resolve
 * @package     Resolve_Resolve
 * @copyright   Copyright (c) 2014 One Pica, Inc. (http://www.onepica.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Class Resolve_Resolve_Model_Order_Observer_Mfp_Identify
 */
class Resolve_Resolve_Model_Order_Observer_Mfp_Identify
{
    /**
     * Identify MFP and save for user
     *
     * @param Varien_Event_Observer $observer
     */
    public function execute(Varien_Event_Observer $observer)
    {
        $controller = $observer->getControllerAction();
        $resolveMFPId = $controller->getRequest()->getParam('resolve_fpid');
        if (empty($resolveMFPId)) {
            return;
        }
        if (Mage::getSingleton('customer/session')->isLoggedIn()) {
            $this->_updateLoggedInCustomerMFP($resolveMFPId);
        } else {
            $this->_updateGuestCustomerMFP($resolveMFPId);
        }
    }

    /**
     * Update for logged in user
     *
     * @param string $MFPValue
     */
    protected function _updateLoggedInCustomerMFP($MFPValue)
    {
        $customerSession = Mage::getSingleton('customer/session');
        $customer = $customerSession->getCustomer();
        $customerMFPValue = $customer->getResolveCustomerMfp();
        if (empty($customerMFPValue) || ($MFPValue != $customerMFPValue)) {
            $customer->setResolveCustomerMfp($MFPValue);
            $customer->save();
            //in case if customer logout to keep actual value during session
            $this->_updateGuestCustomerMFP($MFPValue);
        }
    }

    /**
     * Update fot not logged in user
     *
     * @param string $MFPValue
     */
    protected function _updateGuestCustomerMFP($MFPValue)
    {
        $customerSession = Mage::getSingleton('customer/session');
        $sessionMFPValue = $customerSession->getResolveCustomerMfp();
        if (empty($sessionMFPValue) || ($MFPValue != $sessionMFPValue)) {
            $customerSession->setResolveCustomerMfp($MFPValue);
        }
    }
}