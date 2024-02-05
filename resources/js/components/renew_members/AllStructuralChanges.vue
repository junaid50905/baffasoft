<template>
    <div>
        <div class="card">
            <div class="card-body">
                <div
                    id="loader"
                    v-if="loading"
                    v-bind:style="{
            backgroundImage: 'url(' + addProjectPath('/assets/img/ajax-loader.gif') + ')',
          }"
                ></div>
                <b-row>
                    <b-col sm="4" md="4" class="my-1">
                        <v-select
                            v-model="selected_bmn_no"
                            :options="organizations"
                            :reduce="(organizations) => organizations.id"
                            label="organization_name"
                        ></v-select>
                    </b-col>
                    <b-col lg="3" md="3" class="my-1">
                        <b-form-group class="mb-0">
                            <b-input-group size="sm">
                                <b-form-select v-model="select_status" size="sm" class="w-25">
                                    <option value="null">Select Status</option>
                                    <option value="Pending">Pending</option>
                                    <option value="Accepted">Accepted</option>
                                    <option value="Paid">Paid</option>
                                    <option value="Done">Done</option>
                                </b-form-select>
                            </b-input-group>
                        </b-form-group>
                    </b-col>
                    <b-col sm="3" md="3" class="my-1">
                        <b-input-group>
                            <b-form-input
                                v-model="submission_year"
                                name="submission_year"
                                type="number"
                                placeholder="Year"
                            ></b-form-input>
                        </b-input-group>
                    </b-col>
                    <b-col sm="2" md="2" class="my-1">
                        <div class="d-grid gap-2">
                            <b-button size="sm" @click="doFilterByDate"
                            >Generate Report
                            </b-button>
                        </div>
                    </b-col>
                </b-row>
                <!--        <b style="margin-left: 5%">Search Bar For Firm Name</b>
                          <b style="margin-left: 35%">Filter Option For year & Status</b>-->
                <b-row>
                    <b-col sm="5" md="6" class="my-1">
                        <b-form-group
                            label="Per page"
                            label-for="per-page-select"
                            label-cols-sm="6"
                            label-cols-md="4"
                            label-cols-lg="3"
                            label-align-sm="right"
                            label-size="sm"
                            class="mb-0"
                        >
                            <b-form-select
                                id="per-page-select"
                                v-model="perPage"
                                :options="pageOptions"
                                size="sm"
                            ></b-form-select>
                        </b-form-group>
                    </b-col>

                    <b-col sm="7" md="6" class="my-1">
                        <b-pagination
                            v-model="currentPage"
                            :total-rows="totalRows"
                            :per-page="perPage"
                            align="fill"
                            size="sm"
                            class="my-0"
                        ></b-pagination>
                    </b-col>
                </b-row>
                <br/>
                <div class="table-responsive" id="users-table-wrapper">
                    <validation-errors
                        :errors="validationErrors"
                        :success="success"
                        :warning_message="warning_message"
                    ></validation-errors>

                    <b-table
                        striped
                        hover
                        small
                        show-empty
                        id="table-transition-example"
                        primary-key="id"
                        :items="members"
                        :fields="fields"
                        :current-page="currentPage"
                        :per-page="perPage"
                        :tbody-transition-props="transProps"
                        :busy.sync="isBusy"
                    >
                        <template #cell(firm_name)="row">
                            {{ row.value }}
                            <!--                            <a :href="addProjectPath('/profile/member/'+row.item.id)">-->
                            <!--                                {{ row.value }}-->
                            <!--                            </a>-->
                        </template>
                        <template #cell(firm_type)="row">
                            {{ row.value === 'Proprietor'
                            ? 'Proprietorship'
                            : row.value === 'Partners' ? 'Partnership' : 'Limited Company'}}
                        </template>
                        <template #cell(structure_change_charge)="row">
                            {{ row.value }} TK
                        </template>
                        <template #cell(status)="row">
                          <span
                              v-bind:class="[
                                          row.value === 'Done'
                                            ? 'badge-success bg-success'
                                            : row.value === 'Pending'
                                            ? 'badge-danger bg-danger'
                                            : 'badge-warning bg-secondary',
                                          'badge badge-lg',
                                        ]"
                          >
                            {{ row.value }}
                          </span>
                        </template>
                        <template #cell(member)="row">
                            <router-link
                                :to="{ name: 'view-member', params: { id: row.item.member_id } }"
                                class="btn btn-icon edit"
                                title="Member"
                                data-toggle="tooltip"
                                data-placement="top"
                            ><i class="fas fa-user-circle"></i>
                            </router-link>
                            <span v-if="checkAccess('company_owner')"><router-link
                                :to="{ name: 'company_owners', params: { id: row.item.member_id } }"
                                class="btn btn-icon"
                                title="Company Owners"
                                data-toggle="tooltip"
                                data-placement="top"
                            ><i class="fas fa-user-plus"></i>
                            </router-link></span>
                            <span v-if="checkAccess('edit_renew_member')">
                                <router-link v-if="row.item.status == 'Paid'"
                                    :to="{ name: 'edit-member', params: { id: row.item.member_id }, query: { only_edit: 'Yes' }, }"
                                    class="btn btn-icon edit"
                                    title="Edit Member"
                                    data-toggle="tooltip"
                                    data-placement="top"><i
                                    class="fas fa-user-edit"></i> </router-link>
                            </span>
                        </template>
                        <template #cell(renew_member)="row">
                                <router-link
                                    :to="{ name: 'view-renewal-member', params: { id: row.item.id } }"
                                    class="btn btn-icon edit" title="Renew Member" data-toggle="tooltip"
                                    data-placement="top"><i class="fas fa-user-circle"></i></router-link>
                                <span v-if="checkAccess('company_owner')">
                                    <router-link v-if="row.item.any_change"
                                    :to="{ name: 'renewal-company-owners', params: { id: row.item.id } }"
                                    class="btn btn-icon edit"
                                    title="Company Owners"
                                    data-toggle="tooltip"
                                    data-placement="top"><i class="fas fa-user-plus"></i> </router-link></span>
                                <span v-if="checkAccess('edit_renew_member')">
                                    <router-link
                                    v-if="row.item.status == 'Pending'"
                                    :to="{ name: 'edit-renewal-member', params: { id: row.item.id } }"
                                    class="btn btn-icon edit" title="Edit Member" data-toggle="tooltip"
                                    data-placement="top"><i class="fas fa-edit"></i> </router-link>
                                    <button v-if="row.item.status == 'Paid'"
                                            class="btn btn-success btn-sm"
                                            @click="updateCompanyName(row.item.id)">Update Company Name</button>
                                </span>
                                <span v-if="checkAccess('inactive_member')">
                                    <button v-if="row.item.status == 'Pending'" class="btn btn-icon" @click="deleteMember(row.item.id)">
                                        <i class="fas fa-trash"></i></button>
                                </span>
                                <span v-if="checkAccess('payment_renew_member')">
                                    <span v-if="row.item.status == 'Accepted'">
                                            <router-link v-if="!row.item.is_payment"
                                                         :to="{
                                                 name: 'new-collection',
                                                 params: { member_id: row.item.member_id },
                                                 query: { props_id: row.item.id,
                                                 props_receipt_type: 'membership_structure_change',
                                                 props_receipt_year: row.item.submission_year, }, }"
                                                         class="btn btn-success btn-sm">Payment</router-link>
                                    </span>
                                </span>
                        </template>
                    </b-table>
                </div>
            </div>
        </div>
        <b-modal
            id="modal-member-approval1"
            ref="modal"
            title="Structure Change Charge"
            @show="resetModal"
            @hidden="resetModal"
            @ok="handleOk"
        >
            <form ref="form" @submit.stop.prevent="handleSubmit" role="form" id="structure-change-charge-form" autocomplete="off">
                <b-form-group label="Amount(TK)" label-for="structure_change_charge">
                    <b-form-input
                        id="structure_change_charge"
                        type="number"
                        name="structure_change_charge"
                        v-model="structure_change_charge"
                    ></b-form-input>
                </b-form-group>
            </form>
