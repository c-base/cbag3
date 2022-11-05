<?php

namespace Cbase\ArtefactGuide\Application\Console;

use Cbase\ArtefactGuide\Domain\Artefact;
use Cbase\ArtefactGuide\Domain\Image;
use Cbase\ArtefactGuide\Domain\Licence;
use Cbase\ArtefactGuide\Domain\Slug;
use Cbase\Shared\Domain\ArtefactId;
use Cbase\Shared\Domain\ImageId;
use Cbase\Shared\Domain\MemberName;
use Doctrine\ORM\EntityManagerInterface;
use SplFileObject;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(name: self::NAME, description: self::DESCRIPTION)]
class CbagRestoreCommand extends Command
{
    private const NAME = 'cbag:restore';
    private const DESCRIPTION = 'Add a short description for your command';

    public function __construct(private EntityManagerInterface $em)
    {
        parent::__construct();
        $this->em = $em;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $assets = [];
        $artefactAssets = [];

        $filename = 'var/backup/cbag3_asset.json';
        $file = new SplFileObject($filename);
        while ($file->valid()) {
            $line = $file->fgets();
            if (empty($line)) {
                continue;
            }
            $imageData = json_decode($line, true);
            $imageData['author'] = empty($imageData['author']) ? 'alien' : $imageData['author'];
            $imageData['description'] = empty($imageData['description']) ? 'TBD' : $imageData['description'];

            $image = Image::create(
                ImageId::create(),
                $imageData['path'],
                $imageData['description'],
                $imageData['author'],
                new \DateTimeImmutable('2016-01-09 23:42:54'),
                Licence::create($imageData['licence'])
            );

            $this->em->persist($image);
            $assets[$imageData['_id']['$oid']] = $image;
        }
        $this->em->flush();

        $filename = 'var/backup/cbag3_artefact.json';
        $file = new SplFileObject($filename);
        while ($file->valid()) {
            $line = $file->fgets();
            if (empty($line)) {
                continue;
            }
            $artefactData = json_decode($line, true);

            $artefact = Artefact::create(
                ArtefactId::create(),
                $artefactData['name'],
                $artefactData['name'],
                new Slug($artefactData['slug']),
                $artefactData['description'],
                (new \DateTimeImmutable())->setTimestamp(ceil($artefactData['createdAt']['$date'] / 1000)),
                MemberName::create($artefactData['createdBy'] ?? 'alien')
            );

            $jo = empty($artefactData['assets']) ? [] : $artefactData['assets'];
            array_map(function ($assetItem) use ($assets, &$artefactAssets, $artefactData, $artefact) {
                $artefact->addImage($assets[$assetItem['$id']['$oid']]);
            }, $jo);

            $this->em->persist($artefact);
        }
        $this->em->flush();

        //don't forget to free the file handle.
        $file = null;

        return Command::SUCCESS;
    }

    private function getSerializer(): Serializer
    {
        $encoders = [];
        $normalizers = [new ObjectNormalizer()];

        return new Serializer($normalizers, $encoders);
    }
}
