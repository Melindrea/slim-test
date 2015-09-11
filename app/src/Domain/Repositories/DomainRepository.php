<?php

namespace Lees\Domain\Repositories;

interface DomainRepository
{
    public function fields(array $fields);
    public function findById($id);
    public function findBy(array $traits);
    public function findAllBy(array $traits, $limit = null);
    public function findAll($limit = null);
    public function update($id, array $data);
    public function remove($id);
}