<!--            <b-button class="mt-3" variant="outline-success" block @click="handleOk">Update</b-button>-->
        </b-modal>
        <MemberInspection
            :hideField=true
            :memberId="memberId"
            :send_to_admin=false
            @reset="reset" @getMembers="getMembers" />
    </div>
</template>

<script>
import ValidationErrors from "../ValidationErrors";
import vSelect from "vue-select";
import ImageTag from "../ImageTag.vue";
import MemberInspection from "../MemberInspection.vue";

export default {
    name: "AllStructuralChanges",
    components: {MemberInspection, ImageTag, ValidationErrors, vSelect},
    data: () => ({
        structure_change_charge:0,
        select_status: null,
        selected_bmn_no: null,
        submission_year: '',
        organizations: [],
        loading: false,
        memberId: null,
        members: [],
        errors: [],
        validationErrors: null,
        success: "",
        warning_message: "",
        approval_image: null,
        nameState: null,
        selected: [],
        isBusy: false,
        totalRows: 1,
        currentPage: 1,
        perPage: 5,
        pageOptions: [5, 10, 15, {value: 100, text: "Show a lot"}],
        transProps: {
            // Transition name
            name: "flip-list",
        },
        fields: [{ key: "member.username", label: "BMN"},"firm_name", "firm_type", "type_local", {
            key: "submission_year",
            label: 'Year'
        }, "status", "member", "renew_member"],
        options: [
            {value: "login", text: "Login Access", disabled: true},
            {value: "1", text: "Gate Pass"},
            {value: "2", text: "ID Card"},
        ],
    }),
    watch: {
        file1() {
            this.nameState = !!this.file1; // if File, then return false
        },
    },
    created() {
        this.getMembers();
        this.getOrganizations();
    },
    methods: {
        sendActiveMemberInfo(id) {
            this.memberId = id;
            console.log("Member ID", id);
        },
        doFilterByDate() {
            console.log(this.selected_bmn_no);
            this.loading = true;
            axios
                .get(
                    "/api/renew_member?" +
                    "filter=yes" +
                    "&member_id=" +
                    this.selected_bmn_no +
                    "&submission_year=" +
                    this.submission_year +
                    "&status=" +
                    this.select_status
                )
                .then((res) => {
                    this.members = res.data;
                    this.totalRows = this.members.length;
                })
                .catch((error) => {
                    console.error(error);
                })
                .finally(() => {
                    this.loading = false;
                });
        },
        getOrganizations() {
            axios
                .get("/api/members/organizations")
                .then((res) => {
                    this.organizations = res.data;
                })
                .catch((error) => {
                    console.error(error);
                });
        },
        sendInfo(id) {
            this.memberId = id;
            console.log("Member ID", id);
            // this.selectedUser = item;
        },
        checkFormValidity() {
            const valid = this.$refs.form.checkValidity();
            this.nameState = valid;
            return valid;
        },
        resetModal() {
            this.structure_change_charge = 0;
        },
        handleOk(bvModalEvt) {
            // Prevent modal from closing
            bvModalEvt.preventDefault();
            // Trigger submit handler
            this.handleSubmit();
        },
        handleSubmit() {
            // Exit when the form isn't valid
            if (!this.checkFormValidity()) {
                return;
            }
            // Push the name to submitted names
            // this.submittedNames.push(this.name)
            this.updateMember();
        },
        updateMember() {
            let myForm = document.getElementById("structure-change-charge-form");
            let formData = new FormData(myForm);
            axios
                .post("/api/renew_member/set_company_structure_charge/" + this.memberId, formData)
                .then((res) => {
                    // console.log(res.data)
                    this.reset();
                    // this.success = res.data;
                    this.getMembers();
                    // this.$router.push({ name: "registration", query: { success: this.success } });
                })
                .catch((error) => {
                    if (error.response.status == 422) {
                        this.validationErrors = error.response.data.errors;
                    } else {
                        this.warning_message = error.response.data.message;
                    }
                })
                .finally(() => {
                    this.$nextTick(() => {
                        this.$bvModal.hide("modal-member-approval1");
                    });
                });
        },
        getMembers() {
            this.loading = true;
            axios
                // .get('/api/members/renewal')
                .get("/api/structure_member")
                .then((res) => {
                    this.members = res.data;
                    this.totalRows = this.members.length;
                })
                .catch((error) => {
                    console.error(error.response.data.message);
                })
                .finally(() => {
                    this.loading = false;
                });
        },
        updateCompanyName(id) {
            if (confirm("Do you really want to Change Company Name?")) {
                axios
                    .get("/api/renew_member/change_company_name/" + id )
                    .then((res) => {
                        // this.showMessage = true;
                        this.success = res.data;
                        this.getMembers();
                    })
                    .catch((error) => {
                        console.error(error.response.data.message);
                    });
            }
        },
        approveMember(id) {
            if (confirm("Do you really want to Approve Membership Renewal Application?")) {
                axios
                    .get("/api/renew_member/approveMember/" + id)
                    .then((res) => {
                        // this.showMessage = true;
                        this.success = res.data;
                        this.getMembers();
                    })
                    .catch((error) => {
                        console.error(error.response.data.message);
                    });
            }
        },
        activeMember(id) {
            if (confirm("Do you really want to Active Membership Renewal Application?")) {
                axios
                    .get("/api/renew_member/activeMember/" + id)
                    .then((res) => {
                        // this.showMessage = true;
                        this.success = res.data;
                        this.getMembers();
                    })
                    .catch((error) => {
                        console.error(error.response.data.message);
                    });
            }
        },
        deleteMember(id) {
            if (confirm("Do you really want to delete Membership Renewal Application?")) {
                axios
                    .delete("/api/renew_member/" + id)
                    .then((res) => {
                        // this.showMessage = true;
                        this.success = res.data;
                        this.getMembers();
                    })
                    .catch((error) => {
                        console.error(error.response.data.message);
                    });
            }
        },
        reset: function () {
            this.validationErrors = null;
            this.success = "Membership Structural Charge Set Successfully";
            // this.form = Object.assign({}, initFormData)
            // for(let field in this.formData){
            //     this.formData[field] = null;
            // }
        },
    },
};
</script>

<style scoped>
table#table-transition-example .flip-list-move {
    transition: transform 1s;
}

.card-body {
    /* Components Root Element ID */
    position: relative;
}

.card-body #loader {
    /* Loader Div Class */
    position: absolute;
    top: 0px;
    right: 0px;
    width: 100%;
    height: 100%;
    background-color: #eceaea;
    background-size: 50px;
    background-repeat: no-repeat;
    background-position: center;
    z-index: 10000000;
    opacity: 0.4;
    filter: alpha(opacity=40);
}
</style>
