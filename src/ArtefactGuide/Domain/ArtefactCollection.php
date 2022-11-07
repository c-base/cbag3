<?php
/*
 * (c) 2022 dazz <dazz@c-base.org>
 *
 * For copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace Cbase\ArtefactGuide\Domain;

class ArtefactCollection extends \ArrayObject
{
    public function __construct(array $array = [])
    {
        parent::__construct(self::filter($array));
    }

    private static function filter(array $items = []): array
    {
        return array_filter($items, fn ($artefact) => $artefact instanceof Artefact);
    }

    public function add(...$items): void
    {
        $artefacts = array_filter($items, fn ($artefact) => $artefact instanceof Artefact);
        if (\count($artefacts) === 0) {
            return;
        }
        $this->append($artefacts);
    }
}
