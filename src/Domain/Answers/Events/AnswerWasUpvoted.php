<?php

namespace App\Domain\Answers\Events;

use App\Domain\AbstractEvent;
use App\Domain\Answers\Answer\AnswerId;
use App\Domain\Questions\Question\QuestionId;
use App\Domain\UserManagement\User\UserId;
use JsonSerializable;

class AnswerWasUpvoted extends AbstractEvent implements JsonSerializable
{

    /**
     * Creates a AnswerWasGiven
     *
     * @param AnswerId $answerId
     * @param UserId $userId
     * @param QuestionId $questionId
     * @param string $body
     */
    public function __construct(
        private readonly AnswerId   $answerId,
        private readonly UserId     $userId,
        private readonly QuestionId $questionId,
        private readonly string     $body
    )
    {
        parent::__construct();
    }

    /**
     * answerId
     *
     * @return AnswerId
     */
    public function answerId() : AnswerId {
        return $this->answerId;
    }

    /**
     * userId
     *
     * @return UserId
     */
    public function userId() : UserId{
        return $this->userId;
    }

    /**
     * questionId
     *
     * @return QuestionId
     */
    public function questionId(): QuestionId{
        return $this->questionId;
    }

    /**
     * body
     *
     * @return String
     */
    public function body() : String {
        return $this->body;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize(): array
    {
        return [
            'answerId' => $this->questionId,
            'userId' =>  $this->userId,
            'questionId' => $this->questionId,
            'body' => $this->body
        ];
    }
}
