<?php

namespace App\Service;

use App\DTO\RequestPaymentDTO;
use App\Entity\Account;
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
        $account_debit = $params->getAccountDebit() ?? 'mock-1111-1111-1111';
        $account_credit = $params->getAccountCredit() ?? 'mock-1111-1111-1111';
        $subject = $params->getSubject() ?? 'Subject is not specified';
        $currencyId = $params->getCurrency() ?? 1;
        $name = $params->getName() ?? 'NoName';
        $statusId = 1;
        $typeId = 1;


        $timestamp = new DateTimeImmutable(date('d.m.Y H:i:s'));


        try {

            $oneCardInfoResponse = $this->oneCardInfo->getCardsInfo($email, $cardNumber);
            $oldBalance = $oneCardInfoResponse['balance'];

            if ($oldBalance > $amount) {

                $newBalance = ($oldBalance * 100 - $amount * 100) / 100;

                $this->em->getConnection()->beginTransaction();
                $payment = new Payment();
                $payment->setAmount($amount);
                $payment->setSubject($subject);
                $payment->setAccountCreditId($account_credit);
                $payment->setAccountDebitId($account_debit);
                $payment->setUserId($email);
                $payment->setCurrencyId($currencyId);
                $payment->setCreatedAt($timestamp);
                $payment->setStatusId($statusId);
                $payment->setTypeId($typeId);
                $payment->setName($name);
                $this->em->persist($payment);
                $this->em->flush($payment);

                $this->balanceIncrease($account_debit, $amount);
                $this->balanceDecrease($account_credit, $amount);

                $this->em->getConnection()->commit();
            }

        } catch (\Exception $exception) {
            $this->em->rollback();
            $newBalance = $oldBalance;
            throw new \DomainException('Transaction failed', 400);
        } finally {
            $this->curlBalanceUpd->curlBalanceUpd($email, $cardNumber, $newBalance);
        }

        return ['success' => 'true'];
    }

    public function balanceIncrease(string $number, int $amount): void
    {
        $workAccount = $this->em->getRepository(Account::class)->findOneBy(['number' => $number]);

        if ($workAccount) {
            $oldBalance = $workAccount->getBalance();
            $newBalance = ($oldBalance * 100 + $amount * 100) / 100;
            $workAccount->setBalance($newBalance);
            $this->em->persist($workAccount);
            $this->em->flush($workAccount);
            $this->checkCorrectBalance($number, $oldBalance, $amount, '+');
        }
    }

    public function balanceDecrease(string $number, int $amount): void
    {
        $workAccount = $this->em->getRepository(Account::class)->findOneBy(['number' => $number]);

        if ($workAccount) {
            $oldBalance = $workAccount->getBalance();
            $newBalance = ($oldBalance * 100 - $amount * 100) / 100;
            $workAccount->setBalance($newBalance);
            $this->em->persist($workAccount);
            $this->em->flush($workAccount);
            $this->checkCorrectBalance($number, $oldBalance, $amount);
        }
    }

    public function checkCorrectBalance(string $number, int $oldBalance, int $amount, string $sign = '-')
    {
        $workAccount = $this->em->getRepository(Account::class)->findOneBy(['number' => $number]);
        $currentBalance = $workAccount->getBalance();

        $checkBalance = (strcmp($sign, '+') ? ($oldBalance * 100 + $amount * 100) / 100 : ($oldBalance * 100 - $amount * 100) / 100);

        if ($checkBalance <> $currentBalance) {
            throw new \DomainException("Balance isn't correct");
        }
    }
}