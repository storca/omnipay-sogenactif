<?php
namespace Omnipay\Sips\Message;

/**
 * Capture Request
 */
class OffsiteCaptureRequest extends OffsiteAuthorizeRequest
{
    public function getTransactionType()
    {
        return 'capture';
    }
}
