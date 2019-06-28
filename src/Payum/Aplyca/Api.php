<?php

namespace App\Payum\Aplyca;

class Api
{
    protected $environment;
    protected $username;
    protected $password;

    public function __construct()
    {
    }

    public function transaction(array $data)
    {
        // Aca iria la logica para comunicarse con el servicio externo

        return [
            'status' => 'error'
        ];
    }
}
