<?php

namespace App\Application\Answers;

use App\Application\Command;
use App\Application\CommandHandlerMethods;
use App\Domain\Answers\Answer\AnswerId;
use App\Domain\Questions\Question\QuestionId;
use App\Domain\UserManagement\User\UserId;
use App\Infrastructure\JsonApi\SchemaDiscovery\Attributes\AsResourceObject;
use App\Infrastructure\JsonApi\SchemaDiscovery\Attributes\Attribute;
use App\Infrastructure\JsonApi\SchemaDiscovery\Attributes\RelationshipIdentifier;

/**
 * PlaceAnswerCommand
 *
 * @package App\Application\Answers
 */
#[AsResourceObject(schemaClass: "answers")]
class PlaceAnswerCommand implements Command
{

    /**
     * @param UserId $ownerUserId
     * @param QuestionId $questionId
     * @param string $body
     * @param bool $accepted
     */
    public function __construct(
        #[RelationshipIdentifier(name: "owner_id", className: UserId::class, type: 'users')]
        private readonly UserId $ownerUserId,

        #[RelationshipIdentifier(name: "question_id", className: QuestionId::class, type: 'questions')]
        private readonly QuestionId $questionId,

        #[Attribute(required: true)]
        private readonly string $body,

        #[Attribute(required: false)]
        private readonly bool $accepted
    ){
    }

    /**
     * ownerUserId
     *
     * @return UserId
     */
    public function ownerUserId(): UserId
    {
        return $this->ownerUserId;
    }

    /**
     * questionId
     *
     * @return QuestionId
     */
    public function questionId(): QuestionId
    {
        return $this->questionId;
    }

    /**
     * body
     *
     * @return string
     */
    public function body() : string{
        return $this->body;
    }

    /**
     * accepted
     *
     * @return bool
     */
    public function isAccepted() : bool{
        return $this->accepted;
    }
}
