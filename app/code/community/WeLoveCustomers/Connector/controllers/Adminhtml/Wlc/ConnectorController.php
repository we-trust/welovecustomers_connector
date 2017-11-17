<?php
/**
 * Created by PhpStorm.
 * User: gabrieljadeau
 * Date: 16/11/2017
 * Time: 07:05
 */
class WeLoveCustomers_Connector_Adminhtml_Wlc_ConnectorController extends Mage_Adminhtml_Controller_Action {

    /**
     * @return Mage_Core_Helper_Abstract|WeLoveCustomers_Connector_Helper_Data
     */
    public function getWclConnectionHelper(){
        return Mage::helper('wlc_connector');
    }

    /**
     * @return Mage_Core_Controller_Varien_Action
     */
    public function createAccountAction()
    {
        $helper = $this->getWclConnectionHelper();
        $url = "http://www.welovecustomers.fr/developpez-le-parrainage-en-e-commerce/?utm_campaign=install-plugin&utm_source=magento&utm_medium=%s&utm_term=%s";

        return $this->_redirectUrl($this->__($url,$helper->getExtensionVersion(),$helper->getDomainName()));
    }
}