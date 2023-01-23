<?php

namespace App\Controller;

use App\Entity\UtilitiesProvider;
use App\Repository\UtilitiesProviderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class UtilitiesController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private SerializerInterface $serializer;

    public function __construct(EntityManagerInterface $entityManager, SerializerInterface $serializer)
    {
        $this->entityManager = $entityManager;
        $this->serializer = $serializer;
    }

    /**
     * @Route("/utilities-providers", name="utilities_providers", methods={"GET"})
     */
    public function getAll(): JsonResponse
    {
        $providers = $this->entityManager->getRepository(UtilitiesProvider::class)->findAll();
        $jsonFormattedProviders = $this->serializer->serialize($providers, 'json');

        return new JsonResponse($jsonFormattedProviders, Response::HTTP_OK, [], true);
    }

    /**
     * @Route ("/utilities-providers/utility/{utility}, name="utilities_providers_by_utility", methods={"GET"})
     */
    public function getByUtility(string $utility): JsonResponse
    {
        $providers = $this->entityManager->getRepository(UtilitiesProvider::class)->findByUtility($utility);
        $jsonFormattedProviders = $this->serializer->serialize($providers, 'json');

        return new JsonResponse($jsonFormattedProviders, Response::HTTP_OK, [], true);
    }

    /**
     * @Route ("/utilities-providers/utilities, name="utilities_providers_utilities", methods={"GET"})
     */
    public function getUtilities(): JsonResponse
    {
        $utilities = $this->entityManager->getRepository(UtilitiesProvider::class)->getUtilities();

        return new JsonResponse($utilities, Response::HTTP_OK);
    }
}
