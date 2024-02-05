<template>
    <div>

        <div class="card">
            <div class="card-body">
                <div id="loader" v-if="loading"
                     v-bind:style="{'backgroundImage': 'url(' + addProjectPath('/assets/img/ajax-loader.gif') + ')'}"></div>
                <b-row v-if="false">
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
                <br>
                <div class="table-responsive" id="users-table-wrapper">
                    <validation-errors :errors="validationErrors" :success="success"
                                       :warning_message="warning_message"></validation-errors>
                    <table class="table table-dark">
                        <thead>
                        <tr>
                            <th scope="col">Non Verified ID Card#</th></tr>
                        </thead>
                    </table>
                    <b-table striped hover small show-empty responsive
                             id="table-transition-example"
                             primary-key="id"
                             :items="verifications.noVerified"
                             :fields="fields"
                             :tbody-transition-props="transProps"
                             :busy.sync="isBusy"
                    >
                        <template #cell(card_holder_photograph_attachment)="row">
                            <a :href="assetPath('/'+row.value)" target="_blank">
                                <img :src="assetPath('/'+row.value)" alt="" width="50" height="50">
                            </a>

                            <!--                            <router-link :to="{name: 'view-id-card',params: { id: row.item.id }}" class="btn btn-link">-->
                            <!--                                {{ row.value }}-->
                            <!--                            </router-link>-->
                        </template>
                        <template #cell(organizations)="row">
                            <ul>
                                <li v-for="organization_name in row.value">
                                    {{ organization_name }}
                                </li>
                            </ul>
                        </template>
                        <template #cell(police_verification)="row">
                            <span v-if="row.item.police_verification_attachment">
                                <a :href="assetPath('/'+row.item.police_verification_attachment)" target="_blank">
                                {{ row.value }}
                                </a>
                            </span>
                            <span v-else>{{ row.value }}</span>
                        </template>
                        <template #cell(attachment_name)="row">
                            <span v-if="row.item.attachment_file">
                                <a :href="assetPath('/'+row.item.attachment_file)" target="_blank">
                                {{ row.value }} No:<br>{{ row.item.attachment_number }}
                                </a>
                            </span>
                            <span v-else>{{ row.value }} No:<br>{{ row.item.attachment_number }}</span>
                        </template>
                        <template #cell(status)="row">
                            <span class="badge bg-secondary"><strong>{{ row.value }}</strong></span>
                            <!--                            <div class="alert alert-success"></div>-->
                        </template>
                        <template #cell(comment)="row">
                            <div style="white-space: pre-line">{{ row.value }}</div>
                        </template>
                        <template #cell(card_holder_name)="row">
                            <router-link
                                :to="{name: 'member-view-id-card',params: { id: row.item.id }}"
                                class="btn btn-link"
                            >{{ row.value }}</router-link>
                        </template>
                        <template #cell(actions)="row">
                            <!--                                <router-link-->
                            <!--                                    :to="{name: 'member-view-id-card',params: { id: row.item.id }}"-->
                            <!--                                    class="btn btn-info"-->
                            <!--                                    title="Details"-->
                            <!--                                    data-toggle="tooltip" data-placement="top"-->
                            <!--                                ><i class="fas fa-eye mr-2"></i></router-link>-->
                                <div
                                    v-if="row.item.status === 'Selection' || row.item.status === 'Accepted' || row.item.status === 'Decline' "
                                    class="btn-group">
                                    <b-button
                                        @click="acceptIdCard(row.item.id)"
                                        class="btn btn-success btn-sm text-white"
                                        style="font-size: 18px;padding: 11px;"> &#10003;
                                    </b-button>
                                    <b-button
                                        @click="declineIdCard(row.item.id)"
                                        class="btn btn-danger btn-sm text-white" style="font-size: 18px;padding: 11px;">
                                        &#10539;
                                    </b-button>
                                </div>
                            <router-link v-else-if="row.item.status === 'Editable'"
                                         :to="{name: 'member-edit-id-card',params: { id: row.item.id }}"
                                         class="btn btn-danger"
                                         title="Edit"
                                         data-toggle="tooltip" data-placement="top"
                            >Edit
                            </router-link>
                        </template>
                    </b-table>
                    <div v-for="verification in verifications.verified">
                        <table class="table table-dark">
                            <thead>
                            <tr>
                                <th scope="col">
                                    Required: {{ verification.verification_required }}
                                    [ {{ verification.verification_date }} ]
                                </th>
                                <th scope="col">
                                    Accept: {{ verification.verification_accept }}
                                    [ {{ verification.approved_date }} ]
                                </th>
                            </tr>
                            </thead>
                        </table>


