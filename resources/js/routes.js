import VueNewMember from "./components/vue/VueNewMember";
import VueMembers from "./components/vue/VueMembers";
import VueEditMember from "./components/vue/VueEditMember";
import Registration from "./components/members/Registration";
import NewMember from "./components/members/NewMember";
import Members from "./components/members/Members";
import EditMember from "./components/members/EditMember";
import NewGatePass from "./components/gate_pass/NewGatePass";
import Home from "./components/Home";
import Sidebar from "./components/MemberSidebar";
import VueTest from "./components/vue/VueTest";
import FormTest from "./components/vue/FormTest";
import MembersHome from "./components/members/LoginLayout";
import GatePassPrint from "./components/gate_pass/GatePassPrint";
import AllGatePass from "./components/gate_pass/AllGatePass";
import GatePassInvoice from "./components/gate_pass/GatePassInvoice";
import NewGatePassMember from "./components/gate_pass/NewGatePassMember";
import AllGatePassMember from "./components/gate_pass/AllGatePassMember";
import ViewMember from "./components/members/ViewMember";
import NewRenewalMember from "./components/renew_members/NewRenewalMember";
import AllRenewals from "./components/renew_members/AllRenewals";
import AllRenewalForMembers from "./components/renew_members/AllRenewalForMembers";
import NewIDCard from "./components/id_card/NewIDCard";
import AllIDCard from "./components/id_card/AllIdCard";
import ViewIDCard from "./components/id_card/ViewIDCard";
// import IDCardPrint2 from "./components/id_card/IDCardPrint2";
import AllGPCollectionReport from "./components/money_collection/AllGPCollectionReport";
import NewMoneyCollection from "./components/money_collection/NewMoneyCollection";
import Invoice from "./components/money_collection/Invoice";
import MemberVoucher from "./components/members/MemberVoucher";
import EditGatePass from "./components/gate_pass/EditGatePass";
import Navbar from "./components/Navbar";
import EditGatePassMember from "./components/gate_pass/EditGatePassMember";
import ViewGatePassMember from "./components/gate_pass/ViewGatePassMember";
import EmptyPage from "./components/EmptyPage";
import ManagerIdCard from "./components/id_card/ManagerIdCard";
import MemberHome from "./components/MemberHome";
import MemberDashboard from "./components/MemberDashboard";
import MemberNewIDCard from "./components/id_card/MemberNewIDCard";
import MemberAllIdCard from "./components/id_card/MemberAllIdCard";
import MemberEditIDCard from "./components/id_card/MemberEditIDCard";
import MemberViewIDCard from "./components/id_card/MemberViewIDCard";
import AccountIdCard from "./components/id_card/AccountIdCard";
import MemberIdCardReceipt from "./components/id_card/MemberIdCardReceipt";
import IdCardReport from "./components/id_card/IdCardReport";
import ShortRegistration from "./components/members/ShortRegistration";
import CancelIdCardForm from "./components/id_card/reissue_cancel/CancelIdCardForm";
import CancelIdCardPanel from "./components/id_card/reissue_cancel/CancelIdCardPanel";
import ReissueIdCardForm from "./components/id_card/reissue_cancel/ReissueIdCardForm";
import ReissueIdCardPanel from "./components/id_card/reissue_cancel/ReissueIdCardPanel";
import MemberCollectionReport from "./components/money_collection/MemberCollectionReport";
import CompanyOwner from "./components/members/CompanyOwner";
import ViewRenewalMember from "./components/renew_members/ViewRenewalMember";
import EditRenewalMember from "./components/renew_members/EditRenewalMember";
import AllElection from "./components/election/AllElection";
import NewVoter from "./components/election/NewVoter";
import AllVoter from "./components/election/AllVoter";
import ViewVoter from "./components/election/ViewVoter";
import NewTrainingDG from "./components/training/NewTrainingDG";
import NewTrainingCSA from "./components/training/NewTrainingCSA";
import NewTrainingOther from "./components/training/NewTrainingOther";
import AllCSATraining from "./components/training/AllCSATraining";
import ViewTrainingDG from "./components/training/ViewTrainingDG";
import ViewTrainingCSA from "./components/training/ViewTrainingCSA";
import ViewTrainingOther from "./components/training/ViewTrainingOther";
import AllDGTraining from "./components/training/AllDGTraining";
import AllOtherTraining from "./components/training/AllOtherTraining";
import EditTrainingDG from "./components/training/EditTrainingDG";
import EditTrainingCSA from "./components/training/EditTrainingCSA";
import EditTrainingOther from "./components/training/EditTrainingOther";
import EditVoter from "./components/election/EditVoter";
import VoteCasting from "./components/election/VoteCasting";
import AllVoterDownload from "./components/election/AllVoterDownload";
import TrainingName from "./components/training/TrainingName";
import AllSavedGatePass from "./components/gate_pass/AllSavedGatePass.vue";
import IdCardYear from "./components/id_card/IdCardYear.vue";
import RenewalCompanyOwner from "./components/renew_members/RenewalCompanyOwner.vue";
import DueMembers from "./components/members/DueMembers.vue";
import MemberDuePayment from "./components/members/MemberDuePayment.vue";
import ElectionPieChart from "./components/election/ElectionPieChart.vue";
import AllStructuralChanges from "./components/renew_members/AllStructuralChanges.vue";

