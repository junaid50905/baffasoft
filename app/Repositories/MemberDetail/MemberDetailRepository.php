<?php

namespace Vanguard\Repositories\MemberDetail;

use Vanguard\MemberDetail;

//use \Laravel\Socialite\Contracts\User as SocialUser;

interface MemberDetailRepository
{
    /**
     * Paginate registered users.
     *
     * @param $perPage
     * @param null $search
     * @param null $status
     * @return mixed
     */
    public function paginate($perPage, $search = null, $status = null);
    /**
     * Find user by its id.
     *
     * @param $id
     * @return null|MemberDetail
     */
    public function find($id);
    /**
     * Get all available countries.
     * @return mixed
     */
    public function all();
}
