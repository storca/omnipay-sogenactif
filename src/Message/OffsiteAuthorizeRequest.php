<?php
namespace Omnipay\Sogenactif\Message;

use Omnipay\Sogenactif\Message\AbstractRequest;

/**
 * Sogenactif Authorize Request
 */
class OffsiteAuthorizeRequest extends OffsiteAbstractRequest
{

    /**
     * Endpoint is the remote url.
     *
     * @var string
     */
    public $testEndpoint = 'https://payment-webinit.simu.sogenactif.com/paymentInit';

    public $liveEndpoint = 'https://payment-webinit.sogenactif.com/paymentInit';

    /**
     * sendData function. 
     * In this case, we do not need to make a request using httpClient because the client will enter his details
     * on sogenactif's page.
     * We only need to create a sort of "virtual" response that is only a redirect, which redirects the client
     * to sogenactif's payment page.
     * See OffSiteResponse.php, where the redirect is actually built
     * @param mixed $data
     * @return \Omnipay\Common\Message\ResponseInterface|OffsiteAuthorizeResponse
     */
    public function sendData($data)
    {
        return $this->response = new OffsiteAuthorizeResponse($this, $data, $this->getEndpoint());
    }

    /**
     * Get an array of the required fields for the core gateway
     * @return array
     */
    public function getRequiredCoreFields()
    {
        return array
        (
            'amount',
            'currency',
        );
    }

    /**
     * get an array of the required 'card' fields (personal information fields)
     * @return array
     */
    public function getRequiredCardFields()
    {
        return array
        (
            'email',
        );
    }

    /**
     * Map Omnipay normalised fields to gateway defined fields. If the order the fields are
     * passed to the gateway matters you should order them correctly here
     *
     * @return array
     * @throws \Omnipay\Common\Exception\InvalidRequestException
     */
    public function getTransactionData()
    {
        $data_array = array
        (
            'data' => array(
                'amount' => $this->getAmountInteger(),
                'currencyCode' => $this->getCurrencyNumeric(),
                'keyVersion' => $this->getKeyVersion(),
                'merchantId' => $this->getMerchantID(),
                'automaticResponseUrl' => $this->getNotifyUrl(),
                'normalReturnUrl'=> $this->getReturnUrl(),
                'transactionReference' => $this->getTransactionId(),
            ),
        );
        //this data is later encoded in OffsiteResponse::getRedirectData

        /**
        $encoded_data = '';
        foreach($data_array as $key => $value)
        {
            $encoded_data = $encoded_data . $key . '=' . $value .'|';
        }

        return utf8_encode(substr($encoded_data, 0, -1));
        */

        return $data_array;

    }

    /**
     * @return array
     * Get data that is common to all requests - generally aut
     */
    public function getBaseData()
    {
        return array(
            'type' => $this->getTransactionType(),
            'merchant_id' => $this->getMerchantID(),
            'secret_key' => $this->getSecretKey(),
        );
    }

    /**
     * this is the url provided by your payment processor. Github is standing in for the real url here
    * @return string
    */
    public function getEndpoint()
    {
        return $this->getTestMode() ? $this->testEndpoint : $this->liveEndpoint;
    }

    public function getTransactionType()
    {
        return 'Authorize';
    }
}
