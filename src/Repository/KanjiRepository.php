<?php

namespace App\Repository;

use App\Entity\Kanji;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Kanji>
 */
class KanjiRepository extends ServiceEntityRepository
{
    private const ALLOWED_OPERATORS = ['=', '>', '<', '>=', '<='];

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Kanji::class);
    }

    /**
     * Recherche des kanji selon plusieurs critères.
     *
     * @param string $signification Filtre sur la signification (LIKE)
     * @param string $ideogramme    Filtre exact sur l'idéogramme
     * @param string $jlpt          Niveau JLPT
     * @param array  $strokes       Configuration du filtre de traits
     *
     * @return Kanji[]
     */
    public function findKanjiBy(
        string $signification = '',
        string $ideogramme = '',
        string $jlpt = '',
        array $strokes = [],
    ) {
        $qb = $this->createQueryBuilder('k')
            ->orderBy('k.id', 'DESC')
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

        if (!empty($jlpt)) {
            $qb
                ->andWhere('k.level = :level')
                ->setParameter('level', $jlpt)
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
