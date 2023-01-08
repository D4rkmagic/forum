<?php

namespace spec\App\Domain\Answers\Specification;

use App\Domain\Answers\Specification\QuestionIsNotClosed;
use App\Domain\Questions\Question;
use App\Domain\Questions\QuestionRepository;
use PhpSpec\ObjectBehavior;

class QuestionIsNotClosedSpec extends ObjectBehavior
{
    private $questionId;

    function let(
        QuestionRepository $questionRepository,
        Question $question
    ) {
        $this->questionId = new Question\QuestionId();
        $questionRepository->withQuestionId($this->questionId)->willReturn($question);
        $question->questionId()->willReturn($this->questionId);

        $this->beConstructedWith($question);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(QuestionIsNotClosed::class);
    }
}
