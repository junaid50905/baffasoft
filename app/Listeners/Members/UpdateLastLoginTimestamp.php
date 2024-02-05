<?php

namespace Vanguard\Listeners\Members;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Vanguard\Repositories\Member\MemberRepository;

class UpdateLastLoginTimestamp
{

    /**
     * @var MemberRepository
     */
    private $users;
    /**
     * @var Guard
     */
    private $guard;

    /**
     * @param MemberRepository $users
     * @param Guard $guard
     */
    public function __construct(MemberRepository $users, Guard $guard)
    {
        $this->users = $users;
        $this->guard = $guard;
    }
    /**
     * Create the event listener.
     *
     * @return void
     */



    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        //
    }
}
