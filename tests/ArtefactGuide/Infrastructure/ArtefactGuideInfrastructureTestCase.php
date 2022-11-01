<?php
/*
 * (c) 2022 dazz <dazz@c-base.org>
 *
 * For copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace Tests\ArtefactGuide\Infrastructure;

use Cbase\ArtefactGuide\Domain\ArtefactRepository;
use Tests\Shared\Infrastructure\PhpUnit\InfrastructureTestCase;

abstract class ArtefactGuideInfrastructureTestCase extends InfrastructureTestCase
{
    protected function repository(): ArtefactRepository
    {
        return $this->service(ArtefactRepository::class);
    }
}
