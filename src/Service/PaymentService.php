<?php

namespace App\Service;

use App\Entity\Payment;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use function PHPUnit\Framework\throwException;

class PaymentService
{
    protected HttpClientInterface $client;
    protected OneCardInfoService $oneCardInfo;
    protected CheckAuthService $checkAuth;
    protected CurlBalanceUpdate $curlBalanceUpd;
    protected $em;

    public function __construct(HttpClientInterface $client, OneCardInfoService $oneCardInfo, CheckAuthService $checkAuth, EntityManagerInterface $em, CurlBalanceUpdate $curlBalanceUpd)
    {
        $this->client = $client;
        $this->checkAuth = $checkAuth;
        $this->oneCardInfo = $oneCardInfo;
        $this->curlBalanceUpd = $curlBalanceUpd;
        $this->em = $em;
    }

    public function paymentService(string $email, $params): array
    {
       /*$params = json_decode($request->getContent(), true);
        print_r($params);*/
        $amount = $params->amount;
        $cardNumber = $params->cardNumber;

        $timestamp = new DateTimeImmutable(date('d.m.Y H:i:s'));

        $account_debit = $params->account_debit ?? 1111;;
        $subject = $params->subject ?? 'Subject is not specified';
        $token = $params->headersAuth ?? '';

        try {
            $checkAuthResponse = $this->checkAuth->checkAuthentication($email, $token);

            if ($checkAuthResponse['success'] == 'true') {
                $oneCardInfoResponse = $this->oneCardInfo->getCardsInfo($email, $cardNumber);
                $oldBalance = $oneCardInfoResponse['balance'];
                $cardNumber = $oneCardInfoResponse['cardNumber'];

                if ($oldBalance > $amount) {
                    $newBalance = ($oldBalance * 100 - $amount * 100) / 100;
                    $this->em->getConnection()->beginTransaction();
                    $payment = new Payment();
                    $payment->setAmount($amount);
                    $payment->setSubject($subject);
                    $payment->setAccountCreditId($oneCardInfoResponse['id']);
                    $payment->setAccountDebitId($account_debit);
                    $payment->setUserId($email);
                    $payment->setCurrencyId(1);
                    $payment->setCreatedAt($timestamp);
                    $payment->setStatusId(1);
                    $payment->setTypeId(1);
                    $this->em->persist($payment);
                    $this->em->flush($payment);
                    $this->em->getConnection()->commit();
                }
            }
        } catch (\Exception $exception) {
            $this->em->rollback();
            $newBalance = $oldBalance;
            throw new \Exception;
        } finally {
            $this->curlBalanceUpd->curlBalanceUpd($email, $cardNumber, $newBalance);
        }

        return ['success'=>'true'];
    }
}