<?php

namespace spec\App\Application\Answers;

use App\Application\Answers\ChangeAnswerHandler;
use App\Application\CommandHandler;
use App\Domain\Answers\Answer;
use App\Domain\Answers\Answer\AnswerId;
use App\Domain\Answers\AnswerRepository;
use App\Domain\Answers\Specification\IsNotAccepted;
use App\Domain\Answers\Specification\OwnedByRequester;
use App\Domain\Answers\Specification\QuestionIsNotArchived;
use App\Domain\Questions\Events\QuestionWasChanged;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;

class ChangeAnswerHandlerSpec extends ObjectBehavior
{
    private $answerId;
    private $body;
    private $accepted;

    function let(
        AnswerRepository $answers,
        IsNotAccepted $isNotAccepted,
        Answer $answer,
        OwnedByRequester $ownedByRequester,
        QuestionIsNotArchived $questionIsNotArchived,
        QuestionWasChanged $questionWasChanged,
        EventDispatcher $dispatcher
    ){
        $this->answerId = new AnswerId();
        $this->body = 'some body';
        $this->accepted = false;

        $answers->withAnswerId($this->answerId)->willReturn($answer);

        $answer->answerId()->willReturn($this->answerId);
        $answer->changeAnswer([
            'body' => $this->body,
            'accepted' => $this->accepted
        ])->willReturn($answer);

        $answer->releaseEvents()->willReturn([$questionWasChanged]);

        $dispatcher->dispatch(Argument::any())->willReturnArgument();

        $isNotAccepted->isSatisfiedBy($answer)->willReturn(true);
        $questionIsNotArchived->isSatisfiedBy($answer)->willReturn(true);
        $ownedByRequester->isSatisfiedBy($answer)->willReturn(true);

        $this->beConstructedWith(
            $answers,
            $isNotAccepted,
            $ownedByRequester,
            $questionIsNotArchived,
            $dispatcher
        );
    }
    function it_is_initializable()
    {
        $this->shouldHaveType(ChangeAnswerHandler::class);
    }

    function its_a_command_handler()
    {
        $this->shouldBeAnInstanceOf(CommandHandler::class);
    }
}
