<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    /**
     * @param $price
     * @return Product[]
     */
    public function findAllGreaterThanPrice($price): array
    {
        // Va automatiquement faire un select sur la table product "p" est un alias 

        $queryBuilder = $this->createQueryBuilder('p')
            ->where('p.price > :price')
            ->setParameter('price', $price)
            ->orderBy('p.price', 'ASC')
            ->getQuery();

        return $queryBuilder->getResult();
    }

    /**
     * @param $price
     * @return Product
     */
    public function findOneGreaterThanPrice($price): ?Product
    {
        // On peut aussi retourner un seul produit par exemple
        $queryBuilder = $this->createQueryBuilder('p')
            ->where('p.price > :price')
            ->setParameter('price', $price)
            ->orderBy('p.price', 'ASC')
            ->getQuery();

        return $queryBuilder->setMaxResults(1)->getOneOrNullResult();
    }

    /**
     * @param $price
     * @return Product
     */
    public function testPrix(): array
    {
        $queryBuilder = $this->createQueryBuilder('p')
            ->orderBy('p.price', 'DESC')
            ->setMaxResults(4)
            ->getQuery();

        return $queryBuilder->getResult();
    }
}
