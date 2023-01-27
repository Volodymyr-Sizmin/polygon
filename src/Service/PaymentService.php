<?php

namespace App\Service;

use App\DTO\RequestPaymentDTO;
use App\Entity\Payment;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use function PHPUnit\Framework\throwException;

class PaymentService
{
    protected HttpClientInterface $client;
    protected OneCardInfoService $oneCardInfo;
    protected CheckAuthService $checkAuth;
    protected CurlBalanceUpdate $curlBalanceUpd;
    protected EntityManagerInterface $em;

    public function __construct(HttpClientInterface $client, OneCardInfoService $oneCardInfo, CheckAuthService $checkAuth, EntityManagerInterface $em, CurlBalanceUpdate $curlBalanceUpd)
    {
        $this->client = $client;
        $this->checkAuth = $checkAuth;
        $this->oneCardInfo = $oneCardInfo;
        $this->curlBalanceUpd = $curlBalanceUpd;
        $this->em = $em;
    }

    public function paymentService(string $email, RequestPaymentDTO $params): array
    {
        $amount = $params->getAmount();
        $cardNumber = $params->getCardNumber();
        $account_debit = $params->getAccountDebit() ?? 'mock-1111-1111-1111';;
        $subject = $params->getSubject() ?? 'Subject is not specified';
        $token = $params->getHeadersAuth() ?? '';
        $currencyId = $params->getCurrency() ?? 1;
        $name= $params->getName() ?? 'NoName';
        $statusId = 1;
        $typeId = 1;


        $timestamp = new DateTimeImmutable(date('d.m.Y H:i:s'));


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
                    $payment->setCurrencyId($currencyId);
                    $payment->setCreatedAt($timestamp);
                    $payment->setStatusId($statusId);
                    $payment->setTypeId($typeId);
                    $this->em->persist($payment);
                    $this->em->flush($payment);
                    $this->em->getConnection()->commit();
                }
            }
        } catch (\Exception $exception) {
            $this->em->rollback();
            $newBalance = $oldBalance;
            throw new \DomainException('Transaction failed', 400);
        } finally {
            $this->curlBalanceUpd->curlBalanceUpd($email, $cardNumber, $newBalance);
        }

        return ['success'=>'true'];
    }
}