<?php

namespace App\Repository;

use App\Entity\Task;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Task|null find($id, $lockMode = null, $lockVersion = null)
 * @method Task|null findOneBy(array $criteria, array $orderBy = null)
 * @method Task[]    findAll()
 * @method Task[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TaskRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Task::class);
    }

    // /**
    //  * @return Task[] Returns an array of Task objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Task
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /**
     * 
     * Affiche toutes les tâches d'une liste selon son id 
     * 
     */

    public function findAllTasksByIdList($id)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.id_liste = :val')
            ->setParameter('val', $id)
            ->getQuery()
            ->getResult();
    }

    /**
     * 
     * Affiche les tâches d'un utilisateur en particulier
     *  
     */

    public function findOwnTasks($user)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT t.id, t.description, t.id_liste 
            FROM task t
            LEFT JOIN liste l ON t.id_liste = l.id
            WHERE l.owner = :user;
            ';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['user' => $user]);

        return $stmt->fetchAllAssociative();
    }
}
