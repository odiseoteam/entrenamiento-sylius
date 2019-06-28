<?php

namespace App\Payum\Aplyca\Action;

use Payum\Core\Action\ActionInterface;
use Payum\Core\Bridge\Spl\ArrayObject;
use Payum\Core\Exception\RequestNotSupportedException;
use Payum\Core\Request\Convert;
use Sylius\Component\Core\Model\PaymentInterface;

class ConvertAction implements ActionInterface
{
    /**
     * @param Convert $request
     *
     * @throws \Payum\Core\Exception\RequestNotSupportedException if the action dose not support the request.
     */
    public function execute($request)
    {
        RequestNotSupportedException::assertSupports($this, $request);

        /** @var PaymentInterface $payment */
        $payment = $request->getSource();
        $model = ArrayObject::ensureArrayObject($payment->getDetails());

        $order = $payment->getOrder();

        $currency = $payment->getCurrencyCode();

        $model['payment_id'] = $payment->getId();
        $model['order_id'] = $order->getId();
        $model['total'] = $payment->getAmount();
        $model['status'] = 'convert';

        $request->setResult((array) $model);
    }

    /**
     * @param mixed $request
     *
     * @return boolean
     */
    public function supports($request)
    {
        return
            $request instanceof Convert &&
            $request->getSource() instanceof PaymentInterface &&
            $request->getTo() == 'array'
        ;
    }
}
