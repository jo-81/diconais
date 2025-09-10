<?php

namespace App\DataFixtures\Faker\Provider;

use Faker\Provider\Base;
use App\Enum\JlptLevelEnum;

class JlptLevelProvider extends Base
{
    /**
     * Retourne un niveau JLPT aléatoire ou null.
     *
     * @param int $nullProbability Probabilité de retourner null (0-100, défaut: 20)
     */
    public function randomJlptLevel(int $nullProbability = 20): ?JlptLevelEnum
    {
        // Si le nombre aléatoire est inférieur à la probabilité, retourner null
        if (mt_rand(1, 100) <= $nullProbability) {
            return null;
        }

        // Sinon, retourner un niveau JLPT aléatoire
        $levels = JlptLevelEnum::cases();

        return $levels[array_rand($levels)];
    }
}
