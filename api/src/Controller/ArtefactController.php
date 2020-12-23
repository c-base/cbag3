<?php
/*
 * (c) 2018 dazz <dazz@c-base.org>
 *
 * For copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare (strict_types=1);

namespace App\Controller;

use App\Entity\Artefact;
use App\Entity\Asset;
use App\Service\RequestObject\UploadAsset;
use App\Service\Slugger;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/artefacts")
 */
class ArtefactController extends AbstractController
{
    /** @var UrlGeneratorInterface */
    private $urlGenerator;

    /** @var ObjectRepository  */
    private $artefactRepository;

    public function __construct(UrlGeneratorInterface $urlGenerator, EntityManagerInterface $entityManager)
    {
        $this->urlGenerator = $urlGenerator;
        $this->artefactRepository = $entityManager->getRepository(Artefact::class);
    }

    /**
     * @Route("/", name="artefact.collection", methods={"GET"})
     */
    public function collection(): JsonResponse
    {
        /** @var Artefact[] $artefacts */
        $artefacts = $this->artefactRepository->findAll();

        $collectionUrl = $this->urlGenerator->generate(
            'artefact.collection',
            [],
            UrlGeneratorInterface::ABSOLUTE_URL
        );
        $artefactContent = array_map(function (Artefact $artefact) {
            $itemUrl = $this->urlGenerator->generate(
                'artefact.item',
                ['slug' => $artefact->getSlug()],
                UrlGeneratorInterface::ABSOLUTE_URL
            );
            return [
                '@id' => $itemUrl,
                '@type' => 'CreativeWork',
                'name' => $artefact->getName(),
                'creator' => '',
                'createdAt' => $artefact->getCreatedAt()->format('Y-m-d'),
                'createdBy' => $artefact->getCreatedBy(),
                'contentLocation' => '',
            ];
        }, $artefacts);
        $content = [
            '@context' => 'http://schema.org',
            '@id' => $collectionUrl,
            '@type' => 'Collection',
            'headline' => 'All collected artefacts of c-base',
            'about' => '',
            'collectionSize' => count($artefacts),
            'artefacts' => $artefactContent,
            'supportedOperation' => [
                [
                    '@type' => 'Operation',
                    'title' => 'Creates a new artefact',
                    'method' => 'POST',
                    'expects' => 'Artefact',
                    'returns' => 'Artefact',
                    'possibleStatus' => [
                        Response::HTTP_CREATED => 'Successful created',
                        Response::HTTP_BAD_REQUEST => 'Bad Request',
                    ]
                ]
            ]
        ];

        return $this->json(
            $content,
            Response::HTTP_OK,
            ['Content-Type' => 'application/ld+json; charset=utf-8']
        );
    }

