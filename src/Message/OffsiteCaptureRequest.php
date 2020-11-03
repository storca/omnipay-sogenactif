<?php
namespace Omnipay\Sogenactif\Message;

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
