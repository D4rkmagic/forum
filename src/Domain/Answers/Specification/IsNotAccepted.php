<?php

namespace App\Domain\Answers\Specification;

use App\Domain\Answers\Answer;
use App\Domain\Answers\Answer\AnswerId;
use App\Domain\Answers\AnswerSpecification;

/**
 * @package App\Domain\Answers\Specification
 */
class IsNotAccepted implements AnswerSpecification
{
    public function isSatisfiedBy(Answer $answer): bool
    {
        return !$answer->isAccepted();
    }

}
