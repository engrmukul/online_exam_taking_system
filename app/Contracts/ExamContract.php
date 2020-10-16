<?php

namespace App\Contracts;

/**
 * Interface ExamContract
 * @package App\Contracts
 */
interface ExamContract
{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listExam(string $order = 'id', string $sort = 'desc', array $columns = ['*']);

    /**
     * @param int $id
     * @return mixed
     */
    public function findExamById(int $id);

    /**
     * @param array $params
     * @return mixed
     */
    public function createExam(array $params);

    /**
     * @param array $params
     * @return mixed
     */
    public function updateExam(array $params);

    /**
     * @param $id
     * @return bool
     */
    public function deleteExam($id, array $params);

}
