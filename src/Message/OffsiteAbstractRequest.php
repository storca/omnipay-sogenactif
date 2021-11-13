<?php
namespace Omnipay\Sogenactif\Message;

use Omnipay\Common\Exception\InvalidRequestException;

/**
 * Abstract Request
 */
abstract class OffsiteAbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    protected $data;

    /**
     * @param mixed $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    protected $seal;

    /**
     * @param mixed $seal
     */
    public function setSeal($seal)
    {
        $this->seal = $seal;
    }

    protected $interfaceVersion;
    /**
     * @param mixed $interfaceVersion
     */
    public function setInterfaceVersion($interfaceVersion)
    {
        $this->interfaceVersion = $interfaceVersion;
    }

    /**
     * These functions are implemented in the childs of OffSiteAbstractRequest
     */
    abstract public function getRequiredCoreFields();
    abstract public function getRequiredCardFields();
    abstract public function getBaseData();
    abstract public function getEndPoint();

    /**
     * @return array
     */
    abstract public function getTransactionData();

    public function getData()
    {
        //Check if each required field is correctly filled
        foreach ($this->getRequiredCoreFields() as $field) {
            $this->validate($field);
        }
        //$this->validateCardFields(); unused in Sogenactif's API
        return array_merge($this->getBaseData(), $this->getTransactionData());
    }
    
    /**
     * Unused in Sogenactif's API
    public function validateCardFields()
    {
        $card = $this->getCard();
        foreach ($this->getRequiredCardFields() as $field) {
            $fn = 'get' . ucfirst($field); //generate function name
            $result = $card->$fn(); //call function getSomething
            if (empty($result)) {
                throw new InvalidRequestException("The $field parameter is required");
            }
        }
    }
    */

    public function getMerchantID()
    {
        return $this->getParameter('merchant_id');
    }

    public function setMerchantID($value)
    {
        return $this->setParameter('merchant_id', $value);
    }

    public function getSecretKey()
    {
        return $this->getParameter('secret_key');
    }

    public function setSecretKey($value)
    {
        return $this->setParameter('secret_key', $value);
    }

    /**
     * @return mixed
     */
    public function getKeyVersion()
    {
        return $this->getParameter('key_version');
    }

    /**
     * @param string $value
     */
    public function setKeyVersion($value)
    {
        $this->setParameter('key_version', $value);
    }

    public function getTransactionType()
    {
        return $this->getParameter('transactionType');
    }

    public function setTransactionType($value)
    {
        return $this->setParameter('transactionType', $value);
    }

    public function getSeal($data_str)
    {
        //return hash('sha256', $data . $this->getSecretKey());
        return hash_hmac('sha256', $data_str, $this->getSecretKey());
    }
}
