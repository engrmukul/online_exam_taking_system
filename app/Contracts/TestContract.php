<?php

namespace App\Contracts;

/**
 * Interface TestContract
 * @package App\Contracts
 */
interface TestContract
{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listTest(string $order = 'id', string $sort = 'desc', array $columns = ['*']);

    /**
     * @param int $id
     * @return mixed
     */
    public function findTestById(int $id);

    /**
     * @param array $params
     * @return mixed
     */
    public function createTest(array $params);

    /**
     * @param array $params
     * @return mixed
     */
    public function updateTest(array $params);

    /**
     * @param $id
     * @return bool
     */
    public function deleteTest($id, array $params);

}
