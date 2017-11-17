<?php


class WeLoveCustomers_Connector_Block_Adminhtml_System_Config_Renderer_Signup extends Mage_Adminhtml_Block_System_Config_Form_Field
{

    public function getLinkUrl(){
        return Mage::helper("adminhtml")->getUrl('*/wlc_connector/createAccount');
    }

    public function getLabel(){
        return $this->__("Create my referral program");
    }

    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
        return $this->__("Please create your account using this link: %s", "<a href=\"" . $this->getLinkUrl() . "\" target=\"_blank\"> ". $this->getLabel() ."</a>");
    }


}
