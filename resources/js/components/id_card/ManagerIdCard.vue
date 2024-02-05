<template>
    <div>

        <div class="card">
            <div class="card-body">
                <div id="loader" v-if="loading"
                     v-bind:style="{'backgroundImage': 'url(' + addProjectPath('/assets/img/ajax-loader.gif') + ')'}"></div>
                <br>

                <div class="table-responsive" id="users-table-wrapper">
                    <validation-errors :errors="validationErrors" :success="success"
                                       :warning_message="warning_message"></validation-errors>
                    <b-row>
                        <b-col md="10" class="my-1">
                            <v-select
                                placeholder="Select Member Name"
                                v-model="selected_bmn_no"
                                :options="organizations"
                                :reduce="organizations => organizations.username"
                                label="organization_name"></v-select>
                            <!--                            <v-select v-model="selected" @input="setSelected" :options="options" @search="fetchOptions"></v-select>-->
                            <!--                            @input="setSelected"-->
                        </b-col>
                        <b-col sm="2" md="2" class="my-1">
                            <div class="d-grid gap-2">
                                <b-button size="sm" @click="doFilter">Generate Report
                                </b-button>
                            </div>
                        </b-col>
                    </b-row>
                    <b-table striped hover small show-empty
                             id="table-transition-example"
                             primary-key="id"
                             :items="members"
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
                                {{ row.value }}<br>{{ row.item.attachment_number }}
                                </a>
                            </span>
                            <span v-else>{{ row.value }}<br>{{ row.item.attachment_number }}</span>
                        </template>
                        <template #cell(verification_accept)="row">
                            <input type="number" min="0" :max="row.item.desired_id_card" style="width:50px" class="verificationAccept" :data-id="row.item.id"
                                   :data-verification_required="row.item.desired_id_card">
                        </template>
                        <template #cell(actions)="row">
                            <b-button
                                v-b-modal.modal-member-approval
                                @click="sendInfo(row.item.id)"
                                variant="icon"
                                class="btn btn-icon edit"><i class="fas fa-user-edit"></i></b-button>
                            <!--                            <b-button-->
                            <!--                                v-b-modal.modal-make-payment-->
                            <!--                                @click="sendInfo({'id':row.item.id,'member_id':row.item.member_id,'balance_amount':row.item.balance_amount})"-->
                            <!--                                variant="icon"-->
                            <!--                                title="Create payment"-->
                            <!--                                data-toggle="tooltip" data-placement="top"><i-->
                            <!--                                class="fas fa-money-bill-alt text-success"></i>-->
                            <!--                            </b-button>-->
                            <router-link
                                :to="{name: 'view-id-card',params: { id: row.item.id }}"
                                class="btn btn-icon"
                                title="View"
                                data-toggle="tooltip" data-placement="top"
                            ><i class="fas fa-eye" v-bind:class="{ 'text-danger': !row.item.print_times }"></i>
                            </router-link>
                        </template>
                        <template #cell(actions)="row">
                            <div class="btn-group">
                                <b-button
                                    v-b-modal.modal-member-note
                                    @click="sendInfo(row.item.id)"
                                    class="btn btn-info btn-sm text-white">Note
                                </b-button>
                                <!--                                <b-button-->
                                <!--                                    v-b-modal.modal-member-message-->
                                <!--                                    @click="sendInfo(row.item.id)"-->
                                <!--                                    class="btn btn-dark btn-sm text-white">Message</b-button>-->
