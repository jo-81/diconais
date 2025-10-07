<?php

namespace App\Repository;

use App\Entity\Key;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Key>
 */
class KeyRepository extends ServiceEntityRepository
{
    private const ALLOWED_OPERATORS = ['=', '>', '<', '>=', '<='];

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Key::class);
    }

    /**
     * Recherche des key selon plusieurs critères.
     *
     * @param string                                      $signification Filtre sur la signification (LIKE)
     * @param string                                      $ideogramme    Filtre exact sur l'idéogramme
     * @param string                                      $numberKey     Numéro de la clé associé
     * @param array{numberStroke: int|null, egal: string} $strokes       Configuration du filtre de traits
     *
     * @return Key[]
     */
    public function findKeyBy(
        string $signification = '',
        string $ideogramme = '',
        ?int $numberKey = null,
        array $strokes = [],
    ) {
        $qb = $this->createQueryBuilder('k')
            ->orderBy('k.number', 'ASC')
        ;

        if (!empty($signification)) {
            $qb
                ->andWhere('k.signification LIKE :signification')
                ->setParameter('signification', '%'.$signification.'%')
            ;
        }

        if (!empty($ideogramme)) {
            $qb
                ->andWhere('k.ideogramme = :ideogramme')
                ->setParameter('ideogramme', $ideogramme)
            ;
        }

        if (!empty($numberKey)) {
            $qb
                ->andWhere('k.number = :number')
                ->setParameter('number', $numberKey)
            ;
        }

        if (isset($strokes['numberStroke']) && !is_null($strokes['numberStroke'])) {
            $operator = in_array($strokes['egal'] ?? '=', self::ALLOWED_OPERATORS)
                ? $strokes['egal']
                : '=';

            $qb->andWhere("k.numberStroke {$operator} :numberStroke")
                ->setParameter('numberStroke', $strokes['numberStroke']);
        }

        return $qb->getQuery()->getResult();
    }
}
