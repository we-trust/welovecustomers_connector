<?php
/**
 * Created by PhpStorm.
 * User: gabrieljadeau
 * Date: 16/11/2017
 * Time: 07:37
 */

class WeLoveCustomers_Connector_Block_Checkout_Onepage_Success_Tag extends Mage_Checkout_Block_Onepage_Success {

    protected $_order;

    /**
     * @return Mage_Core_Helper_Abstract|WeLoveCustomers_Connector_Helper_Data
     */
    public function getWclConnectionHelper(){
        return Mage::helper('wlc_connector');
    }

    /**
     * @return string
     */
    public function getApiKey(){
        return $this->getWclConnectionHelper()->getApiKey();
    }

    /**
     * @return string
     */
    public function getApiGlue(){
        return $this->getWclConnectionHelper()->getApiGlue();
    }

    /**
     * Get last order
     * @return Mage_Sales_Model_Order
     */
    public function getOrder()
    {
        if(is_null($this->_order)){
            $orderId = Mage::getSingleton('checkout/session')->getLastOrderId();
            if ($orderId) {
                $order = Mage::getModel('sales/order')->load($orderId);
                if ($order->getId()) {
                    $this->_order = $order;
                }
            }
        }
        return $this->_order;
    }

    /**
     * @return float
     */
    public function getSubtotal(){
        $order = $this->getOrder();
        return $order->getSubtotal()+$order->getDiscountAmount();

    }
    /**
     * calculation of the hash as per follow: md5(glue . name . email . mobile . amount . coupons . timestamp . purchaseId).
     * @return string
     */
    public function getHash(){
        $order = $this->getOrder();

        $params = array($this->getApiGlue(),
                        $order->getCustomerName(),
                        $order->getCustomerEmail(),
                        ""/*$order->getBillingAddress()->getTelephone()*/,
                        $this->getSubtotal(),
                        $order->getCouponCode(),
                        strtotime($order->getCreatedAtStoreDate()),
                        $order->getIncrementId());

        return md5(implode("", $params));
    }

    public function getLang(){
        return $this->getWclConnectionHelper()->getLang();
    }
}
