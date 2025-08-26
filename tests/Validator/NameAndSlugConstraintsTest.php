<?php

namespace App\Tests\Validator;

use App\Validator\Constraints\NameAndSlugConstraints;
use Symfony\Component\Validator\Constraints\Compound;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Test\CompoundConstraintTestCase;

/**
 * @extends CompoundConstraintTestCase<Compound>
 */
class NameAndSlugConstraintsTest extends CompoundConstraintTestCase
{
    protected function createCompound(): Compound
    {
        return new NameAndSlugConstraints();
    }

    /**
     * testNotValidValueBlank.
     */
    public function testNotValidValueBlank(): void
    {
        $this->validateValue('');

        $this->assertViolationsRaisedByCompound([
            new Assert\NotBlank(message: 'Ce champ ne peut pas être vide.'),
            new Assert\Length(
                min: 3,
                minMessage: 'Ce champ doit contenir un minimum de {{ limit }} caractères.',
            ),
        ]);
        $this->assertViolationsCount(2);
    }

    /**
     * testNotValidValueLength.
     */
    public function testNotValidValueLength(): void
    {
        $this->validateValue('as');

        $this->assertViolationsRaisedByCompound([
            new Assert\Length(
                min: 3,
                minMessage: 'Ce champ doit contenir un minimum de {{ limit }} caractères.',
            ),
        ]);
        $this->assertViolationsCount(1);
    }

    /**
     * testValidValue.
     */
    public function testValidValue(): void
    {
        $this->validateValue('valid-name-or-slug');

        $this->assertNoViolation();
    }
}
