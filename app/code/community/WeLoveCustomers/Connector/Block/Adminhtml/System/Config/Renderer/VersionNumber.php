<?php


class WeLoveCustomers_Connector_Block_Adminhtml_System_Config_Renderer_VersionNumber extends Mage_Adminhtml_Block_System_Config_Form_Field
{

    /**
     * @return Mage_Core_Helper_Abstract|WeLoveCustomers_Connector_Helper_Data
     */
    public function getWclConnectionHelper(){
        return Mage::helper('wlc_connector');
    }

    /**
     * @param Varien_Data_Form_Element_Abstract $element
     * @return string
     */
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
        $helper = $this->getWclConnectionHelper();
        $version = "Api not called";
        if ($apiKey = $helper->getApiKey()) {
            $callData = array(
                'customerKey' => $apiKey
            );

            $response = $helper->callApi('magentoPluginVersion', $callData);
            if ($response) {
                $objResponse = json_decode($response);
                $version = $objResponse->version;
            }
        }

        return $this->__('%s (latest  version available: %s)', $helper->getExtensionVersion(), $version);
    }

}
