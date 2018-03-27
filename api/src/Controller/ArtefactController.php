<?php
namespace App\Controller;

use App\Entity\Artefact;
use App\Utils\Slugger;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * @Route("/artefacts")
 */
class ArtefactController extends AbstractController
{
    /** @var UrlGeneratorInterface */
    private $urlGenerator;

    /** @var \Doctrine\Common\Persistence\ObjectRepository  */
    private $artefactRepository;

    public function __construct(UrlGeneratorInterface $urlGenerator, EntityManagerInterface $entityManager)
    {
        $this->urlGenerator = $urlGenerator;
        $this->artefactRepository = $entityManager->getRepository(Artefact::class);
    }

    /**
     * @Route("/", name="artefact.collection", methods={"GET"})
     */
    public function collection()
    {
        /** @var Artefact[] $artefacts */
        $artefacts = $this->artefactRepository->findAll();

        $content = [
            "@context" => "http://www.w3.org/ns/hydra/context.jsonld",
            "@id" => $this->urlGenerator->generate('artefact.collection', [], UrlGeneratorInterface::ABSOLUTE_URL),
            "@type" => "Collection",
            "title" => "All collected artefacts of c-base",
            'totalItems' => count($artefacts),
            "artefacts" => [],
            "supportedOperation" => [
                [
                    "@type" => "Operation",
                    "title" => "Creates a new artefact",
                    "method" => "POST",
                    "expects" => "Artefact",
                    "returns" => "Artefact",
                    "possibleStatus" => [
                        Response::HTTP_CREATED => 'Successful created'
                    ]
                ]
            ]
        ];

        foreach ($artefacts as $artefact) {
            $content['artefacts'][] = [
                '@id' => $this->urlGenerator->generate('artefact.item', ['slug' => $artefact->getSlug()], UrlGeneratorInterface::ABSOLUTE_URL),
                '@type' => 'Class',
                'name' => $artefact->getName(),
                'createdAt' => $artefact->getCreatedAt()->format('Y-m-d'),
                'createdBy' => $artefact->getCreatedBy(),
            ];
        }

        return $this->json(
            $content,
            Response::HTTP_OK,
            ['Content-Type' => 'application/ld+json; charset=utf-8']
        );
    }

    /**
     * @Route("/{slug}", name="artefact.item", methods={"GET"})
     * @ParamConverter("artefact")
     */
    public function item(Artefact $artefact)
    {
        $content = [
            '@id' => $this->urlGenerator->generate('artefact.item', ['slug' => $artefact->getSlug()], UrlGeneratorInterface::ABSOLUTE_URL),
            '@type' => 'Class',
            'name' => $artefact->getName(),
            'description' => $artefact->getDescription(),
            'createdAt' => $artefact->getCreatedAt()->format('Y-m-d'),
            'createdBy' => $artefact->getCreatedBy(),
            'assets' => [
                '@type' => 'Collection',
            ]
        ];

        return $this->json(
            $content,
            Response::HTTP_OK,
            ['Content-Type' => 'application/ld+json; charset=utf-8']
        );
    }

    /**
     * @Route("/", name="artefact.create", methods={"POST"})
     */
    public function create(Request $request, Slugger $slugger)
    {
        return $this->json(
            'item',
            Response::HTTP_CREATED,
            ['Content-Type' => 'application/ld+json; charset=utf-8']
        );
    }
}
