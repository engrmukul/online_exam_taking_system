<?php

namespace App\Contracts;

/**
 * Interface QuestionAssignContract
 * @package App\Contracts
 */
interface QuestionAssignContract
{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listQuestionAssign(string $order = 'id', string $sort = 'desc', array $columns = ['*']);

    /**
     * @param int $id
     * @return mixed
     */
    public function findQuestionAssignById(int $id);

    /**
     * @param array $params
     * @return mixed
     */
    public function createQuestionAssign(array $params);

    /**
     * @param array $params
     * @return mixed
     */
    public function updateQuestionAssign(array $params);

    /**
     * @param $id
     * @return bool
     */
    public function deleteQuestionAssign($id, array $params);

}
