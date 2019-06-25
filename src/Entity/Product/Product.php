<?php

declare(strict_types=1);

namespace App\Entity\Product;

use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Core\Model\Product as BaseProduct;
use Sylius\Component\Product\Model\ProductTranslationInterface;

/**
 * @Entity
 * @Table(name="sylius_product")
 */
class Product extends BaseProduct
{
    /**
     * @var integer
     *
     * @ORM\Column(name="is_on_sale", type="integer")
     */
    protected $isOnSale;

    protected function createTranslation(): ProductTranslationInterface
    {
        return new ProductTranslation();
    }

    /**
     * @return int
     */
    public function getIsOnSale(): ?bool
    {
        return $this->isOnSale == 1;
    }

    /**
     * @param int $isOnSale
     */
    public function setIsOnSale(int $isOnSale): void
    {
        $this->isOnSale = $isOnSale;
    }
}
