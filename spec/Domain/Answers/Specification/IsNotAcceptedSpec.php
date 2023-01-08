<?php

namespace spec\App\Domain\Answers\Specification;

use App\Domain\Answers\Specification\IsNotAccepted;
use PhpSpec\ObjectBehavior;

class IsNotAcceptedSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(IsNotAccepted::class);
    }
}
