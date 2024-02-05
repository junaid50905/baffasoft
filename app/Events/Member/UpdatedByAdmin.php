<?php

namespace Vanguard\Events\Member;

use Vanguard\Member;

class UpdatedByAdmin
{
    /**
     * @var Member
     */
    protected $updatedMember;

    public function __construct(Member $updatedMember)
    {
        $this->updatedMember = $updatedMember;
    }

    /**
     * @return Member
     */
    public function getUpdatedMember()
    {
        return $this->updatedMember;
    }
}
