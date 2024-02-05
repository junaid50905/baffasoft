<?php

namespace Vanguard\Events\Member;

use Vanguard\Member;

class Banned
{
    /**
     * @var Member
     */
    protected $bannedMember;

    public function __construct(Member $bannedMember)
    {
        $this->bannedMember = $bannedMember;
    }

    /**
     * @return Member
     */
    public function getBannedMember()
    {
        return $this->bannedMember;
    }
}
