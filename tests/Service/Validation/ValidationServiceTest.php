<?php

declare(strict_types=1);

namespace App\Tests\Service\Validation;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Service\Validation\ValidationService;
use App\Exception\ValidationServiceException;

class ValidationServiceTest extends WebTestCase
{
    private $validationService;
    public function setUp(): void
    {
        parent::setUp();
        $this->validationService = new ValidationService();
    }

    public function testSmallFieldExpectMessageMustBe2charactersOrMore(): void
    {
        $this->expectException(ValidationServiceException::class);
        $this->expectExceptionMessage('Must be 2 characters or more');
        $this->validationService->smallField('s', 2, 60);
    }

    public function testSmallFieldExpectMessageMustBe60charactersOrLess(): void
    {
        $this->expectException(ValidationServiceException::class);
        $this->expectExceptionMessage('Must be 60 characters or less');
        $this->validationService->smallField('ssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssss', 2, 60);
    }

    public function testSmallFieldWithDotInStartAndEnd(): void
    {
        $this->expectException(ValidationServiceException::class);
        $this->expectExceptionMessage('Can contain letters, numbers,
!@#$%^&*()_-=+;:\'\"?,<>[]{}\|/№!~\' symbols, 
and dot can\'t use like the first and last symbol and also can\'t be repeated consecutively');
        $this->validationService->smallField('.s.', 2, 60);
    }

    public function testSmallFieldTwoAndMoreDotInRow(): void
    {
        $this->expectException(ValidationServiceException::class);
        $this->expectExceptionMessage('Can contain letters, numbers,
!@#$%^&*()_-=+;:\'\"?,<>[]{}\|/№!~\' symbols, 
and dot can\'t use like the first and last symbol and also can\'t be repeated consecutively');
        $this->validationService->smallField('s..s', 2, 60);
    }

    public function testSmallFieldTwoAndMoreGapsInRow(): void
    {
        $this->expectException(ValidationServiceException::class);
        $this->expectExceptionMessage('Can contain letters, numbers,
!@#$%^&*()_-=+;:\'\"?,<>[]{}\|/№!~\' symbols, 
and dot can\'t use like the first and last symbol and also can\'t be repeated consecutively');
        $this->validationService->smallField('s  s', 2, 60);
    }

    public function testSmallFieldNotCorrectSymbols(): void
    {
        $this->expectException(ValidationServiceException::class);
        $this->expectExceptionMessage('Can contain letters, numbers,
!@#$%^&*()_-=+;:\'\"?,<>[]{}\|/№!~\' symbols, 
and dot can\'t use like the first and last symbol and also can\'t be repeated consecutively');
        $this->validationService->smallField(' ⅚ ⅜ ⅝ ⅞', 2, 60);
    }

    public function testSmallFieldReturnTrue(): void
    {
        self::assertSame(
            true,
            $this->validationService->smallField(
                'Field2021ЯяЁё !@#$%^&*()_-=+;:\'\"?,<>[]{}\|/№!~\'',
                2,
                60
            )
        );
    }

    public function testBigFieldExpectMessageMustBe2charactersOrMore(): void
    {
        $this->expectException(ValidationServiceException::class);
        $this->expectExceptionMessage('Must be 2 characters or more');
        $this->validationService->bigField('s', 2, 255);
    }