<!--                                <b-button
                                    v-b-modal.modal-member-verify
                                    @click="sendVerificationInfo(row.item.id,row.item.desired_id_card)"
                                    class="btn btn-success btn-sm text-white">Verify
                                </b-button>-->
                            </div>
                        </template>
                    </b-table>
                    <div v-if="role == 1 || username == 'dir1.baffa'">
                        <b-button v-if="members.length" block variant="primary" @click.prevent="verificationInfo">Approve</b-button>
                    </div>
                </div>
                <b-modal
                    id="modal-member-verify"
                    ref="modal"
                    title="Accepted ID Card"
                    @show="resetModal"
                    @hidden="resetModal"
                    @ok="handleOkVerify"
                >
                    <div class="alert alert-info">
                        Total Desired ID card in 2022: <span
                        class="badge badge-light p-3">{{ verification_required }}</span>
                    </div>
                    <!--                    <div class="alert alert-info">-->
                    <!--                        Total Desired ID card in 2022: <strong><span class="badge badge-secondary">{{verification_required}}</span></strong>.-->
                    <!--                    </div>-->
                    <hr>
                    <form ref="form" @submit.stop.prevent="handleSubmitVerify">
                        <b-form-group
                            label="Accepted ID Card"
                            label-for="name-input"
                            invalid-feedback="Any Number is required"
                            :state="nameState"
                        >
                            <b-form-input
                                id="name-input"
                                v-model="verification_accept"
                                :state="nameState"
                                required
                                type="number" min="0" :max=this.verification_required
                            ></b-form-input>
                        </b-form-group>
                    </form>
                </b-modal>
                <b-modal
                    id="modal-member-note"
                    ref="modal"
                    title="Note For Manager"
                    @show="resetModal"
                    @hidden="resetModal"
                    @ok="handleOkNote"
                >
                    <form ref="form" @submit.stop.prevent="handleSubmitNote">
                        <b-form-group
                            label="Note"
                            label-for="name-input"
                            invalid-feedback="Note is required"
                            :state="nameState"
                        >
                            <b-form-input
                                id="name-input"
                                v-model="note"
                                :state="nameState"
                                required
                            ></b-form-input>
                        </b-form-group>
                    </form>
                </b-modal>
                <b-modal
                    id="modal-member-message"
                    ref="modal"
                    title="Message for Member"
                    @show="resetModal"
                    @hidden="resetModal"
                    @ok="handleOkMessage"
                >
                    <form ref="form" @submit.stop.prevent="handleSubmitMessage">
                        <b-form-group
                            label="Message"
                            label-for="name-input"
                            invalid-feedback="Message is required"
                            :state="nameState"
                        >
                            <b-form-input
                                id="name-input"
                                v-model="memberMessage"
                                :state="nameState"
                                required
                            ></b-form-input>
                        </b-form-group>
                    </form>
                </b-modal>
            </div>
        </div>
    </div>
</template>

<script>
import ValidationErrors from "../ValidationErrors";
import vSelect from "vue-select";

