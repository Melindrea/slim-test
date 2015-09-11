<?php

namespace Lees\Domain\Repositories\Identity;

interface UserRepository extends \Lees\Domain\Repositories\DomainRepository
{
    public function add($user);
    public function findByUsername($username);
}
