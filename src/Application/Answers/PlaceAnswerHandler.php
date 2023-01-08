<?php

namespace App\Application\Answers;

use App\Application\Command;
use App\Application\CommandHandler;
use App\Application\CommandHandlerMethods;
use App\Domain\Answers\Answer;
use App\Domain\Answers\AnswerRepository;
use App\Domain\Answers\Specification\QuestionIsNotArchived;
use App\Domain\Answers\Specification\QuestionIsNotClosed;
use App\Domain\Questions\Question;
use App\Domain\Questions\QuestionRepository;
use App\Domain\UserManagement\UserRepository;
use Psr\EventDispatcher\EventDispatcherInterface;

/**
 * PlaceAnswerHandler
 *
 * @package App\Application\Answers
 */
class PlaceAnswerHandler implements CommandHandler
{
    use CommandHandlerMethods;

    public function __construct(
        private UserRepository $users,
        private QuestionRepository $questions,
        private AnswerRepository $answers,
        private EventDispatcherInterface $dispatcher
    ){

    }
    /**
     * @inheritDoc
     */
    public function handle(Command $command): Answer
    {

        $owner = $this->users->withId($command->ownerUserId());
        $question = $this->questions->withQuestionId($command->questionId());
        $answer = new Answer($owner, $question, $command->body(), $command->isAccepted());

        $this->dispatchEventsFrom($this->answers->add($answer), $this->dispatcher);

        return $answer;
    }
}
