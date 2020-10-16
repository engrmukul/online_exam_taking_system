<?php

namespace App\Contracts;

/**
 * Interface QuestionPaperContract
 * @package App\Contracts
 */
interface QuestionPaperContract
{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listQuestionPaper(string $order = 'id', string $sort = 'desc', array $columns = ['*']);

    /**
     * @param int $id
     * @return mixed
     */
    public function findQuestionPaperById(int $id);

    /**
     * @param array $params
     * @return mixed
     */
    public function createQuestionPaper(array $params);

    /**
     * @param array $params
     * @return mixed
     */
    public function updateQuestionPaper(array $params);

    /**
     * @param $id
     * @return bool
     */
    public function deleteQuestionPaper($id, array $params);

}
