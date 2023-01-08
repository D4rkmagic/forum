<?php

namespace App\Domain\Answers;

use App\Domain\Answers\Answer\AnswerId;

/**
 * AnswerRepository
 *
 * @package App\Domain\Answers
 */
interface AnswerRepository
{
    /**
     * Adds a question to the repository
     *
     * @param Answer $question
     * @return Answer
     */
    public function add(Answer $question): Answer;

    /**
     * Retrieves a question saved with provided question identifier
     *
     * @param AnswerId $questionId
     * @return Answer
     * @throws RuntimeException|EntityNotFound
     */
    public function withAnswerId(AnswerId $questionId): Answer;

    /**
     * Removes provided questions from repository
     *
     * @param Answer $question
     * @return Answer
     */
    public function remove(Answer $question): Answer;

}
