<?php

namespace App\Application\Answers;

use App\Application\Command;
use App\Domain\Answers\Answer\AnswerId;


/**
 * ChangeAnswerCommand
 *
 * @package App\Application\Answers
 */
class ChangeAnswerCommand implements Command
{
    /**
     * @param AnswerId $answerId
     * @param string $body
     * @param bool $accepted
     */
    public function __construct(
        private AnswerId $answerId,
        private string $body,
        private bool $accepted
    ){
    }

    /**
     * answerId
     *
     * @return AnswerId
     */
    public function answerId() : AnswerId {
        return $this->answerId;
    }

    /**
     * body
     *
     * @return string
     */
    public function body() : string{
        return $this->body;
    }

    /**
     * isAccepted
     *
     * @return bool
     */
    public function isAccepted() : bool {
        return $this->accepted;
    }

}
