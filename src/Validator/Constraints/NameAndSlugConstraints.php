<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraints\Compound;
use Symfony\Component\Validator\Constraints as Assert;

#[\Attribute]
class NameAndSlugConstraints extends Compound
{
    protected function getConstraints(array $options): array
    {
        return [
            new Assert\NotBlank(message: 'Ce champ ne peut pas être vide.'),
            new Assert\Length(
                min: 3,
                minMessage: 'Ce champ doit contenir un minimum de {{ limit }} caractères.',
            ),
        ];
    }
}
