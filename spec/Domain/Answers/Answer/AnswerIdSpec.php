<?php

namespace spec\App\Domain\Answers\Answer;

use App\Domain\Answers\Answer;
use App\Domain\Answers\Answer\AnswerId;
use App\Domain\Comparable;
use App\Domain\Exception\InvalidAggregateIdentifier;
use App\Domain\UserManagement\User\UserId;
use phpDocumentor\Reflection\Types\String_;
use PhpSpec\ObjectBehavior;
use Ramsey\Uuid\Uuid;


class AnswerIdSpec extends ObjectBehavior
{
    public $uuidStr;

    function let()
    {
        $this->uuidStr = Uuid::uuid4()->toString();
        $this->beConstructedWith($this->uuidStr);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(AnswerId::class);
    }

    function it_can_be_converted_to_string()
    {
        $this->shouldBeAnInstanceOf(\Stringable::class);
        $this->__toString()->shouldBe($this->uuidStr);
    }

    function it_can_be_compared()
    {
        $this->shouldBeAnInstanceOf(Comparable::class);
        $this->equalsTo(new AnswerId($this->uuidStr))->shouldBe(true);
        $this->equalsTo(new AnswerId())->shouldBe(false);
        $this->equalsTo($this->uuidStr)->shouldBe(false);
    }

    function it_can_be_converted_to_json()
    {
        $this->shouldBeAnInstanceOf(\JsonSerializable::class);
        $this->jsonSerialize()->shouldBe($this->uuidStr);
    }

    function it_can_be_created_without_a_uuid_string()
    {
        $this->beConstructedWith();
        $this->shouldBeAnInstanceOf(AnswerId::class);
    }

    function it_throws_an_exception_when_uuid_is_not_valid()
    {
        $this->beConstructedWith('Some strange UUID.');
        $this->shouldThrow(InvalidAggregateIdentifier::class)
            ->duringInstantiation();
    }
}
