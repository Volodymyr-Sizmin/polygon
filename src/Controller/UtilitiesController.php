<?php

namespace App\Controller;

use App\Entity\UtilitiesProvider;
use App\Repository\UtilitiesProviderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UtilitiesController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private UtilitiesProviderRepository $utilitiesProviderRepository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->utilitiesProviderRepository = getRepository(UtilitiesProvider::class);
    }

    /**
     * @Route("/utilities-providers", name="utilities-providers", methods={"GET"})
     */
    public function getAll(): JsonResponse
    {
        $providers = $this->utilitiesProviderRepository->findAll();

        return $this->json($providers, Response::HTTP_OK);
    }

    /**
     * @Route ("/utilities-providers/by-utility/{utility}", name="utilities_providers_by_utility", methods={"GET"})
     */
    public function getByUtility(string $utility): JsonResponse
    {
        $providers = $this->utilitiesProviderRepository->findByUtility($utility);

        return $this->json($providers, Response::HTTP_OK);
    }

    /**
     * @Route ("/utilities-providers/utilities", name="utilities_providers_utilities", methods={"GET"})
     */
    public function getUtilities(): JsonResponse
    {
        $utilities = $this->utilitiesProviderRepository->getUtilities();

        return $this->json($utilities, Response::HTTP_OK);
    }
}
