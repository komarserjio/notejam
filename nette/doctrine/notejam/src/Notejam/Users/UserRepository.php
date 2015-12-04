<?php

namespace Notejam\Users;

use Kdyby\Doctrine\EntityRepository;



/**
 * @method User|NULL find($id, $lockMode = NULL, $lockVersion = NULL)
 * @method User|NULL findOneBy(array $criteria, array $orderBy = NULL)
 */
class UserRepository extends EntityRepository
{

}
