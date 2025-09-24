<?php

namespace App\Tests\Entity;

use App\Entity\Theme;
use App\Entity\Vocabulary;
use App\Tests\Traits\ValidatorTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class VocabularyTest extends WebTestCase
{
    use ReloadDatabaseTrait;
    use ValidatorTrait;

    private ValidatorInterface $validator;

    protected function setUp(): void
    {
        $this->validator = self::getContainer()->get(ValidatorInterface::class);
    }

    public function getValidEntity(): Vocabulary
    {
        $vocabulary = (new Vocabulary())
            ->setSignification('vocabulary')
            ->setReading('ひ困と')
            ->setRomaji('ひとぼう')
            ->setTheme(new Theme())
        ;

        return $vocabulary;
    }

    public function testValidEntity(): void
    {
        $violations = $this->getValidationErrors($this->getValidEntity(), $this->validator);

        $this->assertEquals(0, $violations['count']);
    }

    public function testValuePropertySignification(): void
    {
        $course = $this->getValidEntity();
        $course->setSignification('');
        $violations = $this->getValidationErrors($course, $this->validator);

        $this->assertEquals(1, $violations['count']);
        $this->assertContains('Cette valeur ne peux pas être vide.', $violations['messages']);
    }

    public function testValuePropertyRomaji(): void
    {
        $course = $this->getValidEntity();
        $course->setRomaji('');
        $violations = $this->getValidationErrors($course, $this->validator);

        $this->assertEquals(1, $violations['count']);
        $this->assertContains('Cette valeur ne peux pas être vide.', $violations['messages']);
    }
}
