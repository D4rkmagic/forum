<?php

namespace App\Application\Answers\Model;

use App\Domain\Answers\Answer\AnswerId;
use App\Domain\Questions\Question\QuestionId;
use App\Domain\UserManagement\User\UserId;
use App\Infrastructure\JsonApi\SchemaDiscovery\Attributes\AsResourceObject;
use App\Infrastructure\JsonApi\SchemaDiscovery\Attributes\Attribute;

#[AsResourceObject(type: "clients")]
final class Answer
{

    #[ResourceIdentifier]
    private readonly AnswerId $answerId;

    #[Attribute]
    public readonly UserId $userId;

    #[Attribute]
    public readonly QuestionId $questionId;

    #[Attribute]
    public readonly string $body;
    #[Attribute]
    public readonly bool $accepted;

    public function __construct(array $data)
    {
        $this->answerId = new AnswerId($data['answerId']);
        $this->questionId = new QuestionId($data['questionId']);
        $this->userId = new UserId($data['userId']);
        $this->body = $data['body'];
        $this->accepted = $data['accepted'];
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
     * @return string
     */
    public function body():string
    {
        return $this->body;
    }

    /**
     * @return bool
     */
    public function isAccepted(): bool {
        return $this->accepted;
    }
}
