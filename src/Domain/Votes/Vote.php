<?php

namespace App\Domain\Votes;

use App\Domain\Questions\Question\QuestionId;
use App\Domain\UserManagement\User\UserId;
use App\Infrastructure\JsonApi\SchemaDiscovery\Attributes\AsResourceObject;
use App\Infrastructure\JsonApi\SchemaDiscovery\Attributes\Relationship;
use Doctrine\ORM\Mapping\Column;
use JsonSerializable;

#[
    Entity,
    Table("votes")
]
#[AsResourceObject(type: "votes", links: [AsResourceObject::LINK_SELF])]
class Vote implements JsonSerializable
{
    #[Column(name: "user_id", type: "UserId")]
    #[Relationship(
            type: Relationship::TO_ONE,
            links: [AsResourceObject::LINK_RELATED],
            meta: ['description' => "A vote is given by a user to the question."]
    )]
    private UserId $userId;

    #[Column(name: "question_id", type: "QuestionId")]
    #[Relationship(
        type: Relationship::TO_ONE,
        links: [AsResourceObject::LINK_RELATED],
        meta: ['description' => "The question the vote belongs to."]
    )]
    private  QuestionId $questionId;

    public function __construct(UserId $userId, QuestionId $questionId){
        $this->userId=$userId;
        $this->questionId = $questionId;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize(): mixed
    {
        return [
            'answerId' => $this->questionId,
            'userId' =>  $this->userId,
        ];
    }
}
