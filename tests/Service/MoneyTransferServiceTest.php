<?php

namespace App\Tests\Service;

use App\Entity\Account;
use App\Service\CardGatewayAdapter\GoGatewayAdapter;
use App\Service\CardGatewayAdapter\Interfaces\CardGatewayAdapter;
use App\Service\MoneyTransferService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpFoundation\Response;

class MoneyTransferServiceTest extends KernelTestCase
{
    private CardGatewayAdapter $cardGatewayAdapter;
    private Account $payerAccount;

    private Account $receiverAccount;
    public function setUp(): void
    {
        parent::setUp();
        $this->cardGatewayAdapter = $this->createMock(GoGatewayAdapter::class);
        $this->payerAccount = new Account();
        $this->payerAccount->setCardNumber('payerCardId');
        $this->payerAccount->setUserId('payerUserId');
        $this->receiverAccount = new Account();
        $this->receiverAccount->setCardNumber('receiverCardId');
        $this->receiverAccount->setUserId('receiverUserId');


    }

    public function testSuccessfulPutOnAccount(): void
    {
        $successfulResponseObject = (object) ['success' => 'ok'];

        $this->cardGatewayAdapter->expects($this->once())
            ->method('getCardBalance')
            ->with(
                $this->equalTo($this->receiverAccount->getUserId()),
                $this->equalTo($this->receiverAccount->getCardNumber()),
                'anyToken'
            )
            ->willReturn(100.0);
        $this->cardGatewayAdapter->expects($this->once())
            ->method('updateCardBalance')
            ->with(
                $this->equalTo(200),
                $this->equalTo($this->receiverAccount->getUserId()),
                $this->equalTo($this->receiverAccount->getCardNumber()),
                'anyToken'
            )
            ->willReturn($successfulResponseObject);
        $moneyTransfer = new MoneyTransferService($this->cardGatewayAdapter);
        $response = $moneyTransfer->putMoneyOnAccount($this->receiverAccount, 100, 'anyToken');

        $this->assertNull($response);
    }

    public function testUnsuccessfulPutOnAccount(): void
    {
        $unsuccessfulResponseObject = (object) [
            "code" => 2,
            "details" => [],
            "message" => "Go Error Message"
        ];
        $moneyTransfer = new MoneyTransferService($this->cardGatewayAdapter);

        $this->cardGatewayAdapter->expects($this->once())
            ->method('getCardBalance')
            ->with(
                $this->equalTo($this->receiverAccount->getUserId()),
                $this->equalTo($this->receiverAccount->getCardNumber()),
                'anyToken'
            )
            ->willReturn(100.0);
        $this->cardGatewayAdapter->expects($this->once())
            ->method('updateCardBalance')
            ->with(
                $this->equalTo(200),
                $this->equalTo($this->receiverAccount->getUserId()),
                $this->equalTo($this->receiverAccount->getCardNumber()),
                'anyToken'
            )
            ->willReturn($unsuccessfulResponseObject);

        $this->expectException(\DomainException::class);
        $this->expectExceptionCode(Response::HTTP_ACCEPTED);
        $this->expectExceptionMessage('Go Error Message');
        $moneyTransfer->putMoneyOnAccount($this->receiverAccount, 100, 'anyToken');
    }

    public function testAccountBalanceInsufficient(): void
    {
        $moneyTransfer = new MoneyTransferService($this->cardGatewayAdapter);
        $accountCardNumber = $this->payerAccount->getCardNumber();
        $this->cardGatewayAdapter->expects($this->once())
            ->method('getCardBalance')
            ->with(
                $this->equalTo($this->payerAccount->getUserId()),
                $this->equalTo($accountCardNumber),
                'anyToken'
            )
            ->willReturn(20.0);

        $this->expectException(\DomainException::class);
        $this->expectExceptionCode(Response::HTTP_ACCEPTED);
        $this->expectExceptionMessage("Insufficient funds on card {$accountCardNumber}");

        $this->assertNull($moneyTransfer->takeMoneyFromAccount($this->payerAccount, 200, 'anyToken'));
    }

    public function testSuccessfulTakeFromAccount(): void
    {
        $successfulResponseObject = (object) ['success' => 'ok'];
        $moneyTransfer = new MoneyTransferService($this->cardGatewayAdapter);
        $accountCardNumber = $this->payerAccount->getCardNumber();
        $this->cardGatewayAdapter->expects($this->once())
            ->method('getCardBalance')
            ->with(
                $this->equalTo($this->payerAccount->getUserId()),
                $this->equalTo($accountCardNumber),
                'anyToken'
            )
            ->willReturn(200.0);
        $this->cardGatewayAdapter->expects($this->once())
            ->method('updateCardBalance')
            ->with(
                $this->equalTo(0),
                $this->equalTo($this->payerAccount->getUserId()),
                $this->equalTo($this->payerAccount->getCardNumber()),
                'anyToken'
            )
            ->willReturn($successfulResponseObject);


        $this->assertNull($moneyTransfer->takeMoneyFromAccount($this->payerAccount, 200, 'anyToken'));

    }
}
