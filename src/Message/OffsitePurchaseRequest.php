<?php
namespace Omnipay\Sogenactif\Message;

/**
 * Purchase Request
 */
class OffsitePurchaseRequest extends OffsiteAuthorizeRequest
{
    public function getTransactionType()
    {
        return 'sale';
    }
}
