<?php

namespace App\Tests\Entity;

use App\Entity\Kanji;
use App\Enum\JlptLevelEnum;
use App\Tests\Traits\ValidatorTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class KanjiTest extends WebTestCase
{
    use ReloadDatabaseTrait;
    use ValidatorTrait;

    private ValidatorInterface $validator;

    protected function setUp(): void
    {
        $this->validator = self::getContainer()->get(ValidatorInterface::class);
    }

    public function getValidEntity(): Kanji
    {
        return (new Kanji())
            ->setIdeogramme('か')
            ->setNumberStroke(5)
            ->setSignification('a signification')
            ->setKunyomi('kunyomi')
            ->setOnyomi('onyomi')
            ->setLevel(JlptLevelEnum::JLPT1)
        ;
    }

    public function testValidEntity(): void
    {
        $violations = $this->getValidationErrors($this->getValidEntity(), $this->validator);

        $this->assertEquals(0, $violations['count']);
    }

    /**
     * testNotValidPropertyIdeogramme.
     */
    public function testNotValidPropertyIdeogramme(): void
    {
        $kanji = $this->getValidEntity();
        $kanji->setIdeogramme('');
        $violations = $this->getValidationErrors($kanji, $this->validator);

        $this->assertEquals(1, $violations['count']);
        $this->assertContains('Ce champ ne peut pas être vide.', $violations['messages']);
    }

    /**
     * testNotValidPropertySignification.
     */
    public function testNotValidPropertySignification(): void
    {
        $kanji = $this->getValidEntity();
        $kanji->setSignification('');
        $violations = $this->getValidationErrors($kanji, $this->validator);

        $this->assertEquals(1, $violations['count']);
        $this->assertContains('Ce champ ne peut pas être vide.', $violations['messages']);
    }

    public function testNotValidPropertyNumberStroke(): void
    {
        $kanji = $this->getValidEntity();

        $kanji->setNumberStroke(-10);
        $violations = $this->getValidationErrors($kanji, $this->validator);
        $this->assertEquals(1, $violations['count']);
        $this->assertContains('Ce champ doit avoir une valeur strictement positive.', $violations['messages']);

        $kanji->setNumberStroke(0);
        $violations = $this->getValidationErrors($kanji, $this->validator);
        $this->assertEquals(1, $violations['count']);
        $this->assertContains('Ce champ doit avoir une valeur strictement positive.', $violations['messages']);
    }
}
