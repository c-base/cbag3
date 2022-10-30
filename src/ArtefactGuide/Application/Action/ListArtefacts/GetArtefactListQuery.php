<?php
/*
 * (c) 2022 dazz <dazz@c-base.org>
 *
 * For copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace ArtefactGuide\Application\Action\ListArtefacts;

use ArtefactGuide\Domain\Artefact;
use ArtefactGuide\Domain\ArtefactCollection;
use ArtefactGuide\Domain\ArtefactRepository;
use Shared\Domain\Utils\CollectionUtils;
use Symfony\Component\Serializer\SerializerInterface;

final class GetArtefactListQuery
{
    public function __construct(
        private SerializerInterface $serializer,
        private ArtefactRepository $artefactRepository,
    ) {
    }

    public function __invoke(): array
    {
        return CollectionUtils::map(function (Artefact $artefact) {
            return $artefact->normalize();
        }, $this->artefactRepository->all());
    }
}
