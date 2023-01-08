<?php

namespace spec\App\Application\Answers\Model;

use App\Application\Answers\Model\Answer;
use App\Domain\Answers\Answer\AnswerId;
use App\Domain\Questions\Question\QuestionId;
use App\Domain\UserManagement\User\UserId;
use PhpSpec\ObjectBehavior;
use Ramsey\Uuid\Nonstandard\Uuid;

class AnswerSpec extends ObjectBehavior
{

    public string $body;

    function let(){
        $strAnswerId = Uuid::uuid4()->toString();

        $strUserId = Uuid::uuid4()->toString();

        $strQuestionId = Uuid::uuid4()->toString();

        $this->body = 'Some amazing answer';

        $this->beConstructedWith([
            'answerId' => $strAnswerId,
            'userId' => $strUserId,
            'questionId' => $strQuestionId,
            'body' => $this->body,
            'accepted' => false
        ]);
    }
    function it_is_initializable()
    {
        $this->shouldHaveType(Answer::class);
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
}
