<?php

namespace App\Contracts;

/**
 * Interface SubjectContract
 * @package App\Contracts
 */
interface SubjectContract
{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listSubject(string $order = 'id', string $sort = 'desc', array $columns = ['*']);

    /**
     * @param int $id
     * @return mixed
     */
    public function findSubjectById(int $id);

    /**
     * @param array $params
     * @return mixed
     */
    public function createSubject(array $params);

    /**
     * @param array $params
     * @return mixed
     */
    public function updateSubject(array $params);

    /**
     * @param $id
     * @return bool
     */
    public function deleteSubject($id, array $params);

}
