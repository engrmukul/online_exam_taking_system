<?php

namespace App\Contracts;

/**
 * Interface UserContract
 * @package App\Contracts
 */
interface UserContract
{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listUser(string $order = 'id', string $sort = 'desc', array $columns = ['*']);

    /**
     * @param int $id
     * @return mixed
     */
    public function findUserById(int $id);

    /**
     * @param array $params
     * @return mixed
     */
    public function createUser(array $params);

    /**
     * @param array $params
     * @return mixed
     */
    public function updateUser(array $params);

    /**
     * @param $id
     * @return bool
     */
    public function deleteUser($id, array $params);

}
