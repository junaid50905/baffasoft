<?php

class IdCardStatus
{
    public static $positions = [
        'Pending',          // 0 - After submitting ID card request by member
        'Editable',         // 1 - If ID card dept. comment to member for update any information
        'Verified_ID',      // 2 - After Verified by ID card Dept.
        'Selection',        // 3 - Director sir approved
        'Cancelled',        // 4 - If Director Sir does not approve
        'Decline',          // 5 - If member cancel any ID card from choose option
        'Accepted',         // 6 - Director sir approved or Member Choosed
        'Paid',             // 7 - After payment Done
        'Processing',       // 8 - After Numbering ID card
        'Ready',            // 9 - After Input Proximity Number
        'Delivered'         // 10 - After Input Delivery Date
    ];

}
