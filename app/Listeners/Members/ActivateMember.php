<?php

namespace Vanguard\Listeners\Members;

use Illuminate\Auth\Events\Verified;
use Vanguard\Repositories\Member\MemberRepository;
use Vanguard\Support\Enum\MemberStatus;

class ActivateMember
{
    /**
     * @var MemberRepository
     */
    private $members;

    public function __construct(MemberRepository $members)
    {
        $this->members = $members;
    }

    /**
     * Handle the event.
     *
     * @param Verified $event
     * @return void
     */
    public function handle(Verified $event)
    {
        $this->members->update($event->member->id, [
            'status' => MemberStatus::ACTIVE
        ]);
    }
}
