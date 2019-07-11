<?php

namespace App\Menu;

use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

class AdminMenuListener
{
    public function addAdminMenuItems(MenuBuilderEvent $event): void
    {
        $menu = $event->getMenu();

        $testimony = $menu->getChild('catalog')
            ->addChild('testimony', ['route' => 'app_admin_testimony_index'])
            ->setLabel('app.ui.testimonies')
            ->setLabelAttribute('icon', 'talk')
        ;
    }
}
