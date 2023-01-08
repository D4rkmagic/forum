<?php

namespace spec\App\Domain\Answers\Specification;

use App\Domain\Answers\AnswerSpecification;
use App\Domain\Answers\Specification\OwnedByRequester;
use App\Domain\UserManagement\User;
use App\Domain\UserManagement\UserIdentifier;
use PhpSpec\ObjectBehavior;

class OwnedByRequesterSpec extends ObjectBehavior
{
    function let(
        UserIdentifier $identifier,
        User $loggedInUser
    ) {
        $loggedInUser->userId()->willReturn(new User\UserId());
        $identifier->currentUser()->willReturn($loggedInUser);

        $this->beConstructedWith($identifier);
    }
    function it_is_initializable()
    {
        $this->shouldHaveType(OwnedByRequester::class);
    }

    function it_is_a_question_answerSpecification(){
        $this->shouldHaveType(AnswerSpecification::class);
    }
}
