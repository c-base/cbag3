<?php

namespace Cbase\Core\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class CbaseCoreUserBundle extends Bundle
{
    public function getParent()
    {
        return 'IMAGLdapBundle';
    }

}
