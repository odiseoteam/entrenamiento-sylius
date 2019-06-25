<?php

namespace App\Calculator;

use App\Entity\Order\Order;
use App\Entity\Shipping\Shipment;
use Sylius\Component\Shipping\Calculator\CalculatorInterface;
use Sylius\Component\Shipping\Model\ShipmentInterface;

class WeightCalculator implements CalculatorInterface
{
    /**
     * @param ShipmentInterface $subject
     * @param array $configuration
     * @return int
     * @throws \Exception
     */
    public function calculate(ShipmentInterface $subject, array $configuration): int
    {
        if (!$subject instanceof Shipment) {
            throw new \Exception();
        }

        /** @var Order $order */
        $order = $subject->getOrder();
        $address = $order->getShippingAddress();

        /** Hardcoded for demo purpouses */
        return $configuration['price'];
    }

    public function getType(): string
    {
        return 'weight';
    }
}
