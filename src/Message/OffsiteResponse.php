<?php
namespace Omnipay\Sogenactif\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;
use Omnipay\Common\Message\RedirectResponseInterface;

use Omnipay\Sogenactif\Message\OffsiteAbstractRequest;

/**
 * Response
 */
class OffsiteResponse extends AbstractResponse implements RedirectResponseInterface
{
  /**
   * endpoint is the remote url - should be provided by the processor.
   * we are using github as a filler
   *
   * @var string
   */
    protected $endpoint;

    public function __construct(OffsiteAbstractRequest $request, $data)
    {
        $this->request = $request;
        $this->data = $data;
        $this->endpoint = ($request->getEndPoint());
    }

    /**
     * @return string
     */
    public function getEndpoint()
    {
        return $this->endpoint;
    }

    /**
     * @param string $endpoint
     */
    public function setEndpoint($endpoint)
    {
        $this->endpoint = $endpoint;
    }

    /**
     * @return string
     */
    private function getSecretKey()
    {
        return $this->data['secret_key'];
    }

    /**
     * Has the call to the processor succeeded?
     * When we need to redirect the browser we return false as the transaction is not yet complete
     *
     * @return bool
     */
    public function isSuccessful()
    {
        return false;
    }

    /**
     * Should the user's browser be redirected?
     * Yes, it is then redirected using the functions below 
     *
     * @return bool
     */
    public function isRedirect()
    {
        return true;
    }

    /**
     * Transparent redirect is the mode whereby a form is presented to the user that POSTs to the payment
     * processor site directly. If this returns true the site will need to provide a form for this
     *
     * @return bool
     */
    public function isTransparentRedirect()
    {
        return true;
    }

    public function getRedirectUrl()
    {
        return $this->endpoint;
    }

    /**
     * Should the browser redirect using GET or POST
     * @return string
     */
    public function getRedirectMethod()
    {
        return 'POST';
    }

    public function getRedirectData()
    {
        $allFields = $this->getData();
        $formData = array();
        //the 'data' field was buit in OffsiteAuthoriseRequest.php in getTransactionData
        foreach ($allFields['data'] as $field => $value) {
            $formData[] = "{$field}={$value}";
        }
        $data = implode('|', $formData);

        return array(
            'Data' => $data,
            'InterfaceVersion' => 'HP_2.39',
            //'seal' => hash('sha256', $data . $this->getSecretKey()),
            'Seal' => $this->getSeal($data),
            'SealAlgorithm' => 'HMAC-SHA-256'
        );
    }
    /**
     * Generate seal according to Sogenactif's documentation
     */
    public function getSeal($data)
    {
        return hash_hmac('sha256', utf8_encode($data), utf8_encode($this->getSecretKey()));
    }
}
