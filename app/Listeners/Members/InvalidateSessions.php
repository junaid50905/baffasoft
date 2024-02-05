<?php

namespace Vanguard\Listeners\Members;

use Vanguard\Events\Member\Banned;
use Vanguard\Repositories\Session\SessionRepository;

class InvalidateSessions
{
    /**
     * @var SessionRepository
     */
    private $sessions;

    public function __construct(SessionRepository $sessions)
    {
        $this->sessions = $sessions;
    }

    /**
     * Handle the event.
     *
     * @param Banned $event
     * @return void
     */
    public function handle(Banned $event)
    {
        $member = $event->getBannedMember();

        $this->sessions->invalidateAllSessionsForUser($member->id);
    }
}