export default {
    name: "ManagerIdCards",
    props: { role: Number, username: String },
    components: {ValidationErrors,vSelect},
    data: () => ({
        loading: false,
        memberId: null,
        members: [],
        errors: [],
        organizations: [],
        validationErrors: null,
        success: '',
        warning_message:'',
        selected_bmn_no: null,
        approval_image: null,
        note: '',
        max: 1,
        dataObj: null,
        validationVerification: true,
        verification_accept: 0,
        verification_required: 5,
        memberMessage: '',
        comment: null,
        nameState: null,
        selected: [],
        isBusy: false,
        transProps: {
            // Transition name
            name: 'flip-list'
        },
        fields: [
            {
                key: 'row_num',
                label: 'SL.No.'
            },
            {
                key: 'verification_date',
                label: 'V.Date'
            },
            {
                key: 'organization_name',
                label: 'Company Name'
            },
            {
                key: 'gate_pass_count',
                label: 'Last Year Gate Pass'
            }, {
                key: 'previous_year_id_card',
                label: 'Obtained Last Year'
            }, {
                key: 'current_year_id_card',
                label: 'Obtained'
            }, {
                key: 'desired_id_card',
                label: 'Desired'
            },
            {key:'form_year',label:'Year'},
            // 'verification_required',
            {
                key: 'verification_accept',
                label: 'Accepted'
            },
            {
                key: 'manager_note',
                label: 'Note'
            },
            // 'member_message',
            'actions'],
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
        this.getMembers()
        this.getOrganizations()
    },
    methods: {
        doFilter() {
            this.loading = true
            axios
                .get('/api/id_cards/manager/report?bmn_no=' + this.selected_bmn_no)
                .then(res => {
                    this.members = res.data
                }).catch(error => {
                console.error(error.response.data.message)
            }).finally(() => {
                this.loading = false
            });
        },
        getOrganizations() {
            axios
                .get('/api/members/organizations')
                .then(res => {
                    this.organizations = res.data
                }).catch(error => {
                console.error(error)
            })
        },
        sendInfo(id) {
            this.memberId = id
            console.log('Member ID', id)
            // this.selectedUser = item;
        },
        sendVerificationInfo(id, desired_id_card) {
            this.memberId = id
            this.verification_required = desired_id_card
            this.verification_accept = 0
            console.log('Member ID', id)
            // this.selectedUser = item;
        },
        verificationInfo() {
            this.validationVerification = true
            this.dataObj = []
            let allValues = document.querySelectorAll('.verificationAccept');
            allValues.forEach((member) => {
                let verification_id = member.getAttribute('data-id');
                let verification_required = member.getAttribute('data-verification_required');
                let verification_accept = member.value;
                if (verification_accept !== "" && verification_required > 0 && verification_id !== "") {
                    // if (this.validationVerification)
                        this.dataObj.push({verification_id, verification_required, verification_accept});
                }
                // else
                //     this.validationVerification = false

            });
            // if (this.validationVerification) {
                // console.log(this.dataObj);
                axios.post("/api/id_cards/verification/accepts_by_director",
                    {verification: JSON.stringify(this.dataObj)}).then(res => {
                    // console.log(res.data)
                    this.reset();
                    this.getMembers();
                    // this.$router.push({ name: "registration", query: { success: this.success } });
                }).catch(error => {
                    if (error.response.status == 422) {
                        this.validationErrors = error.response.data.errors;
                    } else {
                       this.warning_message = error.response.data.message;
                    }
                });
            // } else {
            //     alert('Please Fill-up all Accepted ID Card')
            // }
        },
        checkFormValidity() {
            const valid = this.$refs.form.checkValidity()
            this.nameState = valid
            return valid
        },
        resetModal() {
            this.file1 = null
            this.nameState = null
            this.selected = []
        },
        resetPrivilegeModal() {
            const mem = this.members.find(member => member.id === this.memberId)
            if (mem.privileges) {
                const pri = mem.privileges.map(x => x.id)
                this.selected = pri
            }
            // console.log(mem)
        },
        handleOkVerify(bvModalEvt) {
            // Prevent modal from closing
            bvModalEvt.preventDefault()
            // Trigger submit handler
            this.handleSubmitVerify()
        },
        handleOkNote(bvModalEvt) {
            bvModalEvt.preventDefault();
            this.handleSubmitNote();
        },
        handleOkMessage(bvModalEvt) {
            bvModalEvt.preventDefault();
            this.handleSubmitMessage();
        },

        handleSubmitNote() {
            if (!this.checkFormValidity()) {
                return
            }
            let formData = new FormData();
            formData.set('manager_note', this.note);
            axios.post("/api/id_cards/verification/manager_note/" + this.memberId, formData).then(res => {
                console.log(res.data)
                this.reset();
                this.getMembers();
            }).catch(error => {
                if (error.response.status == 422) {
                    this.validationErrors = error.response.data.errors;
                } else {
                   this.warning_message = error.response.data.message;
                }
            }).finally(() => {
                this.$nextTick(() => {
                    this.$bvModal.hide('modal-member-note')
                })
            });
        },
        handleSubmitMessage() {
            if (!this.checkFormValidity()) {
                return
            }
            let formData = "member_message=" + this.memberMessage
            axios.put("/api/id_cards/verification/member_message/" + this.memberId, formData, {}).then(res => {
                this.reset();
                this.getMembers();
            }).catch(error => {
                if (error.response.status == 422) {
                    this.validationErrors = error.response.data.errors;
                } else {
                   this.warning_message = error.response.data.message;
                }
            }).finally(() => {
                this.$nextTick(() => {
                    this.$bvModal.hide('modal-member-message')
                })
            });

        },
        handleSubmitVerify() {
            // Exit when the form isn't valid
            if (!this.checkFormValidity()) {
                return
            }
            // Push the name to submitted names
            // this.submittedNames.push(this.name)
            this.updateMemberVerify();

        },
        /*updateMemberVerify() {
            let formData = new FormData();
            formData.set('verification_required', this.verification_required);
            formData.set('verification_accept', this.verification_accept);
            axios.post("/api/id_cards/verification/accept_by_director/" + this.memberId, formData, {}).then(res => {
                console.log(res.data)
                this.reset();
                this.getMembers();
            }).catch(error => {
                if (error.response.status == 422) {
                    this.validationErrors = error.response.data.errors;
                } else {
                    this.warning_message = error.response.data.message;
                }
            }).finally(() => {
                this.$nextTick(() => {
                    this.$bvModal.hide('modal-member-verify')
                })
            });
        },*/
        getMembers() {
            console.log('Name:'+this.username)
            this.loading = true
            axios
                .get('/api/id_cards/manager/report')
                .then(res => {
                    this.members = res.data
                }).catch(error => {
                console.error(error.response.data.message)
            }).finally(() => {
                this.loading = false
            });
        },
        reset: function () {
            this.comment = null;
            this.note = '';
            this.memberMessage = '';
            this.verification_accept = 0;
            this.verification_required = 0;
            this.validationErrors = null;
            this.dataObj = null,
            this.success = 'Member Validation Successfully';
            // this.form = Object.assign({}, initFormData)
            // for(let field in this.formData){
            //     this.formData[field] = null;
            // }
        }
    }
}
</script>

<style scoped>
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
