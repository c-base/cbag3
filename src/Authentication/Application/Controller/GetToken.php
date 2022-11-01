<?php
/*
 * (c) 2022 dazz <dazz@c-base.org>
 *
 * For copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace Cbase\Authentication\Application\Controller;

#[\Symfony\Component\HttpKernel\Attribute\AsController]
final class GetToken
{
    #[\Symfony\Component\Routing\Annotation\Route(path: '/authentication')]
    public function __invoke()
    {
        // TODO: do redirect with client id and secret
    }

}
