<?php

namespace Cbase\Cbag3\BaseBundle\Navbar;

use Symfony\Component\HttpFoundation\Request;
use Mopa\Bundle\BootstrapBundle\Navbar\AbstractNavbarMenuBuilder;
use Symfony\Component\Security\Core\SecurityContext;

class MenuBuilder extends AbstractNavbarMenuBuilder
{
    public function createMainMenuRight(Request $request, SecurityContext $securityContext )
    {
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav pull-right');

        if($securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED'))
        {
            $menu->addChild('logout', array('route' => 'logout'));
        }
        return $menu;
    }

    public function createMainMenuLeft(Request $request)
    {
        $menu = $this->createNavbarMenuItem();

        $menu->addChild('Artefact', array('route' => 'artefact_index'));
        $menu->addChild('Media', array('route' => 'asset_index'));

        return $menu;
    }
}
