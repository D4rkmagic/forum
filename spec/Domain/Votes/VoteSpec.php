<?php

namespace spec\App\Domain\Votes;

use App\Domain\Votes\Vote;
use App\Domain\Questions\Question\QuestionId;
use App\Domain\UserManagement\User\UserId;
use PhpSpec\ObjectBehavior;

class VoteSpec extends ObjectBehavior
{
    private UserId $userId;
    private  QuestionId $questionId;

    function let(){
        $this->userId= new UserId();
        $this->questionId = new QuestionId();

        $this->beConstructedWith(
            $this->userId,
            $this->questionId
        );
    }
    function it_is_initializable()
    {
        $this->shouldHaveType(Vote::class);
    }

    function it_can_be_converted_to_json(){
        $this->shouldHaveType(\JsonSerializable::class);
        $this->jsonSerialize()->shouldBe([
            'answerId' => $this->questionId,
            'userId' =>  $this->userId,
        ]);
    }
}
