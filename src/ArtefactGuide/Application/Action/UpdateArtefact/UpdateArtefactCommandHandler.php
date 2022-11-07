<?php
/*
 * (c) 2022 dazz <dazz@c-base.org>
 *
 * For copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace Cbase\ArtefactGuide\Application\Action\UpdateArtefact;

use Cbase\ArtefactGuide\Domain\Artefact;
use Cbase\ArtefactGuide\Domain\ArtefactRepository;
use Cbase\ArtefactGuide\Domain\ImageRepository;
use Cbase\Shared\Domain\ImageId;

final class UpdateArtefactCommandHandler
{
    public function __construct(
        private ArtefactRepository $artefactRepository,
        private ImageRepository $imageRepository,
    ) {
    }

    public function __invoke(UpdateArtefactCommand $command): Artefact
    {
        $artefact = $this->artefactRepository->getBySlug($command->id);

        if (array_key_exists('primaryImage', $command->artefact)) {
            $image = $artefact->getImage(ImageId::create($command->artefact['primaryImage']));
            $artefact->setPrimaryImage($image);
        }
        if (array_key_exists('images', $command->artefact)) {

            $imageIds = array_map(fn($image) => $image['id'], $command->artefact['images']);
            $images = $this->imageRepository->findByImageIds($imageIds);

            $toBeAddedImageIds = $artefact->updateImages($images);
        }

        $this->artefactRepository->save($artefact);

        return $artefact;
    }
}
