<?php

namespace App\Domain\Answers;

use App\Domain\Answers\Answer\AnswerId;
use App\Domain\Answers\Answer\Vote;
use App\Domain\Answers\Events\AnswerWasChanged;
use App\Domain\Answers\Events\AnswerWasGiven;
use App\Domain\DomainEvent;
use App\Domain\Exception\InvalidAggregateIdentifier;
use App\Domain\Questions\Question;
use App\Domain\Questions\Question\QuestionId;
use App\Domain\Questions\QuestionRepository;
use App\Domain\RootAggregate;
use App\Domain\RootAggregateMethods;
use App\Domain\UserManagement\User;
use App\Domain\UserManagement\User\UserId;
use App\Infrastructure\JsonApi\SchemaDiscovery\Attributes\AsResourceObject;
use App\Infrastructure\JsonApi\SchemaDiscovery\Attributes\Relationship;
use App\Infrastructure\JsonApi\SchemaDiscovery\Attributes\ResourceIdentifier;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;
use JsonSerializable;

#[
    Entity,
    Table("answers")
]
#[AsResourceObject(type: "answers", links: [AsResourceObject::LINK_SELF])]
class Answer implements JsonSerializable,RootAggregate
{
    use RootAggregateMethods;

    #[Id]
    #[GeneratedValue(strategy: "NONE")]
    #[Column(name: "id", type: "AnswerId")]
    #[ResourceIdentifier]
    public AnswerId $answerId;

    #[Column(name: "owner_id", type: "UserId")]
    #[Relationship(
        type: Relationship::TO_ONE,
        links: [AsResourceObject::LINK_RELATED],
        meta: ['description' => "The user who the answer belongs to."]
    )]
    public UserId $userId;

    #[Column(name: "question_id", type: "QuestionId")]
    #[Relationship(
        type: Relationship::TO_ONE,
        links: [AsResourceObject::LINK_RELATED],
        meta: ['description' => "The question the answer belongs to."]
    )]
    public QuestionId $questionId;

    #[Column(name: "body", type: "string")]
    public String $body;

    #[Column(name: "accepted", type: "bool")]
    public bool $accepted;

    public function __construct(
        #[ManyToOne(targetEntity: User::class, fetch: "EAGER")]
        #[JoinColumn(name: "owner_id", onDelete: "CASCADE")]
        #[Relationship(
            type: Relationship::TO_ONE,
            links: [AsResourceObject::LINK_RELATED],
            meta: ['description' => "A answer is owned by a user with is it owner."])
        ]
        private User $owner,

        #[ManyToOne(targetEntity: Question::class, fetch: "EAGER")]
        #[JoinColumn(name: "question_id", onDelete: "CASCADE")]
        #[Relationship(
            type: Relationship::TO_ONE,
            links: [AsResourceObject::LINK_RELATED],
            meta: ['description' => "A answer relates to a question."])
        ]
        private Question $question,
        String $body,
        ?bool $accepted = false
    ){
        if($this->question->isClosed()){
            throw new InvalidAggregateIdentifier(
                "The provided question is in a closed state."
            );
        }

        $this->answerId = new AnswerId();
        $this->userId= $owner->userId();
        $this->questionId = $question->questionId();
        $this->body = $body;
        $this->accepted = $accepted;

        $this->question->answers()->add($this);

        $this->recordThat(new AnswerWasGiven(
                $this->answerId,
                $this->userId,
                $this->questionId,
                $this->body,
                $accepted
            )
        );
    }

    /**
     * @param $data
     * @return void
     */
    public function changeAnswer($data) : Answer {
        if($this->accepted) {
            throw new InvalidAggregateIdentifier(
                "The provided answer is in a accepted state."
            );
        }

        $this->answerId = $data['answerId']?: $this->answerId;
        $this->userId= $data['userId'] ?: $this->userId;
        $this->questionId = $data['questionId'] ?: $this->questionId;
        $this->body = $data['body'] ?: $this->body;
        $this->accepted = $data['accepted'] ?: $this->accepted;

        $this->recordThat(new AnswerWasChanged(
            $this->answerId,
            $this->userId,
            $this->questionId,
            $this->body
        ));

        return $this;
    }

    /**
     *
     * @return AnswerId
     */
    public function answerId() : AnswerId{
        return $this->answerId;
    }

    /**
     * @return UserId
     */
    public function userId() : UserId {
        return $this->userId;
    }

    /**
     * @return QuestionId
     */
    public function questionId(): QuestionId {
        return $this->questionId;
    }

    /**
     * @return Question
     */
    public function question(): Question {
        return $this->question;
    }

    /**
     * @return User
     */
    public function owner(): User
    {
        return $this->owner;
    }

    /**
     * @return string
     */
    public function body(): string {
        return $this->body;
    }

    /**
     * @return bool
     */
    public function isAccepted(): bool {
        return $this->accepted;
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
            'body' => $this->body,
            'accepted' => $this->accepted
        ];
    }
}