    public function testBigFieldExpectMessageMustBe255charactersOrLess(): void
    {
        $this->expectException(ValidationServiceException::class);
        $this->expectExceptionMessage('Must be 255 characters or less');
        $this->validationService->bigField('PlQBbAzaRxAkiqmKqOGfKkyvJhwiGkLzxkHd
        BQqotPtujJcZrAHcxNEWRTNToQoBgKpPgJJagIbgYyyigWsiK
        HzvfuAHbWWixqHpGeeqOFxeswvXwIBeKznzufiCQHcNdPCdYzlzyfIThuPJaxydXHkTzsboDidY
        azjemDSYVMQUvaaFyPTbKIAUSdFdTCMzjRsUzNLdQiBCFJkaxcErYwrzvndbffRSDdbSRGyxttiYxVqqmpJsjJMxsSKeUJOrsss', 2, 255);
    }

    public function testBigFieldWithDotInStartAndEnd(): void
    {
        $this->expectException(ValidationServiceException::class);
        $this->expectExceptionMessage('Can contain letters, numbers, 
!#$%&‘*+—/\=?^_`{|}~!»№;%:?*()[]<>,\' symbols, 
and dot can\'t use like the first and last symbol and also can\'t be repeated consecutively');
        $this->validationService->bigField('.w.', 2, 255);
    }

    public function testBigFieldTwoAndMoreDotInRow(): void
    {
        $this->expectException(ValidationServiceException::class);
        $this->expectExceptionMessage('Can contain letters, numbers, 
!#$%&‘*+—/\=?^_`{|}~!»№;%:?*()[]<>,\' symbols, 
and dot can\'t use like the first and last symbol and also can\'t be repeated consecutively');
        $this->validationService->bigField('s..s', 2, 255);
    }

    public function testBigFieldTwoAndMoreGapsInRow(): void
    {
        $this->expectException(ValidationServiceException::class);
        $this->expectExceptionMessage('Can contain letters, numbers, 
!#$%&‘*+—/\=?^_`{|}~!»№;%:?*()[]<>,\' symbols, 
and dot can\'t use like the first and last symbol and also can\'t be repeated consecutively');
        $this->validationService->bigField('s  s', 2, 255);
    }

    public function testBigFieldNotCorrectSymbols(): void
    {
        $this->expectException(ValidationServiceException::class);
        $this->expectExceptionMessage('Can contain letters, numbers, 
!#$%&‘*+—/\=?^_`{|}~!»№;%:?*()[]<>,\' symbols, 
and dot can\'t use like the first and last symbol and also can\'t be repeated consecutively');
        $this->validationService->bigField('⅚ ⅜ ⅝ ⅞', 2, 255);
    }

    public function testBigField(): void
    {
        self::assertSame(
            true,
            $this->validationService->bigField(
                'Can contain AaФфёЁ, 0123456789, !#$%&‘*+—/\=?^_`{|}~!»№;%:?*()[]<>,\' symbols, and one dot not first or last',
                2,
                255
            )
        );
    }

    public function testPasswordExpectMessageMustBe8charactersOrMore(): void
    {
        $this->expectException(ValidationServiceException::class);
        $this->expectExceptionMessage("Must be 8 characters or more");
        $this->validationService->password('2', 8, 32);
    }

    public function testPasswordExpectMessageMustBe32charactersOrLess(): void
    {
        $this->expectException(ValidationServiceException::class);
        $this->expectExceptionMessage("Must be 32 characters or less");
        $this->validationService->password('1234567891234567891234567891234566', 8, 32);
    }

    public function testPasswordWithDotInStartAndEnd(): void
    {
        $this->expectException(ValidationServiceException::class);
        $this->expectExceptionMessage('Can contain letters, numbers, 
!#$%&‘*+—/\=?^_`{|}~!»№;%:?*()[]<>,\' symbols, and one dot not first or last');
        $this->validationService->password('.ss.ss.ss.', 8, 32);
    }

    public function testPasswordTwoAndMoreDotInRow(): void
    {
        $this->expectException(ValidationServiceException::class);
        $this->expectExceptionMessage('Can contain letters, numbers, 
!#$%&‘*+—/\=?^_`{|}~!»№;%:?*()[]<>,\' symbols, and one dot not first or last');
        $this->validationService->password('ss..ss..ss', 8, 32);
    }

    public function testPasswordNotCorrectSymbols(): void
    {
        $this->expectException(ValidationServiceException::class);
        $this->expectExceptionMessage('Can contain letters, numbers, 
!#$%&‘*+—/\=?^_`{|}~!»№;%:?*()[]<>,\' symbols, and one dot not first or last');
        $this->validationService->password('阿阿阿阿阿阿阿阿', 8, 32);
    }

    public function testPassword(): void
    {
        self::assertSame(true, $this->validationService->password('FfАаё1!#$%&', 8, 32));
    }

    public function testEmailExpectMessageMustBe3charactersOrMore(): void
    {
        $this->expectException(ValidationServiceException::class);
        $this->expectExceptionMessage('Invalid e-mail Address length');
        $this->validationService->email('2', 3, 32);
    }

    public function testEmailExpectMessageMustBe32charactersOrLess(): void
    {
        $this->expectException(ValidationServiceException::class);
        $this->expectExceptionMessage('Invalid e-mail Address length');
        $this->validationService->email('1234567891234567891234567891234566', 3, 32);
    }

    public function testEmailWithDotInStartAndEnd(): void
    {
        $this->expectException(ValidationServiceException::class);
        $this->expectExceptionMessage('Invalid e-mail Address length');
        $this->validationService->email('.ss@ss.com.', 3, 32);
    }

    public function testEmailWithDotInStartAndEndNearAt(): void
    {
        $this->expectException(ValidationServiceException::class);
        $this->expectExceptionMessage('Invalid e-mail Address length');
        $this->validationService->email('s.@.ss.com', 3, 32);
    }

    public function testEmailWithGap(): void
    {
        $this->expectException(ValidationServiceException::class);
        $this->expectExceptionMessage('Invalid e-mail Address length');
        $this->validationService->email('s.@. ss.com', 3, 32);
    }

    public function testEmailNotCorrectSymbols(): void
    {
        $this->expectException(ValidationServiceException::class);
        $this->expectExceptionMessage('Invalid e-mail Address length');
        $this->validationService->email('0s@s!""s.ss', 3, 32);
    }

    public function testEmailNotLatinLetters(): void
    {
        $this->expectException(ValidationServiceException::class);
        $this->expectExceptionMessage('Invalid e-mail Address length');
        $this->validationService->email('0s@sНнs.ss', 3, 32);
    }

    public function testEmail(): void
    {
        self::assertSame(true, $this->validationService->email('sgcore2021@gmail.com', 3, 32));
    }

    public function testcardNumberNotCorrectSymbolsAndNot16Characters(): void
    {
        $this->expectException(ValidationServiceException::class);
        $this->expectExceptionMessage("Wrong card number");
        $this->validationService->cardNumber('adidas');
    }

    public function testcardNumber16CharactersButWithNotCorrectSymbols(): void
    {
        $this->expectException(ValidationServiceException::class);
        $this->expectExceptionMessage("Wrong card number");
        $this->validationService->cardNumber('123456987456321s');
    }

    public function testcardNumberWithGap(): void
    {
        $this->expectException(ValidationServiceException::class);
        $this->expectExceptionMessage("Wrong card number");
        $this->validationService->cardNumber('123456789 23456');
    }

    public function testcardNumber(): void
    {
        self::assertSame(true, $this->validationService->cardNumber("1234567891234567"));
    }

    public function testExpiryDateCardExpired(): void
    {
        $this->expectException(ValidationServiceException::class);
        $this->expectExceptionMessage("Wrong expiry");
        $this->validationService->expiryDate('12/20');
    }

    public function testExpiryDateNotCorrectFormat(): void
    {
        $this->expectException(ValidationServiceException::class);
        $this->expectExceptionMessage("Wrong expiry");
        $this->validationService->expiryDate('1220');
    }

    public function testExpiryDateNotCorrectSymbols(): void
    {
        $this->expectException(ValidationServiceException::class);
        $this->expectExceptionMessage("Wrong expiry");
        $this->validationService->expiryDate('12:20');
    }

    public function testExpiryDate(): void
    {
        self::assertSame(true, $this->validationService->expiryDate('12/30'));
    }

    public function testCvcWrongSymbols(): void
    {
        $this->expectException(ValidationServiceException::class);
        $this->expectExceptionMessage('Wrong cvc number');
        $this->validationService->cvc('!!!');
    }

    public function testCvcIncorrectNumberOfCharacters(): void
    {
        $this->expectException(ValidationServiceException::class);
        $this->expectExceptionMessage('Wrong cvc number');
        $this->validationService->cvc("5555");
    }

    public function testCvc(): void
    {
        self::assertSame(true, $this->validationService->cvc("555"));
    }

    public function testCardholderNameNotEnoughCharacters(): void
    {
        $this->expectException(ValidationServiceException::class);
        $this->expectExceptionMessage('Can contain letters, hyphen and dot');
        $this->validationService->cardholderName('ss');
    }

    public function testCardholderNameNotLatinLetters(): void
    {
        $this->expectException(ValidationServiceException::class);
        $this->expectExceptionMessage('Can contain letters, hyphen and dot');
        $this->validationService->cardholderName('РНО');
    }

    public function testCardholderName(): void
    {
        self::assertSame(true, $this->validationService->cardholderName('D.BOSYI-BOB'));
    }

    public function testValidationLengthExpectMessageMustBe32CharactersOrLess(): void
    {
        $this->expectException(ValidationServiceException::class);
        $this->expectExceptionMessage('Must be 32 characters or less');
        $this->validationService->validationLength(54, 2, 32);
    }

    public function testValidationLengtExpectMessageMustBe2CharactersOrMore(): void
    {
        $this->expectException(ValidationServiceException::class);
        $this->expectExceptionMessage('Must be 2 characters or more');
        $this->validationService->validationLength(1, 2, 32);
    }
}