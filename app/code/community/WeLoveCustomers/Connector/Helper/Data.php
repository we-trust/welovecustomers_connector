<?php
/**
 * Created by PhpStorm.
 * User: gabrieljadeau
 * Date: 16/11/2017
 * Time: 06:23
 */ 
class WeLoveCustomers_Connector_Helper_Data extends Mage_Core_Helper_Abstract {

    CONST XML_PATH_API_KEY      = "wlc_connector/general/api_key";
    CONST XML_PATH_API_GLUE     = "wlc_connector/general/api_glue";

    CONST API_URL               = "https://app.welovecustomers.fr/api/";
    /**
     * @param Varien_Data_Form_Element_Abstract $element
     * @return string
     */
    public function getExtensionVersion()
    {
        return (string) Mage::getConfig()->getNode()->modules->WeLoveCustomers_Connector->version;

    }

    /**
     * Return the domain name of the current website
     * @return string
     */
    public function getDomainName(){
        return Mage::getBaseUrl (Mage_Core_Model_Store::URL_TYPE_WEB);
    }

    public function getLang(){
        return Mage::app()->getLocale()->getLocaleCode();

    }

    /**
     * @return string
     */
    public function getApiUrl() {
        return self::API_URL;
    }
    /**
     * @return string
     */
    public function getApiKey($store_id = null){
        return Mage::getStoreConfig(self::XML_PATH_API_KEY, $store_id);
    }

    /**
     * @return string
     */
    public function getApiGlue($store_id = null){
        return Mage::getStoreConfig(self::XML_PATH_API_GLUE, $store_id);
    }

    public function callApi($service, $content){
        $content = http_build_query($content);

        $context_options = array (
            'http' => array (
                'method' => 'POST',
                'header'=> "Content-type: application/x-www-form-urlencoded\r\n"
                    . "Content-Length: " . strlen($content) . "\r\n",
                'content' => $content
            )
        );

        $context = stream_context_create($context_options);
        $endPoint =  $this->getApiUrl() . $service . DS;

        $fp = @fopen($endPoint, 'r', false, $context);
        $response = false;
        if ($fp){
            while (($buffer = fgets($fp, 4096)) !== false) {
                $response .= $buffer;
            }
            if (!feof($fp)) {
            }
            fclose($fp);

        }

        return $response;
    }
}