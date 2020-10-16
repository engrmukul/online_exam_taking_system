<?php

namespace App\Contracts;

/**
 * Interface QuestionContract
 * @package App\Contracts
 */
interface QuestionContract
{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listQuestion(string $order = 'id', string $sort = 'desc', array $columns = ['*']);

    /**
     * @param int $id
     * @return mixed
     */
    public function findQuestionById(int $id);

    /**
     * @param array $params
     * @return mixed
     */
    public function createQuestion(array $params);

    /**
     * @param array $params
     * @return mixed
     */
    public function updateQuestion(array $params);

    /**
     * @param $id
     * @return bool
     */
    public function deleteQuestion($id, array $params);

}
