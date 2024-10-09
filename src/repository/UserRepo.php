<?php

namespace App\Repository;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

require_once(dirname(dirname(__DIR__)) . "/bootstrap.php");
class UserRepository extends EntityRepository
{
    protected $em;
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }
}
