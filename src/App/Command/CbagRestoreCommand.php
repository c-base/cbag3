<?php

namespace App\Command;

use ArtefactGuide\Infrastructure\Persistence\Doctrine\Entity\DoctrineArtefact;
use ArtefactGuide\Infrastructure\Persistence\Doctrine\Entity\Asset;
use Doctrine\ORM\EntityManagerInterface;
use SplFileObject;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

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
        $persistedAssets = [];

        $filename = 'var/backup/cbag3_asset.json';
        $file = new SplFileObject($filename);
        while ($file->valid()) {
            $line = $file->fgets();
            if (empty($line)) {
                continue;
            }
            $assetData = json_decode($line, true);
            $assetData['author'] = empty($assetData['author']) ? 'alien' : $assetData['author'];
            $assetData['licence'] = empty($assetData['licence']) ? 'CC-BY-SA' : $assetData['licence'];
            $assetData['description'] = empty($assetData['description']) ? 'TBD' : $assetData['description'];
            $asset = new Asset();
            $this->getSerializer()->denormalize($assetData, Asset::class, null, [
                AbstractNormalizer::OBJECT_TO_POPULATE => $asset,
            ]);
            $asset->setCreatedAt(new \DateTime('2016-01-09 23:42:54'));
            $this->em->persist($asset);
            $assets[$assetData['_id']['$oid']] = $asset;
        }

        $filename = 'var/backup/cbag3_artefact.json';
        $file = new SplFileObject($filename);
        while ($file->valid()) {
            $line = $file->fgets();
            if (empty($line)) {
                continue;
            }
            $artefactData = json_decode($line, true);

            $artefactAssets = empty($artefactData['assets']) ? [] : $artefactData['assets'];
            unset($artefactData['assets'], $artefactData['state'], $artefactData['_id']);
            echo $artefactData['name'] . "\r\n";
            $artefactData['createdAt'] = (new \DateTime())->setTimestamp(
                ceil($artefactData['createdAt']['$date'] / 1000)
            );
            $artefactData['createdBy'] = empty($artefactData['createdBy']) ? 'alien' : $artefactData['createdBy'];

            $artefact = new Artefact();

            array_map(function ($assetItem) use ($assets, $artefact, &$persistedAssets) {
                $artefact->addAsset($assets[$assetItem['$id']['$oid']]);
                $persistedAssets[$assetItem['$id']['$oid']] = $assetItem['$id']['$oid'];
            }, $artefactAssets);

            $this->getSerializer()->denormalize($artefactData, DoctrineArtefact::class, null, [
                AbstractNormalizer::OBJECT_TO_POPULATE => $artefact,
            ]);
            $artefact->setCName($artefactData['name']);

            // add all unassigned assets to the platzhalter artefact
            if ($artefact->getName() === 'platzhalter') {
                $unassigned = array_diff_key($assets, $persistedAssets);
                array_map(static function ($asset) use ($artefact) {
                    $artefact->addAsset($asset);
                }, $unassigned);
            }
            $this->em->persist($artefact);
        }
        $this->em->flush();


        //don't forget to free the file handle.
        $file = null;
//        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }

    private function getSerializer(): Serializer
    {
        $encoders = [];
        $normalizers = [new ObjectNormalizer()];

        return new Serializer($normalizers, $encoders);
    }
}
