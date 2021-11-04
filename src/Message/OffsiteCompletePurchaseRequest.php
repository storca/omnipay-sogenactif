<?php
namespace Omnipay\Sogenactif\Message;

use Omnipay\Common\Exception\InvalidResponseException;

/**
 * Authorize Request
 */
class OffsiteCompletePurchaseRequest extends OffsiteCompleteAuthorizeRequest
{
    public function sendData($data)
    {
        return $this->response = new OffsiteCompletePurchaseResponse($this, $data);
    }

    public function getData()
    {
        if (!$this->getSeal($this->data) === $this->seal) {
            throw new InvalidResponseException('Reponse not signed correctly');
        }
        /**
         * Convert the sogenactif data format to php array()
         */
        $parts = explode('|', $this->data);
        $data = array();
        foreach ($parts as $part) {
            $subParts = explode('=', $part);
            $data[$subParts[0]] = $subParts[1];
        }
        return $data;
    }
}
