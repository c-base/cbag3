<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class EntrypointController extends AbstractController
{
    /**
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;

    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * @Route("/", name="entrypoint", methods={"GET"})
     */
    public function entrypoint()
    {
        $content = [
            "@context" => "http://www.w3.org/ns/hydra/context.jsonld",
            "@id" => $this->urlGenerator->generate('entrypoint', [], UrlGeneratorInterface::ABSOLUTE_URL),
            "@type" => "Entrypoint",
            "title" => "The CBAG3 Artefact Guide API",
            "artefacts" => [
                "@id" => $this->urlGenerator->generate('artefact.collection', [], UrlGeneratorInterface::ABSOLUTE_URL),
                "@type" => "Collection"
            ],
            "assets" => [ "@id" => "/assets/", "@type" => "Collection" ],
        ];
        return new Response(
            json_encode($content, JSON_PRETTY_PRINT),
            Response::HTTP_OK,
            ['Content-Type' => 'application/ld+json; charset=utf-8']
        );
    }
}
