<?php

namespace Vanguard\Support\Enum;

class MemberStatus
{
    const PENDING = 'Pending';
    const VERIFIED = 'Verified';
    const ACCEPTED = 'Accepted'; // Only for renew membership
    const PAID = 'Paid';
    const INSPECTED = 'Inspected';
    const APPROVAL = 'Wait For Approval';
    const APPROVED = 'Admin Approval';

    const UNCONFIRMED = 'Unconfirmed';

    const ACTIVE = 'Active';

    const BANNED = 'Banned';
    const ARCHIVED = 'Archived';

    public static function lists()
    {
        return [
            self::ARCHIVED => trans('app.status.'.self::ARCHIVED),
            self::ACTIVE => trans('app.status.'.self::ACTIVE),
            self::BANNED => trans('app.status.'. self::BANNED),
            self::UNCONFIRMED => trans('app.status.' . self::UNCONFIRMED),
            self::PENDING => trans('app.status.' . self::PENDING),
            self::VERIFIED => trans('app.status.' . self::VERIFIED),
            self::PAID => trans('app.status.' . self::PAID),
            self::INSPECTED => trans('app.status.' . self::INSPECTED),
            self::APPROVAL => trans('app.status.' . self::APPROVAL),
            self::APPROVED => trans('app.status.' . self::APPROVED)
        ];
    }
}
