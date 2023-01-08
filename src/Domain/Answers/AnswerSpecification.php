<?php

namespace App\Domain\Answers;


/**
 * AnswerSpecification
 *
 * @package App\Domain\Answers
 */
interface AnswerSpecification
{

    public function isSatisfiedBy(Answer $answer): bool;
}