    /**
     * @Route("/{slug}", name="artefact.item", methods={"GET"})
     */
    public function item(Artefact $artefact): Response
    {
        $itemUrl = $this->urlGenerator->generate(
            'artefact.item',
            ['slug' => $artefact->getSlug()],
            UrlGeneratorInterface::ABSOLUTE_URL
        );
        $assetOperationUrl = $this->urlGenerator->generate(
            'artefact.asset.upload',
            ['slug' => $artefact->getSlug()],
            UrlGeneratorInterface::ABSOLUTE_URL
        );
        $assetContent = array_map(function(Asset $asset) {
            return [
                'author' => $asset->getAuthor(),
                'description' => $asset->getDescription(),
                'license' => $asset->getLicense(),
                'path' => $asset->getPath(),
            ];
        }, $artefact->getAssets());
        $content = [
            '@id' => $itemUrl,
            '@type' => 'CreativeWork',
            'name' => $artefact->getName(),
            'description' => $artefact->getDescription(),
            'createdAt' => $artefact->getCreatedAt()->format('Y-m-d'),
            'createdBy' => $artefact->getCreatedBy(),
            'contentLocation' => '',
            'assets' => $assetContent,
            'supportedOperation' => [
                'artefact.asset.upload' => [
                    '@id' => $assetOperationUrl,
                    '@type' => 'Operation',
                    'title' => 'Upload an asset',
                    'method' => 'POST',
                    'expects' => 'Asset',
                    'returns' => 'Artefact',
                    'possibleStatus' => [
                        Response::HTTP_CREATED => 'Successful created',
                        Response::HTTP_BAD_REQUEST => 'Bad Request',
                    ]
                ]
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
    public function create(
        Request $request,
        Slugger $slugger,
        SerializerInterface $serializer,
        ValidatorInterface $validator,
        TokenStorageInterface $tokenStorage,
        EntityManagerInterface $entityManager
    ): Response {
        /** @var Artefact $artefact */
        $artefact = $serializer->deserialize($request->getContent(), Artefact::class, 'json');
        $artefact->setSlug($slugger->slugify($artefact->getName()));
        $artefact->setCreatedBy($tokenStorage->getToken()->getUsername());

        $errors = $validator->validate($artefact);

        if (count($errors) > 0) {
            $errorsString = (string) $errors;
            throw new BadRequestHttpException($errorsString);
        }

        $entityManager->persist($artefact);
        $entityManager->flush();

        $itemUrl = $this->urlGenerator->generate(
            'artefact.item',
            ['slug' => $artefact->getSlug()],
            UrlGeneratorInterface::ABSOLUTE_URL
        );
        $content = [
            '@id' => $itemUrl
        ];

        return new Response(json_encode($content), Response::HTTP_CREATED, [
            'Content-Type' => 'application/ld+json; charset=utf-8',
            'Location' => $itemUrl
        ]);
    }

    /**
     * @Route("/{slug}", name="artefact.update", methods={"PUT"})
     * @ParamConverter("artefact")
     */
    public function update(Artefact $artefact): Response
    {
        return new Response('', Response::HTTP_OK, [
            'Content-Type' => 'application/ld+json; charset=utf-8',
            'Location' => $this->urlGenerator->generate('artefact.item', ['slug' => $artefact->getSlug()])
        ]);
    }

    /**
     * @Route("/{slug}/assets", name="artefact.asset.upload", methods={"POST"})
     * @ParamConverter("artefact")
     */
    public function assetUpload(
        Artefact $artefact,
        UploadAsset $uploadAsset,
        EntityManagerInterface $entityManager
    ): Response {
        $asset = $uploadAsset->createAsset('var/uploads/assets');
        $artefact->addAsset($asset);

        $entityManager->persist($artefact);
        $entityManager->flush();

        $itemUrl = $this->urlGenerator->generate('artefact.item', ['slug' => $artefact->getSlug()]);
        $content = [
            '@id' => $itemUrl,
            '@type' => 'Operation',
            'title' => 'Upload new asset',
            'expects' => 'Asset',
            'returns' => 'Artefact',
            'possibleStatus' => [
                Response::HTTP_CREATED => 'Successful created',
                Response::HTTP_BAD_REQUEST => 'Bad Request',
            ]
        ];

        return new JsonResponse($content, Response::HTTP_OK, [
            'Content-Type' => 'application/ld+json; charset=utf-8',
            'Location' => $itemUrl
        ]);
    }

    /**
     * @Route("/{slug}/assets", name="artefact.asset.collection", methods={"GET"})
     */
    public function assetCollection(Artefact $artefact): Response
    {
        $assets = $artefact->getAssets();

        $itemUrl = $this->urlGenerator->generate(
            'artefact.asset.collection',
            ['slug' => $artefact->getSlug()],
            UrlGeneratorInterface::ABSOLUTE_URL
        );
        $assetContent = array_map(function(Asset $asset) {
            return [
                'author' => $asset->getAuthor(),
                'description' => $asset->getDescription(),
                'license' => $asset->getLicense(),
                'path' => $asset->getPath(),
            ];
        }, $assets);
        $content = [
            '@id' => $itemUrl,
            '@type' => 'Collection',
            'title' => 'All assets of ' . $artefact->getName(),
            'totalItems' => count($assets),
            'assets' => $assetContent,
            'supportedOperation' => []
        ];

        return new Response(json_encode($content), Response::HTTP_CREATED, [
            'Content-Type' => 'application/ld+json; charset=utf-8',
            'Location' => $itemUrl
        ]);
    }
}
