<?php
namespace Omnipay\Sogenactif\Message;

//use Guzzle\Http\ClientInterface;

use Omnipay\Common\Exception\InvalidRequestException;

/**
 * Sample Complete Authorize Response
 * The complete authorize action involves interpreting the an asynchronous response.
 * These are most commonly https POSTs to a specific URL. Also sometimes known as IPNs or Silent Posts
 *
 * The data passed to these requests is most often the content of the POST and this class is responsible for
 * interpreting it
 */
class OffsiteCompleteAuthorizeRequest extends OffsiteAbstractRequest
{

    public function getRequiredCoreFields() {}
    public function getRequiredCardFields() {}
    public function getBaseData() {}
    public function getTransactionData() {}

    public function sendData($data)
    {
        return $this->response = new OffsiteCompleteAuthorizeResponse($this, $data);
    }

    public function getData()
    {
        //BUG: getHash does not exist
        if ($this->httpRequest->request->get('Seal') !== $this->getHash()) {
            throw new InvalidRequestException('Incorrect hash');
        }

        return $this->httpRequest->request->all();
    }

    public function getHash()
    {
        //TODO
        return '';
    }
}