<!--                        <table class="table table-dark">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Count</th>
                                <th scope="col">Date</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <th scope="col">Required</th>
                                <td>{{ verification.verification_required }}</td>
                                <td>{{ verification.verification_date }}</td>
                            </tr>
                            <tr>
                                <th scope="col">Accept</th>
                                <td>{{ verification.verification_accept }}</td>
                                <td>{{ verification.approved_date }}</td>
                            </tr>
                            </tbody>
                        </table>-->
<!--                        <h1>{{ verification.id }}</h1>-->
                        <b-table striped hover small show-empty responsive
                                 id="table-transition-example"
                                 primary-key="id"
                                 :items="verification.id_cards"
                                 :fields="fields"
                                 :tbody-transition-props="transProps"
                                 :busy.sync="isBusy"
                        >
                            <template #cell(card_holder_photograph_attachment)="row">
                                <a :href="assetPath('/'+row.value)" target="_blank">
                                    <img :src="assetPath('/'+row.value)" alt="" width="50" height="50">
                                </a>

                                <!--                            <router-link :to="{name: 'view-id-card',params: { id: row.item.id }}" class="btn btn-link">-->
                                <!--                                {{ row.value }}-->
                                <!--                            </router-link>-->
                            </template>
                            <template #cell(organizations)="row">
                                <ul>
                                    <li v-for="organization_name in row.value">
                                        {{ organization_name }}
                                    </li>
                                </ul>
                            </template>
                            <template #cell(police_verification)="row">
                            <span v-if="row.item.police_verification_attachment">
                                <a :href="assetPath('/'+row.item.police_verification_attachment)" target="_blank">
                                {{ row.value }}
                                </a>
                            </span>
                                <span v-else>{{ row.value }}</span>
                            </template>
                            <template #cell(attachment_name)="row">
                            <span v-if="row.item.attachment_file">
                                <a :href="assetPath('/'+row.item.attachment_file)" target="_blank">
                                {{ row.value }} No:<br>{{ row.item.attachment_number }}
                                </a>
                            </span>
                                <span v-else>{{ row.value }} No:<br>{{ row.item.attachment_number }}</span>
                            </template>
                            <template #cell(status)="row">
                                <span class="badge bg-secondary"><strong>{{ row.value }}</strong></span>
                                <!--                            <div class="alert alert-success"></div>-->
                            </template>
                            <template #cell(comment)="row">
                                <div style="white-space: pre-line">{{ row.value }}</div>
                            </template>
                            <template #cell(card_holder_name)="row">
                                <router-link
                                    :to="{name: 'member-view-id-card',params: { id: row.item.id }}"
                                    class="btn btn-link"
                                >{{ row.value }}</router-link>
                            </template>
                            <template #cell(actions)="row">
                                <router-link v-if="row.item.status === 'Editable'"
                                             :to="{name: 'member-edit-id-card',params: { id: row.item.id }}"
                                             class="btn btn-danger"
                                             title="Edit"
                                             data-toggle="tooltip" data-placement="top"
                                >Edit
                                </router-link>