function dynamicPropsFn (route) {
    const now = new Date()
    return {
        name: (now.getFullYear() + parseInt(route.params.years)) + '!'
    }
}
export const routes = [
    { path:"/members", component:MembersHome ,
        children: [
            { path:"registration", name:"registration", component:Registration, meta: { title: 'Member Registration - BAFFA' }, props: route => ({ warning_message:route.query.warning_message,success: route.query.success }) },
            { path:"new", name:"new-member", meta: { title: 'Edit Member - BAFFA' }, component:NewMember },
        ]
    },


    // { path:"/admin/member/:id", name:"members", component:Member },
    { path:"/print/gate_pass/:id", name:"gate-pass-print", component:GatePassPrint },
    { path:"/admin/gate_pass_invoice/:id", name:"gate-pass-invoice", component:GatePassInvoice },


    // { path:"/admin/gate_pass_payment/:id", name:"gate-pass-payment", component:GatePassPayment },




    { path:"/member", component: MemberHome,
        children: [
            { path:"home", name:"member_home", component: MemberDashboard},
            { path:"due_member_for_member", name:"member_due_payment_for_member", component: MemberDuePayment , props: route => ({is_member:true}) },

            { path:"gate_pass/new", name:"member-new-gate-pass", component:NewGatePassMember },
            { path:"gate_pass/:id", name:"member-edit-gate-pass", component:EditGatePassMember },
            { path:"view_gate_pass/:id", name:"gate-pass-view", component:ViewGatePassMember },
            { path:"gate_pass", name:"member-all-gate-pass", component:AllGatePassMember, props: route => ({ warning_message:route.query.warning_message,success: route.query.success }) },

            { path:"id_card", name:"member-all-id-card", component:MemberAllIdCard, props: route => ({ success: route.query.success }) },
            { path:"id_card/new", name:"member-new-id-card", component:MemberNewIDCard },
            { path:"id_card/:id/edit", name:"member-edit-id-card", component:MemberEditIDCard },
            { path:"id_card/:id", name:"member-view-id-card", component:MemberViewIDCard },
            // { path:"id-card-receipt", name:"id-card-receipt", component:MemberIdCardReceipt },
            { path:"receipts", name:"member-receipts", component:MemberCollectionReport },
            { path:"member_invoice/:id", name:"member-invoice", component:Invoice },
            { path:"cancel_id_card/:panel/:id", name:"cancel-id-card-form", component:CancelIdCardForm },
            { path:"reissue_id_card/:panel/:id", name:"reissue-id-card-form", component: ReissueIdCardForm},
            { path:"cancel_id_card", name:"cancel-id-card-panel-member", component:CancelIdCardPanel, props: route => ({is_member:true, success: route.query.success }) },
            { path:"reissue_id_card", name:"reissue-id-card-panel-member", component:ReissueIdCardPanel, props: route => ({is_member:true, success: route.query.success }) },

            { path:"renew-member", name:"renew-member-for-member", component:NewRenewalMember, props: route => ({is_member:true}) },
            { path:"structure-change", name:"structure-change", component:NewRenewalMember, props: route => ({is_member:true,structure_change:true}) },
            { path:"renew-members", name:"all-renew-members-for-member", component:AllRenewalForMembers, props: route => ({is_member:true,warning_message: route.query.warning_message}) },
            { path:"renew-member/:id", name:"view-renewal-member-for-member", component:ViewRenewalMember, props: route => ({is_member:true})  },
            { path:"renew-member/:id/company_owner", name:"renewal-company-owners-for-member", component:RenewalCompanyOwner, props: route => ({is_member:true}) },


            { path:"training/csa/new", name:"new_training_csa_for_member", component:NewTrainingCSA, props: route => ({is_member:true}) },
            { path:"training/all-csa", name:"all-csa-training_member", component: AllCSATraining, props: route => ({is_member:true, success: route.query.success })},
            { path:"training/dg/new", name:"new_training_dg_for_member", component:NewTrainingDG, props: route => ({is_member:true}) },
            { path:"training/all-dg", name:"all-dg-training_member", component: AllDGTraining, props: route => ({is_member:true, success: route.query.success })},
            { path:"training/other/new", name:"new_training_other_for_member", component:NewTrainingOther, props: route => ({is_member:true}) },
            { path:"training/all-other", name:"all-other-training_member", component: AllOtherTraining, props: route => ({is_member:true, success: route.query.success })},

            { path:"logout", name:"logout", component: MemberDashboard}
        ]
    },
    { path:"/election/pie_chart", name:"admin_election_pie_chart", component: ElectionPieChart},
    { path:"/admin", component: Home,
        children: [
            { path:"home", name:"staff_home", component: EmptyPage},
            { path:"members", name:"members", component: Members },
            { path:"due_members", name:"due_members", component: DueMembers },
            { path:"due_member/:id", name:"member_due_payment", component: MemberDuePayment },
            { path:"members/short_new", name:"short-new-member", component: ShortRegistration },
            { path:"member/:id/edit", name:"edit-member", component:EditMember,props: route => ({only_edit: route.query.only_edit}) },
            { path:"member/:id", name:"view-member", component:ViewMember },
            { path:"member/voucher/:id", name:"member-collection-summary", component:MemberVoucher },
            { path:"member/:id/company_owner", name:"company_owners", component:CompanyOwner },

            { path:"member/:id/renew", name:"renew-member", component:NewRenewalMember },
            { path:"renew-member/:id", name:"view-renewal-member", component:ViewRenewalMember },
            { path:"renew-member/:id/edit", name:"edit-renewal-member", component:EditRenewalMember },
            { path:"renew-members", name:"all-renew-members", component:AllRenewals },
            { path:"structure-members", name:"all-structure-members", component:AllStructuralChanges },
            { path:"renew-member/:id/company_owner", name:"renewal-company-owners", component:RenewalCompanyOwner },

            { path:"elections", name:"all-election", component: AllElection, props: route => ({ success: route.query.success }) },
            { path:"voter/new", name:"new-voter", component: NewVoter},
            { path:"voter/:id/edit", name:"edit-voter", component: EditVoter},
            { path:"voter/:id", name:"view-voter", component:ViewVoter },
            // { path:"voter/:id", name:"print-voter", component:ViewVoter },
            { path:"election/:election_id/voters", name:"voters", component: AllVoter},
            { path:"election/:election_id/voters_download", name:"voters_download", component: AllVoterDownload, props: route => ({ list: route.query.list })},
            { path:"election/dhaka_vote_casting", name:"dhaka_vote", component: VoteCasting, props: route => ({ location: 'Dhaka' })},
            { path:"election/chattogram_vote_casting", name:"chattogram_vote", component: VoteCasting, props: route => ({ location: 'Chattogram' })},

            { path:"training/dg/new", name:"new_training_dg", component: NewTrainingDG},
            { path:"training/dg/:id/edit", name:"edit_training_dg", component: EditTrainingDG},
            { path:"training/dg/:id", name:"training_dg", component: ViewTrainingDG},

            { path:"training/csa/new", name:"new_training_csa", component: NewTrainingCSA},
            { path:"training/csa/:id/edit", name:"edit_training_csa", component: EditTrainingCSA},
            { path:"training/csa/:id", name:"training_csa", component: ViewTrainingCSA},

            { path:"training/other/new", name:"new_training_other", component: NewTrainingOther},
            { path:"training/other/:id/edit", name:"edit_training_other", component: EditTrainingOther},
            { path:"training/other/:id", name:"training_other", component: ViewTrainingOther},

            { path:"training/all-csa", name:"all-csa-training", component: AllCSATraining, props: route => ({ success: route.query.success })},
            { path:"training/all-dg", name:"all-dg-training", component: AllDGTraining, props: route => ({ success: route.query.success })},
            { path:"training/all-other", name:"all-other-training", component: AllOtherTraining, props: route => ({ success: route.query.success })},
            { path:"training-names", name:"training-names", component: TrainingName, props: route => ({ success: route.query.success }) },

            { path:"saved_gate_pass", name:"saved-gate-pass", component: AllSavedGatePass, props: route => ({ success: route.query.success }) },
            { path:"gate_pass", name:"all-gate-pass", component: AllGatePass, props: route => ({ success: route.query.success }) },
            { path:"gate_pass/new", name:"new-gate-pass", component: NewGatePass},
            { path:"gate_pass/:id", name:"gate-pass-amend", component:EditGatePass },

            { path:"id-card-report", name:"id-card-report", component:IdCardReport, props: route => ({ success: route.query.success }) },
            { path:"id_card", name:"all-id-card", component:AllIDCard, props: route => ({ success: route.query.success }) },
            { path:"id_card_year", name:"id_card_year", component:IdCardYear, props: route => ({ success: route.query.success }) },
            { path:"manager_id_card", name:"manager-id-card", component:ManagerIdCard, props: route => ({ success: route.query.success }) },
            { path:"accounts-id-card", name:"accounts-id-card", component:AccountIdCard },
            { path:"id_card/new", name:"new-id-card", component:NewIDCard },
            { path:"id_card/:id", name:"view-id-card", component:ViewIDCard },

            { path:"cancel_id_card/:panel/:id", name:"view-cancel-id-card-form", component:CancelIdCardForm },
            { path:"reissue_id_card/:panel/:id", name:"view-reissue-id-card-form", component: ReissueIdCardForm},
            { path:"cancel_id_card", name:"cancel-id-card-panel", component:CancelIdCardPanel, props: route => ({ success: route.query.success }) },
            { path:"reissue_id_card", name:"reissue-id-card-panel", component:ReissueIdCardPanel, props: route => ({ success: route.query.success }) },

            { path:"money_collection", name:"all-collection", component:AllGPCollectionReport, props: route => ({ success: route.query.success,warning_message: route.query.warning_message }) },
            { path:"money_collection/new/:member_id(\\d+)?", name:"new-collection", component:NewMoneyCollection,
                props: route => ({
                    props_id: route.query.props_id,
                    props_receipt_type: route.query.props_receipt_type,
                    props_receipt_year: route.query.props_receipt_year
                }) },
            { path:"invoice/:id", name:"invoice", component:Invoice },

        ]
    },

    { path:"/vue", component:Home ,
        children: [

            { path:"form", component: FormTest },
            // { path:"members/edit/:id", redirect: 'members/new/:id' },
            { path: 'items/:id/logs/:email', name: 'send-mail', component: VueTest},
            { path: '/', component: VueTest }, // No props, no nothing
            { path: 'search', component: VueTest, props: route => ({ name: route.query.q }) }, // The URL /search?q=vue would pass {name: 'vue'} as props to the SearchUser component.
            { path: 'hello/:name', component: VueTest, props: true }, // Pass route.params to props
            { path: 'static', component: VueTest, props: { name: 'world' }}, // static values
            { path: 'dynamic/:years', component: VueTest, props: dynamicPropsFn }, // custom logic for mapping between route and props
            { path: 'dynamic/:years(\\d+)', component: VueTest, props: dynamicPropsFn }, // this route will only be matched if :years is all numbers otherwise Result: NaN
            { path:"test/:id", component:VueTest, params:true },

            { path:"members/edit/:id",  name:"vue-edit-member", component:VueEditMember, alias: 'members/new/:id',params:true },
            { path:"members/new", name:"vue-new-member", component:VueNewMember },
            { path:"members", name:"vue-members", components: {default: VueMembers, helper: VueNewMember, sidebar: Sidebar} },
        ]
    },
];
