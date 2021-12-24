<?php

namespace App\Tests\Service\Validation;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Service\Validation\ValidationService;

class ValidationServiceTest extends WebTestCase
{
    private $validationService;
    public function setUp(): void
    {
        parent::setUp();
        $this->validationService = new ValidationService();
    }

    public function testSmallField(): void
    {
        self::assertSame(['Must be 2 characters or more'], $this->validationService->smallField('s'));
        self::assertSame(
            ['Must be 60 characters or less'],
            $this->validationService->smallField('ssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssss')
        );
        self::assertSame(
            [
                'Must be 60 characters or less',
                'Can contain letters, numbers, !@#$%^&*()_-=+;:\'\"?,<>[]{}\|/№!
                ~\' symbols, and one dot not first or last'
            ],
            $this->validationService->smallField('ssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssss.')
        );
        self::assertSame(
            ['Can contain letters, numbers, !@#$%^&*()_-=+;:\'\"?,<>
            []{}\|/№!~\' symbols, and one dot not first or last'],
            $this->validationService->smallField('.s.')
        );
        self::assertSame(
            [
                'Must be 2 characters or more',
                'Can contain letters, numbers, !@#$%^&*()_-=+;:\'\"?,<>[]{}\|/
                №!~\' symbols, and one dot not first or last'
            ],
            $this->validationService->smallField('.')
        );
        self::assertSame(
            ['Can contain letters, numbers, !@#$%^&*()_-=+;:\'\"?,<>[]{}\
            |/№!~\' symbols, and one dot not first or last'
            ],
            $this->validationService->smallField('...')
        );
        self::assertSame(
            ['Can contain letters, numbers, !@#$%^&*()_-=+;:\'\"?,<>
            []{}\|/№!~\' symbols, and one dot not first or last'],
            $this->validationService->smallField(' ⅚ ⅜ ⅝ ⅞')
        );
        self::assertSame(
            'Field2021ЯяЁё !@#$%^&*()_-=+;:\'\"?,<>[]{}\|/№!~\'',
            $this->validationService->smallField('    Field2021ЯяЁё !@#$%^&*()_-=+;:\'\"?,<>[]{}\|/№!~\'')
        );
    }

