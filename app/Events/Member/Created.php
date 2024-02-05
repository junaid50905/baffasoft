<?php

namespace Vanguard\Events\Member;

use Vanguard\Member;

class Created
{
    /**
     * @var Member
     */
    protected $createdMember;

    public function __construct(Member $createdMember)
    {
        $this->createdMember = $createdMember;
    }

    /**
     * @return Member
     */
    public function getCreatedMember()
    {
        return $this->createdMember;
    }
}
