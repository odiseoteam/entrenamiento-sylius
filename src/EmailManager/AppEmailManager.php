<?php

namespace App\EmailManager;

use App\Entity\Testimony;
use Sylius\Component\Mailer\Sender\SenderInterface;
use Sylius\Component\Order\Context\CartContextInterface;

class AppEmailManager
{
    /** @var SenderInterface */
    private $emailSender;

    public function __construct(SenderInterface $emailSender, CartContextInterface $cartContext)
    {
        $this->emailSender = $emailSender;
        $cartContext->getCart();
    }

    public function sendTestimonyApprovedEmail(Testimony $testimony): void
    {

        $this->emailSender->send('testimony_approved',
            ['diego@odiseo.com.ar'],
            ['testimony' => $testimony]
        )
        ;
    }
}
