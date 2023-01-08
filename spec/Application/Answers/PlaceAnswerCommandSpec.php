<?php

namespace spec\App\Application\Answers;

use App\Application\Answers\PlaceAnswerCommand;
use App\Application\Command;
use App\Domain\Questions\Question\QuestionId;
use App\Domain\UserManagement\User\UserId;
use PhpSpec\ObjectBehavior;

class PlaceAnswerCommandSpec extends ObjectBehavior
{

    private UserId $ownerUserId;
    private QuestionId $questionId;
    private string $body;
    private bool $accepted;
    function let()
    {
        $this->ownerUserId = new UserId();
        $this->questionId =new QuestionId();
        $this->body = 'Some text as body...';
        $this->accepted =false;

        $this->beConstructedWith(
            $this->ownerUserId,
            $this->questionId,
            $this->body,
            $this->accepted
        );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(PlaceAnswerCommand::class);
    }

    function its_a_command()
    {
        $this->shouldBeAnInstanceOf(Command::class);
    }

    function it_has_a_ownerUserId()
    {
        $this->ownerUserId()->shouldBe($this->ownerUserId);
    }

    function it_has_a_questionId()
    {
        $this->questionId()->shouldBe($this->questionId);
    }

    function it_has_a_body()
    {
        $this->body()->shouldBe($this->body);
    }

    function it_is_not_accepted()
    {
        $this->isAccepted()->shouldBe($this->accepted);
    }
}
