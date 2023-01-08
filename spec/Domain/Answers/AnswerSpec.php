<?php

namespace spec\App\Domain\Answers;

use App\Domain\Answers\Answer;
use App\Domain\Answers\Answer\AnswerId;
use App\Domain\Comparable;
use App\Domain\Exception\InvalidAggregateIdentifier;
use App\Domain\Questions\Question;
use App\Domain\Questions\Question\QuestionId;
use App\Domain\UserManagement\User;
use App\Domain\UserManagement\User\UserId;
use Doctrine\Common\Collections\ArrayCollection;
use JsonSerializable;
use PhpSpec\ObjectBehavior;
use Ramsey\Collection\Collection;
use Ramsey\Uuid\Uuid;

class AnswerSpec extends ObjectBehavior
{
    public string $body;


    function let(User $owner, Question $question)
    {
        $owner->userId()->willReturn(new UserId());

        $question->questionId()->willReturn(new QuestionId());
        $question->isClosed()->willReturn(false);
        $question->answers()->willReturn(new ArrayCollection());

        $this->body = 'A long text as body...';

        $this->beConstructedWith(
            $owner,
            $question,
            $this->body
        );
    }

    function it_is_initialized(){
        $this->shouldBeAnInstanceOf(Answer::class);
    }

    function it_has_a_answerId()
    {
        $this->answerId()->shouldBeAnInstanceOf(AnswerId::class);
    }

    function it_has_a_userId()
    {
        $this->userId()->shouldBeAnInstanceOf(UserId::class);
    }

    function it_has_a_questionId()
    {
        $this->questionId()->shouldBeAnInstanceOf(QuestionId::class);
    }

    function it_has_a_body()
    {
        $this->body()->shouldBe($this->body);
    }

    function it_should_not_be_accepted(){
        $this->isAccepted()->shouldBeEqualTo(false);
    }

    function it_can_be_converted_to_json()
    {
        $this->shouldBeAnInstanceOf(JsonSerializable::class);
        $this->jsonSerialize()->shouldBe([
            'answerId' => $this->questionId(),
            'userId' =>  $this->userId(),
            'questionId' => $this->questionId(),
            'body' => $this->body(),
            'accepted' => $this->isAccepted()
        ]);
    }
}
