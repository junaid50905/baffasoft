<?php

namespace Vanguard\Events\Member;

use Vanguard\Member;

class RequestedPasswordResetEmail
{
    /**
     * @var Member
     */
    private $member;

    public function __construct(Member $member)
    {
        $this->member = $member;
    }

    /**
     * @return Member
     */
    public function getMember()
    {
        return $this->member;
    }
}
