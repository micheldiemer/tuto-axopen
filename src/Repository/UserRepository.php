<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
//use Doctrine\Bundle\DoctrineBundle\Registry;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[] findAll()
 * @method User[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{


  public function __construct(ManagerRegistry $registry)
  {
    parent::__construct($registry, User::class);
  }

  /**
   * @param \DateTime $datetime
   * @return User[]
   */
  public function findByBirthdayMoreThan(\DateTime $datetime)
  {
    return $this->createQueryBuilder('u')
      ->where('u.birthday > :datetime')
      ->setParameter('datetime', $datetime)
      ->getQuery()
      ->getResult();
  }

  public function newUser(User $user)
  {
    $this->getEntityManager()->persist($user);
    $this->getEntityManager()->flush();
    return $user;
  }

  public function newUserA($first_name, $last_name, $birthday, $description)
  {

    $user = new User();

    $user->setBirthday($birthday);
    $user->setLastName($last_name);
    $user->setFirstName($first_name);
    $user->setDescription($description);

    return $this->newUser($user);
  }

  public function deleteUser($id)
  {
    $user = $this->getEntityManager()->find("App\Entity\User", $id);;
    $this->getEntityManager()->remove($user);
    $this->getEntityManager()->flush();
  }
}
