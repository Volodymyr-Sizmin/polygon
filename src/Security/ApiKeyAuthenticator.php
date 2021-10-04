<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\PassportInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;
use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;
use App\Repository\ApiTokenRepository;
use Doctrine\ORM\EntityManagerInterface;

 
class ApiKeyAuthenticator extends AbstractAuthenticator 
implements AuthenticationEntryPointInterface
{

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    
    private $apiTokenRepo;

    public function __construct(ApiTokenRepository $apiTokenRepo, EntityManagerInterface $entityManager){
        $this->apiTokenRepo = $apiTokenRepo;
        $this->entityManager = $entityManager;
    }

    public function supports(Request $request): ?bool
    {
        return $request->headers->has('X-AUTH-TOKEN');
    }
    
    public function authenticate(Request $request): PassportInterface
    {
        $apiToken = $request->headers->get('X-AUTH-TOKEN');

        return new SelfValidatingPassport(new UserBadge($apiToken, function($credentials){
            $token = $this->apiTokenRepo->findOneBy(['token' => $credentials]);
            if (!$token){
                throw new CustomUserMessageAuthenticationException('Unauthorized access');
            }
            if($token->checkExpired()){
                $user = $token->getUser();
                $user->removeApiToken($token);
                $this->entityManager->remove($token);
                $this->entityManager->flush();
                throw new CustomUserMessageAuthenticationException('Unauthorized access');
            }
            $token->renewExpiresAt();
            return $token->getUser();
        }));
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        $data = [
            'success'=> false,
            'body' => [
                'message' => strtr($exception->getMessageKey(), $exception->getMessageData())
            ]
        ];

        return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);    
    }

   public function start(Request $request, AuthenticationException $authException = null): ?Response
   {
        $authException = new CustomUserMessageAuthenticationException('No API token provided');
        return $this->onAuthenticationFailure($request,$authException);
   }
}
