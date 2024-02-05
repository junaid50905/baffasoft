<?php

namespace Vanguard\Events\Member;

use Vanguard\Member;

class TwoFactorEnabledByAdmin
{
    /**
     * @var Member
     */
    protected $member;

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
