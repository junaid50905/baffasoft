<?php

namespace Vanguard\Events\Member;

use Vanguard\Member;

class Deleted
{
    /**
     * @var Member
     */
    protected $deletedMember;

    public function __construct(Member $deletedMember)
    {
        $this->deletedMember = $deletedMember;
    }

    /**
     * @return Member
     */
    public function getDeletedMember()
    {
        return $this->deletedMember;
    }
}
