<?php

namespace App\Tests\Entity;

use App\Entity\Kana;
use App\Enum\KanaTypeEnum;
use App\Tests\Traits\ValidatorTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class KanaTest extends WebTestCase
{
    use ReloadDatabaseTrait;
    use ValidatorTrait;

    private ValidatorInterface $validator;

    protected function setUp(): void
    {
        $this->validator = self::getContainer()->get(ValidatorInterface::class);
    }

    public function getValidEntity(): Kana
    {
        return (new Kana())
            ->setRomaji('ka')
            ->setIdeogramme('か')
            ->setKunrei('ka')
            ->setAccent(false)
            ->setCombination(false)
            ->setType(KanaTypeEnum::HIRAGANA)
        ;
    }

    public function testValidEntity(): void
    {
        $violations = $this->getValidationErrors($this->getValidEntity(), $this->validator);

        $this->assertEquals(0, $violations['count']);
    }

    /**
     * testNotValidPropertyRomaji.
     */
    public function testNotValidPropertyRomaji(): void
    {
        $kana = $this->getValidEntity();
        $kana->setRomaji('');
        $violations = $this->getValidationErrors($kana, $this->validator);

        $this->assertEquals(1, $violations['count']);
        $this->assertContains('Ce champ ne peut pas être vide.', $violations['messages']);
    }

    /**
     * testNotValidPropertyKunrei.
     */
    public function testNotValidPropertyKunrei(): void
    {
        $kana = $this->getValidEntity();
        $kana->setKunrei('');
        $violations = $this->getValidationErrors($kana, $this->validator);

        $this->assertEquals(1, $violations['count']);
        $this->assertContains('Ce champ ne peut pas être vide.', $violations['messages']);
    }

    public function testNotValidPropertyIdeogramme(): void
    {
        $kana = $this->getValidEntity();

        // NotBlank
        $kana->setIdeogramme('');
        $violations = $this->getValidationErrors($kana, $this->validator);
        $this->assertEquals(1, $violations['count']);
        $this->assertContains('Ce champ ne peut pas être vide.', $violations['messages']);
    }
}
