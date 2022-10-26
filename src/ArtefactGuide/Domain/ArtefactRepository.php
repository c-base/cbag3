<?php
/*
 * (c) 2022 dazz <dazz@c-base.org>
 *
 * For copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace ArtefactGuide\Domain;

interface ArtefactRepository
{
    public function all(): ArtefactCollection;

    public function save(Artefact $artefact): void;
}
