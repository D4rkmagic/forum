<?php

namespace spec\App\Domain\Answers\Events;

use App\Domain\AbstractEvent;
use App\Domain\Answers\Answer\AnswerId;
use App\Domain\Answers\Events\AnswerWasDownvoted;
use App\Domain\Answers\Events\AnswerWasRemoved;
use App\Domain\DomainEvent;
use App\Domain\Questions\Question\QuestionId;
use App\Domain\UserManagement\User\UserId;
use DateTimeImmutable;
use JsonSerializable;
use PhpSpec\ObjectBehavior;

class AnswerWasRemovedSpec extends ObjectBehavior
{

    private $answerId;
    private $userId;
    private $questionId;
    private $body;

    function let()
    {
        $this->answerId = new AnswerId();
        $this->userId = new UserId();
        $this->questionId = new questionId();
        $this->body = 'A long text as body...';

        $this->beConstructedWith(
            $this->answerId,
            $this->userId,
            $this->questionId,
            $this->body
        );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(AnswerWasRemoved::class);
    }

    function it_has_a_answerId()
    {
        $this->answerId()->shouldBe($this->answerId);
    }

    function it_has_a_userId()
    {
        $this->userId()->shouldBe($this->userId);
    }

    function it_has_a_questionId()
    {
        $this->questionId()->shouldBe($this->questionId);
    }

    function it_has_a_body()
    {
        $this->body()->shouldBe($this->body);
    }

    function its_an_event()
    {
        $this->shouldBeAnInstanceOf(DomainEvent::class);
        $this->shouldHaveType(AbstractEvent::class);
        $this->occurredOn()->shouldBeAnInstanceOf(DateTimeImmutable::class);
    }

    function it_can_be_converted_to_json()
    {
        $this->shouldBeAnInstanceOf(JsonSerializable::class);
        $this->jsonSerialize()->shouldBe([
            'answerId' => $this->questionId,
            'userId' =>  $this->userId,
            'questionId' => $this->questionId,
            'body' => $this->body
        ]);
    }


}
