<?php
namespace App\Command;

use App\Entity\Artefact;
use App\Entity\Asset;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class AppDataImportCommand extends Command
{
    protected static $defaultName = 'app:data:import';

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }

    protected function configure()
    {
        $this
            ->setDescription('Imports date from file into database')
            ->setHelp('This command imports data from a file')
            ->addArgument('file', InputArgument::REQUIRED)
            ->addArgument('drop', InputArgument::OPTIONAL, '', true)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $string = file_get_contents($input->getArgument('file'));
        $data = json_decode($string, true);

        $this->beforeImport($output, $input->getArgument('drop'));

        $assets = [];

        foreach ($data['assets'] as $item) {
            $asset = new Asset(
                $item['path'],
                isset($item['description']) ? $item['description'] : "missing",
                isset($item['author']) ? $item['author'] : "alien",
                isset($item['license']) ? $item['license'] : "CC-BY-NC-SA"
            );
            $assets[$item['_id']['$oid']] = $asset;
            $this->entityManager->persist($asset);
        }
        $this->entityManager->flush();

        foreach ($data['artefacts'] as $item) {
            $artefact = new Artefact(
                $item['name'],
                $item['slug'],
                $item['description'],
                new \DateTime('@' . ($item['createdAt']['$date']/1000)),
                isset($item['createdBy']) ? $item['createdBy'] : 'alien'
            );

            if (isset($item['assets'])) {
                foreach ($item['assets'] as $asset) {
                    $artefact->addAsset($assets[$asset['$id']['$oid']]);
                }
            }

            $this->entityManager->persist($artefact);
        }
        $this->entityManager->flush();
    }

    private function beforeImport($output, $withSchemaDrop = true)
    {
        if (! $withSchemaDrop) {
            return;
        }

        try {
            $this
                ->getApplication()
                ->find('doctrine:schema:drop')
                ->run(
                    new ArrayInput(['command' => 'doctrine:schema:drop', '--full-database' => true, '-f' => true, '-q' => true]),
                    $output
                )
            ;

            $this
                ->getApplication()
                ->find('doctrine:schema:create')
                ->run(
                    new ArrayInput(['command' => 'doctrine:schema:create', '--quiet' => true]),
                    $output
                )
            ;
        } catch (\Exception $e) {
        }
    }
}
