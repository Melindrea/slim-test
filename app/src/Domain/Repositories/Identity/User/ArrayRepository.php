<?php

namespace Lees\Domain\Repositories\Identity\User;

use Lees\Domain\Identity\User;

class ArrayRepository implements \Lees\Domain\Repositories\Identity\UserRepository
{
    protected $users;
    protected $fields = [];

    protected function mapToUser(array $users, $limit = null)
    {
        if ($limit) {
            $users = array_slice($users, 0, $limit);
        }

        return array_map(
            function ($user) {
                    return new User($user);
            },
            $users
        );
    }

    public function __construct($users = [])
    {
        $this->users = $users;
    }

    public function findByUsername($username)
    {
        foreach ($this->users as $user) {
            // if ($user['username'])
        }

        return null;
    }

    public function fields(array $fields)
    {
        $this->fields = $fields;
    }

    public function findById($id)
    {
        if (isset($this->users[$id])) {
            return new User($this->users[$id]);
        }

        return null;
    }
    public function findBy(array $traits)
    {

        if (isset($this->users[0])) {
            return new User($this->users[0]);
        }

        return null;

    }

    public function findAllBy(array $traits, $limit = null)
    {
        $users = $this->users;

        return new \ArrayIterator($this->mapToUser($users, $limit));
    }

    public function findAll($limit = null)
    {
        $users = $this->users;
        return new \ArrayIterator($this->mapToUser($users, $limit));
    }

    public function update($id, array $data)
    {
        return $this;
    }

    public function remove($id)
    {
        return $this;
    }

    public function add($user)
    {
        $this->users[] = $user;
        return $this;
    }
}
