<?php

namespace App\Menu;

use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

class AdminMenuListener
{
    public function addAdminMenuItems(MenuBuilderEvent $event): void
    {
        $menu = $event->getMenu();

        $testimony = $menu->getChild('catalog')
            ->addChild('testimony')
            ->setLabel('Testimony')
            ->setLabelAttribute('icon', 'talk')
        ;
    }
}
