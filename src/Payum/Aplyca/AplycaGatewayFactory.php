<?php

namespace App\Payum\Aplyca;

use App\Payum\Aplyca\Action\StatusAction;
use Payum\Core\Bridge\Spl\ArrayObject;
use Payum\Core\GatewayFactory;

class AplycaGatewayFactory extends GatewayFactory
{
    protected function populateConfig(ArrayObject $config)
    {
        $config->defaults([
           'payum.factory_name' => 'aplyca',
           'payum.factory_title' => 'Aplyca',
           'payum.action.status' => new StatusAction(),
        ]);

        if (false === $config['payum.api']) {
            $config['payum.default_options'] = [
                'environment' => 'sandbox',
                'username' => 'aplyca',
                'password' => '123456',
            ];

            $config->defaults($config['payum.default_options']);
            $config['payum.required_options'] = ['username', 'password'];
            $config['payum.api'] = function (ArrayObject $config) {
                $config->validateNotEmpty($config['payum.required_options']);

                return new Api($config['environment'], $config['username'], $config['password']);
            };
        }
    }
}
