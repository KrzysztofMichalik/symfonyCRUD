<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


/**
 * @extends ServiceEntityRepository<Product>
 *
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]     findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function findAllWithCategory() : array
    {
        return $this->createQueryBuilder('prod')
            ->leftJoin('prod.category', 'cat')
            ->getQuery()
            ->execute();
    }
    public function findOneWithCategory(int $id) : ?Product
    {
        return $this->createQueryBuilder('prod')
            ->andWhere('prod.id =' . $id)
            ->leftJoin('prod.category', 'cat')
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function update(Product $entity, bool $flush = false) : void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function add(Product $entity, bool $flush = false) : void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Product $entity, bool $flush = false) : void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
