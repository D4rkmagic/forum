<?php

namespace App\Application\Answers;

use App\Application\Command;
use App\Application\CommandHandler;
use App\Application\CommandHandlerMethods;
use App\Domain\Answers\Answer;
use App\Domain\Answers\AnswerRepository;
use App\Domain\Answers\Specification\IsNotAccepted;
use App\Domain\Answers\Specification\OwnedByRequester;
use App\Domain\Answers\Specification\QuestionIsNotArchived;
use App\Domain\Exception\SpecificationFails;
use Psr\EventDispatcher\EventDispatcherInterface;

class ChangeAnswerHandler implements CommandHandler
{
    use CommandHandlerMethods;

    public function __construct(
        private AnswerRepository $answers,
        private IsNotAccepted $isNotAccepted,
        private OwnedByRequester $ownedByRequester,
        private QuestionIsNotArchived $questionIsNotArchived,
        private EventDispatcherInterface $dispatcher
    ){

    }

    /**
     * @inheritDoc
     */
    public function handle(Command $command): Answer
    {
        $answer = $this->answers->withAnswerId($command->answerId());

        if($this->isNotAccepted->isSatisfiedBy($answer)){
            throw new SpecificationFails(
                "Could not change selected answer. " .
                "Answers can only be changed when they are not accepted yet."
            );
        }

        if($this->ownedByRequester->isSatisfiedBy($answer)){
            throw new SpecificationFails(
                "Could not change selected answer. " .
                "Answers can only be changed by the person who owns them."
            );
        }

        if($this->questionIsNotArchived->isSatisfiedBy($answer)){
            throw new SpecificationFails(
                "Could not change selected answer. " .
                "Answers can only be changed if the question is not archived."
            );
        }

        $this->dispatchEventsFrom(
            $answer->changeAnswer([
                'answerId' => $answer->answerId(),
                'userId' => $answer->userId(),
                'questionId' => $answer->questionId(),
                'body' => $command->body(),
                'accepted' => $command->isAccepted()
            ]),
            $this->dispatcher
        );

        return $answer;
    }
}
