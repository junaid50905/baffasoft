// const path = require("path");
module.exports = {
    /* ... */
    // 'process.env.NODE_ENV': JSON.stringify('production'),
    publicPath: process.env.NODE_ENV === 'production' ? '' : '/baffasoft',
    assetPath: process.env.NODE_ENV === 'production' ? '' : '/baffasoft',
    assetsDir: '../main/',
    allPages: {
        "member": ['edit_member', 'payment_member'],
        "id_card": ['edit_id_card', 'payment_id_card']
    },
    userAccess: {
        'admin': [
            'id-card-dropdown','all-id-card', 'manager-id-card', 'accounts-id-card', 'new-id-card', 'id-card-report','cancel-id-card-panel', 'reissue-id-card-panel','id-card-collection','id-card-year',
            'members-dropdown','members','all-renew-members','short-new-member','due-members',
            'edit_member', 'payment_member', 'inspection_member', 'approve_member', 'active_member','inactive_member',
            'edit_renew_member', 'payment_renew_member', 'approve_renew_member', 'active_renew_member',
            'new_company_owner','edit_company_owner', 'company_owner' ,'delete_company_owner',
            'voter-dropdown','edit-voter','view-voter','print-voter','make_list','vote-casting-dhk','vote-casting-ctg','new-election','assign-member-for-vote',
            'training-dropdown','edit-training','view-training','approve-training','payment-training','new-training','training-visibility','delete-training'
        ],
        // Membership
        'shakhaowat.baffa':[
            'members-dropdown','members','all-renew-members','due-members',
            'edit_member', 'inspection_member','inactive_member',
            'edit_renew_member', 'approve_renew_member',
            'new_company_owner','edit_company_owner', 'company_owner' ,'delete_company_owner',
        ],
        'bahar.baffa':[
            'members-dropdown','members','all-renew-members','due-members',
            'edit_member', 'inspection_member','inactive_member',
            'edit_renew_member', 'approve_renew_member',
            'new_company_owner','edit_company_owner', 'company_owner' ,'delete_company_owner',
        ],

        // Membership, ID Card - President/Admin/Director
        'dir1.baffa': [
            'members-dropdown','due-members',
            'id-card-dropdown','manager-id-card','id-card-report','cancel-id-card-panel','reissue-id-card-panel'],
        'admin.baffa': [
            'members-dropdown','members','all-renew-members','due-members',
            'approve_member','approve_renew_member',
            'company_owner'
        ],
        'president.baffa': [
            'members-dropdown','members','all-renew-members','due-members',
            'active_member','active_renew_member',
            'company_owner'
        ],

        // ID Card, Training
        'saidul.baffa': [
            'id-card-dropdown','all-id-card','manager-id-card','id-card-report','cancel-id-card-panel','reissue-id-card-panel',
            'training-dropdown','edit-training','view-training','approve-training','new-training','training-visibility','delete-training'
        ],
        'reza.baffa': [
            'id-card-dropdown','all-id-card','manager-id-card','id-card-report','cancel-id-card-panel','reissue-id-card-panel',
            'training-dropdown','edit-training','view-training','approve-training','new-training','training-visibility','delete-training'
        ],

        // Membership, ID Card, Training - Accounts Department
        'tulshidas.baffa': [
            'members-dropdown','members','due-members',
            'company_owner',
            'all-renew-members','payment_renew_member',
            'training-dropdown','payment-training',
            'id-card-dropdown','accounts-id-card',
            'payment_member','id-card-report','reissue-id-card-panel'
        ],
        'kamrul.baffa': [
            'members-dropdown','members','due-members',
            'company_owner',
            'all-renew-members','payment_renew_member',
            'training-dropdown','payment-training',
            'id-card-dropdown','accounts-id-card',
            'payment_member','id-card-report','reissue-id-card-panel'
        ],
        'shahed.baffa': [
            'members-dropdown','members','due-members',
            'company_owner',
            'all-renew-members','payment_renew_member',
            'training-dropdown','payment-training',
            'id-card-dropdown','accounts-id-card',
            'payment_member','id-card-report','reissue-id-card-panel'
        ],
        'hasin.baffa': [
            'members-dropdown','members','due-members',
            'company_owner',
            'all-renew-members','payment_renew_member',
            'training-dropdown','payment-training',
            'id-card-dropdown','accounts-id-card',
            'payment_member','id-card-report','reissue-id-card-panel'
        ],

        // Election
        'es.baffa':[
            'voter-dropdown','edit-voter','view-voter','print-voter','make_list','new-election','assign-member-for-vote',
            'members-dropdown','members','all-renew-members','due-members',
            'company_owner'
        ],
        'elc.dhk1':['voter-dropdown','vote-casting-dhk','view-voter'],
        'elc.dhk2':['voter-dropdown','vote-casting-dhk','view-voter'],
        'elc.ctg1':['voter-dropdown','vote-casting-ctg','view-voter'],

        // Temporary
        'finance.dhk': [
            'members-dropdown','members','all-renew-members','due-members',
            'company_owner'
        ],
        'finance.ctg': [
            'members-dropdown','members','all-renew-members','due-members',
            'company_owner'
        ]
    }
}
