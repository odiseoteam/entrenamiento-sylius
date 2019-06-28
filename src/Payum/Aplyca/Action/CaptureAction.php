<?php

namespace App\Payum\Aplyca\Action;

use App\Payum\Aplyca\Api;
use Payum\Core\Action\ActionInterface;
use Payum\Core\ApiAwareTrait;
use Payum\Core\Bridge\Spl\ArrayObject;
use Payum\Core\Exception\RequestNotSupportedException;
use Payum\Core\Request\Capture;

class CaptureAction implements ActionInterface
{
    use ApiAwareTrait;

    public function __construct(Api $api)
    {
        $this->api = $api;
    }

    /**
     * @param Capture $request
     *
     * @throws \Payum\Core\Exception\RequestNotSupportedException if the action dose not support the request.
     */
    public function execute($request)
    {
        RequestNotSupportedException::assertSupports($this, $request);

        $model = ArrayObject::ensureArrayObject($request->getModel());

        if (isset($model['status']) && $model['status'] == 'captured') {
            return;
        }

        /** @var Api $api */
        $api = $this->api;
        $response = $api->transaction($model->toUnsafeArray());

        if ($response['status'] == 'ok') {
            $model['status'] = 'captured';
        } else {
            $model['status'] = 'failed';
        }
    }

    /**
     * @param mixed $request
     *
     * @return boolean
     */
    public function supports($request)
    {
        return
            $request instanceof Capture &&
            $request->getModel() instanceof \ArrayAccess
        ;
    }
}
