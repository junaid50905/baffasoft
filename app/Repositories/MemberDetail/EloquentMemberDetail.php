<?php

namespace Vanguard\Repositories\MemberDetail;

use Vanguard\Http\Filters\MemberKeywordSearch;
use Vanguard\Http\Filters\UserKeywordSearch;
use Vanguard\Member;
use Vanguard\MemberDetail;
use Vanguard\User;

class EloquentMemberDetail implements MemberDetailRepository
{
    /**
     * {@inheritdoc}
     */
    public function paginate($perPage, $search = null, $status = null)
    {
        $query = Member::query();

        if ($status) {
            $query->where('status', $status);
        }

        if ($search) {
            (new MemberKeywordSearch)($query, $search);
        }

        $result = $query->orderBy('id', 'desc')
            ->paginate($perPage);

        if ($search) {
            $result->appends(['search' => $search]);
        }

        if ($status) {
            $result->appends(['status' => $status]);
        }

        return $result;
    }

    /**
     * @inheritDoc
     */
    public function find($id)
    {
        return MemberDetail::find($id);
    }

    /**
     * {@inheritdoc}
     */
    public function all()
    {
        return MemberDetail::all();
    }
}
