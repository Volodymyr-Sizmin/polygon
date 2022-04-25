<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Serializer;
use DateTimeImmutable;
use DateTime;

class SerializeController extends AbstractController
{

    public function serializeJson($serializable): String
    {
        $dateCallback = function ($innerObject) 
        {
            return $innerObject instanceof DateTimeImmutable ? $innerObject->format(DateTime::ISO8601) : '';
        };
        $defaultContext = [
            AbstractNormalizer::CALLBACKS => [
                'birthday' => $dateCallback
            ]
        ];

        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer(null, null, null, null, null, null, $defaultContext)];
        $serializer = new Serializer($normalizers, $encoders);

        return $serializer->serialize($serializable, 'json');
    }
}
