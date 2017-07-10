<?php

/**
 *
 * @author     Darko Goleš <darko.goles@inchoo.net>
 * @package    Inchoo
 * @subpackage RestConnect
 *
 * Url of controller is: http://magento.loc/restconnect/test/[action]
 */
class Fyb_Window_TestController extends Mage_Core_Controller_Front_Action {

    public function indexAction() {
//        $callbackUrl = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']; // This scripts url
//        $magentoUrl = 'https://takeaway.dannevang.org/'; // The url of your magento installation
//        $temporaryCredentialsRequestUrl = $magentoUrl . 'oauth/initiate?oauth_callback=' . urlencode($callbackUrl);
//        $adminAuthorizationUrl = $magentoUrl . 'manager/oauth_authorize';
//        $accessTokenRequestUrl = $magentoUrl . 'oauth/token';
//        $apiUrl = $magentoUrl . 'api/rest';

//        $callbackUrl = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']; // This scripts url
        $magentoUrl = 'https://takeaway.dannevang.org/'; // The url of your magento installation
//        $temporaryCredentialsRequestUrl = $magentoUrl . 'oauth/initiate?oauth_callback=' . urlencode($callbackUrl);
//        $adminAuthorizationUrl = $magentoUrl . 'manager/oauth_authorize';
//        $accessTokenRequestUrl = $magentoUrl . 'oauth/token';
//        $apiUrl = $magentoUrl . 'api/rest';

//        $params = array(
//            'siteUrl' => 'http://magento.loc/oauth',
//            'requestTokenUrl' => 'http://magento.loc/oauth/initiate',
//            'accessTokenUrl' => 'http://magento.loc/oauth/token',
//            'authorizeUrl' => 'http://magento.loc/admin/oAuth_authorize', //This URL is used only if we authenticate as Admin user type
//            'consumerKey' => 'h7n8qjybu78cc3n8cdd5dr7ujtl33uqh', //Consumer key registered in server administration
//            'consumerSecret' => '2smfjx37a6e4w23jlcrya6iyv5v32fxr', //Consumer secret registered in server administration
//            'callbackUrl' => 'http://magento.loc/restconnect/test/callback', //Url of callback action below
//        );

        //Basic parameters that need to be provided for oAuth authentication
        //on Magento
        $params = array(
            'siteUrl' => 'http://127.0.0.1/magento1.9/index.php/tiers/test/',
            'requestTokenUrl' => 'https://takeaway.dannevang.org/oauth/initiate'.'?oauth_callback=' . urlencode('http://127.0.0.1/magento1.9/index.php/tiers/test/callback/'),
            'accessTokenUrl' => 'https://takeaway.dannevang.org/oauth/token',
            'authorizeUrl' => 'https://takeaway.dannevang.org/manager/oauth_authorize', //This URL is used only if we authenticate as Admin user type
            'consumerKey' => 'c159f1dbc327fc0b85da4b4988392668', //Consumer key registered in server administration
            'consumerSecret' => '871743b47fe7e0f728698cc25aca4b9f', //Consumer secret registered in server administration
            'callbackUrl' => 'http://127.0.0.1/magento1.9/index.php/tiers/test/callback/', //Url of callback action below
        );

        $oAuthClient = Mage::getModel('fybwindow/oauth_client');
        $oAuthClient->reset();

        $oAuthClient->init($params);
        $oAuthClient->authenticate();

        return;
    }

    public function callbackAction() {

        $oAuthClient = Mage::getModel('fybwindow/oauth_client');
        $params = $oAuthClient->getConfigFromSession();
        $oAuthClient->init($params);

        $state = $oAuthClient->authenticate();

        if ($state == Fyb_Window_Model_Oauth_Client::OAUTH_STATE_ACCESS_TOKEN) {
            $acessToken = $oAuthClient->getAuthorizedToken();
        }

        $restClient = $acessToken->getHttpClient($params);
        // Set REST resource URL
        $restClient->setUri('https://takeaway.dannevang.org/api/rest/products');
        // In Magento it is neccesary to set json or xml headers in order to work
        $restClient->setHeaders('Accept', 'application/json');
        // Get method
        $restClient->setMethod(Zend_Http_Client::GET);
        //Make REST request
        $response = $restClient->request();
        // Here we can see that response body contains json list of products
        Zend_Debug::dump($response);

        return;
    }

}