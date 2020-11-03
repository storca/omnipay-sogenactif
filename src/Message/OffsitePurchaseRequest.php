<?php
namespace Omnipay\Sips\Message;

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