<!--                                <router-link-->
<!--                                    :to="{name: 'member-view-id-card',params: { id: row.item.id }}"-->
<!--                                    class="btn btn-info"-->
<!--                                    title="Details"-->
<!--                                    data-toggle="tooltip" data-placement="top"-->
<!--                                ><i class="fas fa-eye mr-2"></i></router-link>-->
                                <div v-if="verification.is_payment == 0">
                                    <div
                                        v-if="row.item.status === 'Selection' || row.item.status === 'Accepted' || row.item.status === 'Decline' "
                                        class="btn-group">
                                        <b-button
                                            @click="acceptIdCard(row.item.id)"
                                            class="btn btn-success btn-sm text-white"
                                            style="font-size: 18px;padding: 11px;"> &#10003;
                                        </b-button>
                                        <b-button
                                            @click="declineIdCard(row.item.id)"
                                            class="btn btn-danger btn-sm text-white" style="font-size: 18px;padding: 11px;">
                                            &#10539;
                                        </b-button>
                                    </div>
                                </div>
                                <div v-if="row.item.status_code > 9 ? true : false" class="btn-group">
                                    <span v-if="row.item.id_card_cancel == null">
                                        <router-link
                                                     :to="{name: 'cancel-id-card-form',params: { id: row.item.id, panel: 'new' }}"
                                                     class="btn btn-light btn-sm" >Cancel</router-link>
                                        <router-link
                                            :to="{name: 'reissue-id-card-form',params: { id: row.item.id, panel: 'new' }}"
                                            class="btn btn-light btn-sm" >ReIssue</router-link>
                                    </span>
                                </div>
                            </template>
                        </b-table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import ValidationErrors from "../ValidationErrors";

export default {
    name: "MemberAllIdCard",
    components: {ValidationErrors},
    data: () => ({
        isLoggedIn: false,
        member: null,
        loading: false,
        memberId: null,
        verifications: [],
        errors: [],
        validationErrors: null,
        success: '',
        warning_message:'',
        approval_image: null,
        comment: null,
        nameState: null,
        selected: [],
        isBusy: false,
        totalRows: 1,
        currentPage: 1,
        perPage: 5,
        pageOptions: [5, 10, 15, {value: 100, text: "Show a lot"}],
        transProps: {
            // Transition name
            name: 'flip-list'
        },
        fields: [
            {
                key: 'card_holder_photograph_attachment',
                label: 'Photo',
                // thStyle: { width: "30%" },
            },
            'card_holder_name',
            // {
            //     key:'card_holder_designation',
            //     label:'Designation'
            // }
            // ,'organizations',
            'created_at', 'id_card_number', 'comment',
            // {
            //     key: 'attachment_name',
            //     label: 'Attachment'
            // },'police_verification',
            'status', 'actions'],
        options: [
            {value: 'login', text: 'Login Access', disabled: true},
            {value: '1', text: 'Gate Pass'},
            {value: '2', text: 'ID Card'}
        ]
    }),
    watch: {
        file1() {
            this.nameState = !!this.file1; // if File, then return false
        }
    },
    created() {
        if (window.Laravel.isLoggedin) {
            this.isLoggedIn = true;
            this.member = window.Laravel.user;
            this.getMembers();
        } else {
            console.log('Member Not Log In')
        }
    },
    methods: {
        sendInfo(id) {
            this.memberId = id
            console.log('Member ID', id)
            // this.selectedUser = item;
        },
        acceptIdCard(id) {
            if (confirm("Do you really want to Accept ?")) {
                axios.put("/api/id_cards/id_card_choose_by_member/" + id, {acception: true}).then(res => {
                    // console.log(res.data)
                    this.getMembers();
                    // this.$router.push({ name: "registration", query: { success: this.success } });
                }).catch(error => {
                    if (error.response.status == 422) {
                        this.validationErrors = error.response.data.errors;
                    } else {
                       this.warning_message = error.response.data.message;
                    }
                });
            }
            // console.log('ID Card ID', id)
        },
        declineIdCard(id) {
            if (confirm("Do you really want to Decline ?")) {
                axios.put("/api/id_cards/id_card_choose_by_member/" + id, {acception: false}).then(res => {
                    // console.log(res.data)
                    this.getMembers();
                    // this.$router.push({ name: "registration", query: { success: this.success } });
                }).catch(error => {
                    if (error.response.status == 422) {
                        this.validationErrors = error.response.data.errors;
                    } else {
                       this.warning_message = error.response.data.message;
                    }
                });
            }
            // console.log('ID Card ID', id)
        },
        getMembers() {
            this.loading = true
            axios
                .get('/api/member_id_cards/' + this.member.id)
                .then(res => {
                    this.verifications = res.data
                    // this.members = res.data.data
                    // this.totalRows = this.members.length
                }).catch(error => {
                console.error(error.response.data.message)
            }).finally(() => {
                this.loading = false
            });
        }
    }
}
</script>

<style scoped>
.table td {
    white-space: pre-line !important;
}

table#table-transition-example .flip-list-move {
    transition: transform 1s;
}

.card-body { /* Components Root Element ID */
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
