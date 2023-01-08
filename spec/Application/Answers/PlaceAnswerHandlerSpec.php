<?php

namespace spec\App\Application\Answers;

use App\Application\Answers\Model\Answer;
use App\Application\Answers\PlaceAnswerCommand;
use App\Application\Answers\PlaceAnswerHandler;
use App\Application\CommandHandler;
use App\Domain\Answers\AnswerRepository;
use App\Domain\Answers\Events\AnswerWasGiven;
use App\Domain\Answers\Specification\QuestionIsNotArchived;
use App\Domain\Answers\Specification\QuestionIsNotClosed;
use App\Domain\Questions\Question;
use App\Domain\Questions\QuestionRepository;
use App\Domain\UserManagement\User;
use App\Domain\UserManagement\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Psr\EventDispatcher\EventDispatcherInterface;

class PlaceAnswerHandlerSpec extends ObjectBehavior
{

    private $userId;
    private $questionId;

    function let(
        UserRepository $users,
        AnswerRepository $answers,
        User $owner,
        Question $question,
        QuestionRepository $questions,
        QuestionIsNotClosed $questionIsNotClosed,
        QuestionIsNotArchived $questionIsNotArchived,
        EventDispatcherInterface $dispatcher
    ) {

        $this->userId = new User\UserId();
        $users->withId($this->userId)->willReturn($owner);
        $owner->userId()->willReturn($this->userId);

        $this->questionId = new Question\QuestionId();
        $questions->withQuestionId($this->questionId)->willReturn($question);
        $question->questionId()->willReturn($this->questionId);
        $question->isClosed()->willReturn(false);
        $question->answers()->willReturn(new ArrayCollection());

        $answers->add(Argument::type(Answer::class))->willReturnArgument();

        $dispatcher->dispatch(Argument::type(AnswerWasGiven::class))->willReturnArgument();

        $this->beConstructedWith(
                $users,
                $questions,
                $answers,
                $dispatcher
            );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(PlaceAnswerHandler::class);
    }

    function its_a_command_handler()
    {
        $this->shouldBeAnInstanceOf(CommandHandler::class);
    }

    function it_handles_place_answer_command(
        AnswerRepository $answers,
        EventDispatcherInterface $dispatcher
    ) {
        $command = new PlaceAnswerCommand(
            $this->userId,
            $this->questionId,
            "Answer body",
            false
        );

        $answer = $this->handle($command);
        $answer->shouldBeAnInstanceOf(Answer::class);

        $answers->add($answer)->shouldHaveBeenCalled();
        $dispatcher->dispatch(Argument::type(AnswerWasGiven::class))->shouldHaveBeenCalled();
    }

}
