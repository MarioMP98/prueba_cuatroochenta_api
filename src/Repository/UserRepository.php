<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @extends ServiceEntityRepository<User>
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    private $hasher;

    public function __construct(ManagerRegistry $registry, UserPasswordHasherInterface $hasher)
    {
        parent::__construct($registry, User::class);

        $this->hasher = $hasher;
    }


    public function create($params): User
    {
        $user = new User();
        $user->setEmail($params['email']);
        $user->setName($params['name']);
        $user->setLastName($params['last_name']);

        $plaintextPassword = $params['password'];
        $hashedPassword = $this->hasher->hashPassword($user, $plaintextPassword);
        $user->setPassword($hashedPassword);

        $entityManager = $this->getEntityManager();
        $entityManager->persist($user);
        $entityManager->flush();

        return $user;
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $user::class));
        }

        $user->setPassword($newHashedPassword);
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }

}
