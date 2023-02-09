<?php

namespace App\Controller;

use App\Entity\UtilitiesProvider;
use App\Repository\UtilitiesProviderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UtilityProvidersController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/utilities-providers", name="utilities_providers", methods={"GET"})
     */
    public function getAll(): JsonResponse
    {
        $utilitiesProviderRepository = $this->entityManager->getRepository(UtilitiesProvider::class);
        $providers = $utilitiesProviderRepository->findAll();

        return $this->json($providers, Response::HTTP_OK);
    }

    /**
     * @Route ("/utilities-providers/by-utility/{utility}", name="utilities_providers_by_utility", methods={"GET"})
     */
    public function getByUtility(string $utility): JsonResponse
    {
        $utilitiesProviderRepository = $this->entityManager->getRepository(UtilitiesProvider::class);
        $providers = $utilitiesProviderRepository->findByUtility($utility);

        return $this->json($providers, Response::HTTP_OK);
    }

    /**
     * @Route ("/utilities-providers/utilities", name="utilities_providers_utilities", methods={"GET"})
     */
    public function getUtilities(): JsonResponse
    {
        $utilitiesProviderRepository = $this->entityManager->getRepository(UtilitiesProvider::class);
        $utilities = $utilitiesProviderRepository->getUtilities();

        return $this->json($utilities, Response::HTTP_OK);
    }
}
