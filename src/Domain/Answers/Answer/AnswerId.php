<?php

namespace App\Domain\Answers\Answer;

use App\Domain\Comparable;
use App\Domain\Exception\InvalidAggregateIdentifier;
use JsonSerializable;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Stringable;



class AnswerId implements Stringable, Comparable, JsonSerializable
{
    public function __construct(private ?string $answerIdStr = null)
    {
        $this->answerIdStr = $this->answerIdStr ?: Uuid::uuid4()->toString();

        if (!Uuid::isValid($this->answerIdStr)) {
            throw new InvalidAggregateIdentifier(
                "The provided Answer identifier is not a valid UUID."
            );
        }
    }

    /**
     * @inheritDoc
     */
    public function __toString(): string
    {
        return $this->answerIdStr;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize(): mixed
    {
        return $this->answerIdStr;
    }

    /**
     * @inheritDoc
     */
    public function equalsTo(mixed $other): bool
    {
        if ($other instanceof AnswerId) {
            return $other->answerIdStr == $this->answerIdStr;
        }

        return false;
    }
}
