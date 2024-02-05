<template>
    <div>
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-evenly" v-if="pending_count == 0">
                    <div class="p-2">
                        <router-link
                            :disabled="true"
                            :to="{ name: 'renew-member-for-member' }"
                            class="btn btn-secondary">Membership Renewal</router-link>
                    </div>
                    <div class="p-2">
                        <router-link
                            :disabled="true"
                            :to="{ name: 'structure-change' }"
                            class="btn btn-secondary">Membership Structural Change</router-link>
                    </div>
                </div>
<!--                <span></span>-->
                <div class="alert alert-warning" role="alert" v-else>
                    Before Previous Application Approval, New Application will prohibited
                    <div class="d-flex justify-content-evenly">
                        <button disabled>Renew Membership</button>
                        <button disabled>Membership Structural Change</button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div
                    id="loader"
                    v-if="loading"
                    v-bind:style="{
            backgroundImage: 'url(' + addProjectPath('/assets/img/ajax-loader.gif') + ')',
          }"
                ></div>
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
                            <router-link
                                :to="{
                                      name: 'view-renewal-member-for-member',
                                      params: { id: row.item.id },
                                    }"
                                class="btn btn-link"
                            >
                                {{ row.value }}
                            </router-link>
                            <!--                            <a :href="addProjectPath('/profile/member/'+row.item.id)">-->
                            <!--                                {{ row.value }}-->
                            <!--                            </a>-->
                        </template>
                        <template #cell(firm_type)="row">
                            {{ row.value === 'Proprietor'
                            ? 'Proprietorship'
                            : row.value === 'Partners' ? 'Partnership' : 'Limited Company'}}
                        </template>
                        <template #cell(structure_change)="row">
                            {{ row.value == '1' ? 'Yes' : 'No' }}
                        </template>
                        <template #cell(status)="row">
              <span
                  v-bind:class="[
                  row.value === 'Accepted'
                    ? 'badge-success'
                    : row.value === 'Banned'
                    ? 'badge-danger'
                    : 'badge-warning',
                  'badge badge-lg bg-secondary',
                ]"
              >
                {{ row.value }}
              </span>
                        </template>
                        <template #cell(actions)="row">
                            <span>
                                <router-link
                                    :to="{ name: 'renewal-company-owners-for-member', params: { id: row.item.id } }"
                                    class="btn btn-icon edit"
                                    title="Owners"
                                    data-toggle="tooltip"
                                    data-placement="top"
                                ><i class="fas fa-user-plus"></i>
                            </router-link>
                            </span>
                        </template>
                    </b-table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import ValidationErrors from "../ValidationErrors";
import vSelect from "vue-select";

export default {
    name: "AllRenewalForMembers",
    components: {ValidationErrors, vSelect},
    props: ["is_member",'warning_message'],
    data: () => ({
        pending_count: 0,
        member: null,
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
        fields: ["firm_name", "firm_type", "type_local", {key: "structure_change", label: 'Structure Form'},{key: "submission_year", label: 'Year'}, "status", "actions"],
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
        if (window.Laravel.isLoggedin) {
            this.isLoggedIn = true;
            this.member = window.Laravel.user;
            // this.member_name = window.Laravel.user.email
            this.getMembers()
        } else {
            console.log('Member Not Log In')

        }
    },
    computed: {
        exactFirmName: function (name) {
            return name === 'Proprietor'
                ? 'Proprietorship'
                : row.value == 'Partners' ? 'Partnership' : 'Limited Company';
        },
    },
    methods: {
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
            this.file1 = null;
            this.nameState = null;
            this.selected = [];
        },
        resetPrivilegeModal() {
            const mem = this.members.find((member) => member.id === this.memberId);
            if (mem.privileges) {
                const pri = mem.privileges.map((x) => x.id);
                this.selected = pri;
            }
            // console.log(mem)
        },
        getMembers() {
            this.loading = true;
            axios
                // .get('/api/members/renewal')
                .get('/api/renew_member?member_id=' + this.member.id)
                .then((res) => {
                    this.pending_count = res.data.pending_count;
                    this.members = res.data.renew_members;
                    this.totalRows = this.members.length;
                })
                .catch((error) => {
                    console.error(error.response.data.message);
                })
                .finally(() => {
                    this.loading = false;
                });
        }
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
