<?php

namespace App\Domain\Answers\Specification;

use App\Domain\Answers\Answer;
use App\Domain\Answers\AnswerSpecification;
use App\Domain\Questions\Question;

/**
 * @package App\Domain\Answers\Specification
 */
class QuestionIsNotArchived implements AnswerSpecification
{

    public function __construct(
        private readonly Question $question
    ) {
    }
    public function isSatisfiedBy(Answer $answer): bool
    {
        return !$this->question->isArchived();
    }
}