    public function testBigField(): void
    {
        self::assertSame(['Must be 2 characters or more'], $this->validationService->bigField('s'));
        self::assertSame(
            [
                'Must be 2 characters or more',
                'Can contain letters, numbers, !#$%&‘*+—/\=?^_`{|}~!»
                №;%:?*()[]<>,\' symbols, and one dot not first or last'
            ],
            $this->validationService->bigField('.')
        );
        self::assertSame(
            ['Must be 255 characters or less'],
            $this->validationService->bigField('С другой стороны рамки
             и место обучения кадров способствует подготовки и
              реализации модели развития. С другой стороны рамки и место обучения
               кадров способствует подготовки и реализации модели развития. Идейные соображения 
               высшего порядка, а также начало повседневной работы по формированию позиции 
               позволяет оценить значение модели  развития')
        );
        self::assertSame(
            [
                'Must be 255 characters or less',
                'Can contain letters, numbers, !#$%&‘*+—/\=?^_`{|}~!»
                №;%:?*()[]<>,\' symbols, and one dot not first or last'
            ],
            $this->validationService->bigField('С другой стороны рамки и место обучения кадров 
            способствует подготовки и реализации модели развития. С другой стороны рамки и место обучения 
            кадров способствует подготовки и реализации модели развития. Идейные соображения высшего порядка, а 
            также начало повседневной работы по формированию позиции позволяет оценить значение модели  развития.')
        );
        self::assertSame(
            ['Can contain letters, numbers, !#$%&‘*+—/\=?^_`{|}~!»
            №;%:?*()[]<>,\' symbols, and one dot not first or last'],
            $this->validationService->bigField('.w.')
        );
        self::assertSame(
            ['Can contain letters, numbers, !#$%&‘*+—/\=?^_`{|}~!»
            №;%:?*()[]<>,\' symbols, and one dot not first or last'],
            $this->validationService->bigField('...')
        );
        self::assertSame(
            ['Can contain letters, numbers, !#$%&‘*+—/\=?^_`{|}~!»
            №;%:?*()[]<>,\' symbols, and one dot not first or last'],
            $this->validationService->bigField('⅚ ⅜ ⅝ ⅞')
        );
        self::assertSame(
            'Can contain AaФфёЁ, 0123456789, !#$%&‘*+—/\=?^_`{|}~!»
            №;%:?*()[]<>,\' symbols, and one dot not first or last',
            $this->validationService->bigField('       Can contain AaФфёЁ, 0123456789, !#$%&‘*+—/\=?^_`{|}~!»
            №;%:?*()[]<>,\' symbols, and one dot not first or last')
        );
    }

    public function testPassword(): void
    {
        self::assertSame(["Must be 8 characters or more"], $this->validationService->password(1234567));
        self::assertSame(
            [
                "Must be 8 characters or more",
                'Can contain letters, numbers, !#$%&‘*+—/\=?^_`{|}~!»
                №;%:?*()[]<>,\' symbols, and one dot not first or last'],
            $this->validationService->password('123456.')
        );
        self::assertSame(
            [
                "Must be 32 characters or less",
                'Can contain letters, numbers, !#$%&‘*+—/\=?^_`{|}~!»
                №;%:?*()[]<>,\' symbols, and one dot not first or last'
            ],
            $this->validationService->password('С другой стороны укрепление и развитие 
            структуры обеспечивает участие в формировании систем массового участия.')
        );
        self::assertSame(
            ["Must be 32 characters or less"],
            $this->validationService->password('1234567891234567891234567891234566')
        );
        self::assertSame(
            ['Can contain letters, numbers, !#$%&‘*+—/\=?^_`{|}~!»
            №;%:?*()[]<>,\' symbols, and one dot not first or last'],
            $this->validationService->password('ss..ss..ss')
        );
        self::assertSame(
            ['Can contain letters, numbers, !#$%&‘*+—/\=?^_`{|}~!»
            №;%:?*()[]<>,\' symbols, and one dot not first or last'],
            $this->validationService->password('阿阿阿阿阿阿阿阿')
        );
        self::assertSame('FfАаё1!#$%&', $this->validationService->password('FfАаё1!#$%&'));
    }

    public function testEmail(): void
    {
        self::assertSame(['Invalid e-mail Address length'], $this->validationService->email(12));
        self::assertSame(
            ['Invalid e-mail Address length'],
            $this->validationService->email('1234567891234567891234567891234566')
        );
        self::assertSame(['Invalid e-mail Address length'], $this->validationService->email('...'));
        self::assertSame(['Invalid e-mail Address length'], $this->validationService->email('.ss.'));
        self::assertSame(['Invalid e-mail Address length'], $this->validationService->email('0.s.@.ss.ss'));
        self::assertSame(['Invalid e-mail Address length'], $this->validationService->email('0.s@ss..ss'));
        self::assertSame(['Invalid e-mail Address length'], $this->validationService->email('0ЁЁЁs@ss.ss'));
        self::assertSame(['Invalid e-mail Address length'], $this->validationService->email('0s@ss.s!""s'));
        self::assertSame(['Invalid e-mail Address length'], $this->validationService->email('0s@s!""s.ss'));
        self::assertSame(['Invalid e-mail Address length'], $this->validationService->email('0s@s   s.ss'));
        self::assertSame('sgcore2021@gmail.com', $this->validationService->email('  SgCOre2021@Gmail.com  '));
    }

    public function testcardNumber(): void
    {
        self::assertSame(["Wrong card number"], $this->validationService->cardNumber('asdas'));
        self::assertSame(["Wrong card number"], $this->validationService->cardNumber('123456987456321s'));
        self::assertSame(["Wrong card number"], $this->validationService->cardNumber('1234 456987 '));
        self::assertSame('1234567891234567', $this->validationService->cardNumber('   1234567891234567   '));
    }

    public function testExpiryDate(): void
    {
        self::assertSame(["Wrong expiry"], $this->validationService->expiryDate('12/20'));
        self::assertSame(["Wrong expiry"], $this->validationService->expiryDate('1220'));
        self::assertSame(["Wrong expiry"], $this->validationService->expiryDate('122022'));
        self::assertSame(["Wrong expiry"], $this->validationService->expiryDate('12a20'));
        self::assertSame(["Wrong expiry"], $this->validationService->expiryDate('12:20'));
        self::assertSame('1224', $this->validationService->expiryDate('12/24'));
    }

    public function testCvc(): void
    {
        self::assertSame(['Wrong cvc number'], $this->validationService->cvc('sss'));
        self::assertSame(['Wrong cvc number'], $this->validationService->cvc('5555'));
        self::assertSame(['Wrong cvc number'], $this->validationService->cvc('55'));
        self::assertSame('555', $this->validationService->cvc('555'));
    }

    public function testCardholderName(): void
    {
        self::assertSame(['Can contain letters, hyphen and dot'], $this->validationService->cardholderName('d'));
        self::assertSame(['Can contain letters, hyphen and dot'], $this->validationService->cardholderName('ыы'));
        self::assertSame(
            ['Can contain letters, hyphen and dot'],
            $this->validationService->cardholderName('ss!@#$%^&*()_+{}":><')
        );
        self::assertSame('D.BOSYI-BOB', $this->validationService->cardholderName('D.Bosyi-BoB'));
    }
}
