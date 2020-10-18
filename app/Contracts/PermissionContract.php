<?php

namespace App\Contracts;

/**
 * Interface PermissionContract
 * @package App\Contracts
 */
interface PermissionContract
{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listPermission(string $order = 'id', string $sort = 'desc', array $columns = ['*']);

    /**
     * @param int $id
     * @return mixed
     */
    public function findPermissionById(int $id);

    /**
     * @param array $params
     * @return mixed
     */
    public function createPermission(array $params);

    /**
     * @param array $params
     * @return mixed
     */
    public function updatePermission(array $params);

    /**
     * @param $id
     * @return bool
     */
    public function deletePermission($id, array $params);

}
