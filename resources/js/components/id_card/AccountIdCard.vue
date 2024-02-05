<template>
    <div>

        <div class="card">
            <div class="card-body">
                <div id="loader" v-if="loading"
                     v-bind:style="{'backgroundImage': 'url(' + addProjectPath('/assets/img/ajax-loader.gif') + ')'}"></div>
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
                <br>
                <div class="table-responsive" id="users-table-wrapper">
                    <validation-errors :errors="validationErrors" :success="success"
                                       :warning_message="warning_message"></validation-errors>

                    <b-table striped hover small show-empty
                             id="table-transition-example"
                             primary-key="id"
                             :items="verifications"
                             :fields="fields"
                             :current-page="currentPage"
                             :per-page="perPage"
                             :tbody-transition-props="transProps"
                             :busy.sync="isBusy"
                    >
                        <template #cell(organizations)="row">
                            <ul>
                                <li v-for="organization_name in row.value">
                                    {{ organization_name }}
                                </li>
                            </ul>
                        </template>
                        <template #cell(desired_id_card)="row">
                            <p>{{row.value}}</p>
                            <div class="table-responsive" style="width: 140px;">
                                <table class="table">
                                    <tr>
                                        <td v-for="id_card in row.item.id_cards.split(',')">
                                            <router-link
                                                :to="{name: 'view-id-card',params: { id: id_card }}"
                                                class="btn btn-info btn-sm text-white" >{{id_card}}</router-link>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td v-for="status in row.item.id_card_status.split(',')">
                                            {{positions[status]}}
                                        </td>
                                    </tr>
                                </table>
                            </div>
<!--                            <ul>-->
<!--                                <li v-for="id_card in row.item.id_cards.split(',')">-->
<!--                                    <router-link-->
<!--                                        :to="{name: 'id-card-print',params: { id: id_card }}" target="_blank"-->
<!--                                        class="btn btn-success btn-sm text-white" >{{id_card}}</router-link>-->
<!--                                    Status:-->
<!--                                </li>-->
<!--                            </ul>-->
                        </template>
                        <template #cell(total_amount)="row">
<!--                            <p>{{row.item.verification_accept * 1000}}</p>-->
<!--                            <p>{{row.item.membership_no.split(',').length * 1000}}</p>-->
                            <p>{{row.item.verification_accept_count * 1000}}</p>
                        </template>
                        <template #cell(actions)="row">
                            <div class="btn-group">
                                <div v-if="row.item.is_payment">
                                    <span class="badge bg-success p-2">PAID</span>
<!--                                        <router-link
                                            :to="{name: 'invoice',params: { id: row.item.money_collection_id }}"
                                            class="btn btn-icon"
                                            title="Invoice" target="_blank"
                                            data-toggle="tooltip" data-placement="top"
                                        ><i class="fas fa-download"></i>-->
<!--                                        </router-link>-->
                                    <a class="btn btn-light btn-sm" target="_blank" :href="addProjectPath('/print_money_receipt/'+ row.item.money_collection_id)">Print</a>
                                </div>
                                <div v-else>
                                    <b-button v-if="row.item.verification_accept_count > 0"
                                              v-b-modal.modal-member-note
                                              @click="sendInfo(row.item.id,row.item.member_id,row.item.verification_accept_count,row.item.form_year)"
                                              class="btn btn-info btn-sm text-white">
                                        Payment
                                    </b-button>
                                </div>
                            </div>
                        </template>
                    </b-table>
                </div>
                <b-modal
                    id="modal-member-note"
                    ref="modal"
                    title="Note For Manager"
                    @ok="handleOkNote"
                >
                    <form ref="form" @submit.stop.prevent="handleSubmitNote">
                        <b-form-group label="Receipt Details"  label-for="description">
                            <b-form-input id="description" v-model="form.description" ></b-form-input>
                        </b-form-group>
                        <b-form-group label="Mode of Receipt" label-for="payment_type" >
                            <b-form-select id="payment_type" v-model="payment_type" :options="payment_types"></b-form-select>
                        </b-form-group>
                        <div v-if="payment_type != 'Cash'">
                            <b-form-group label="P.O/D.D/Chq.No." label-for="payment_chq_no" >
                                <b-form-input id="payment_chq_no" v-model="payment_chq_no"
                                ></b-form-input>
                            </b-form-group>
                            <b-form-group label="P.O/D.D/Chq. Date" label-for="payment_chq_date" >
                                <!--                            <b-form-datepicker id="payment_chq_no" v-model="payment_chq_date"-->
                                <!--                            ></b-form-datepicker>-->
                                <datepicker input-class="form-control" name="payment_chq_date"
                                            v-model="payment_chq_date"/>
                            </b-form-group>
                            <b-form-group label="Bank" label-for="payment_bank" >
                                <b-form-input id="payment_bank" v-model="payment_bank"></b-form-input>
                            </b-form-group>
                        </div>
                    </form>
                </b-modal>
            </div>
        </div>
    </div>
</template>

<script>
import ValidationErrors from "../ValidationErrors";
import vSelect from "vue-select";
import Datepicker from "vuejs-datepicker";
import moment from "moment/moment";

export default {
    name: "AccountIdCard",
    components: {ValidationErrors,vSelect,Datepicker},
    data: () => ({
        positions: [
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
        ],
        loading: false,
        organizations: [],
        verifications: [],
        selected_bmn_no: null,
        errors: [],
        validationErrors: null,
        success: '',
        warning_message:'',
        approval_image: null,
        max: 1,
        validationVerification: true,
        verification_accept: 0,
        verification_accept_count:0,
        membership_no: 0,
        verification_required: 5,
        comment: null,
        nameState: null,
        selected: [],
        isBusy: false,
        totalRows: 1,
        currentPage: 1,
        perPage: 10,
        pageOptions: [10, 15, {value: 100, text: "Show a lot"}],
        transProps: {
            // Transition name
            name: 'flip-list'
        },
        fields: [
            {
                key: 'row_num',
                label: 'SL.No.'
            },'purpose', 'approved_date',
            {
                key: 'organization_name',
                label: 'Company Name'
            },{
                key: 'form_year',
                label: 'Year'
            },
            {
                key: 'desired_id_card',
                label: 'Desired ID card'
            },
            {
                key: 'verification_accept',
                label: 'Approved Quantity'
            },'total_amount','actions'],
        payment_types: [
            {value:'Cash',text:'Cash'},
            {value:'Cheque',text:'Cheque'},
            {value:'Pay order',text:'Pay order'}
        ],
        form:{
            verification_id: null,
            member_id:null,
            receipt_type:'id_card',
            receipt_year:'',
            amount:'id_card',
            description: '',

        },
        payment_type: 'Cash',
        payment_chq_no: '',
        payment_chq_date: new Date().toISOString().slice(0, 10),
        payment_bank: '',
        isLoggedIn:false,
        user:null,
    }),
    created() {
        this.getVerifications()
        this.getOrganizations()
        if (window.Laravel.isLoggedin) {
            this.isLoggedIn = true;
            this.user = window.Laravel.user;
            // this.member_name = window.Laravel.user.email
        }else{
            console.log('Member Not Log In')

        }
    },
    methods: {
        getOrganizations() {
            axios
                .get('/api/members/organizations')
                .then(res => {
                    this.organizations = res.data
                }).catch(error => {
                console.error(error)
            })
        },
        sendInfo(id,member_id,verification_accept,form_year) {
            this.nameState = null
            this.form.verification_id = id
            this.form.receipt_year = form_year
            this.form.member_id = member_id
            this.form.amount = verification_accept*1000
            this.form.description = 'ID Card - '+form_year+' ( '+verification_accept+' ) Pcs'
            console.log('Verification ID', id)
        },
        checkFormValidity() {
            const valid = this.$refs.form.checkValidity()
            this.nameState = valid
            return valid
        },
        handleOkNote(bvModalEvt) {
            bvModalEvt.preventDefault();
            this.handleSubmitNote();
        },
        handleSubmitNote() {
            if (!this.checkFormValidity()) {
                return
            }
            this.saveCollection();

            /*let formData = new FormData();
            formData.set('manager_note', this.note);
            axios.post("/api/id_cards/verification/manager_note/" + this.verification_id, formData).then(res => {
                console.log(res.data)
                this.reset();
                this.getVerifications();
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
            });*/
        },
        saveCollection: function () {
            const data = new FormData();
            data.set('verification_id', this.form.verification_id);
            data.set('member_id', this.form.member_id);
            data.set('receipt_type', this.form.receipt_type);
            data.set('receipt_year', this.form.receipt_year);
            data.set('amount', this.form.amount);
            data.set('description', this.form.description);
            data.set('payment_type', this.payment_type);
            data.set('payment_chq_no', this.payment_chq_no);
            data.set('payment_chq_date', moment(this.payment_chq_date).format('YYYY-MM-DD'));
            data.set('payment_bank', this.payment_bank);
            data.set('created_user_id', this.user.id);
            axios.post("/api/money_collection", data).then(res => {
                this.success = 'Payment Saved Successfully';
                this.$router.push({name: "invoice", params: {id: res.data.id}});
                // this.$router.push({name: "all-collection", query: {success: this.success}});
            }).catch(error => {
                if (error.response.status == 422) {
                    this.validationErrors = error.response.data.errors;
                } else {
                   this.warning_message = error.response.data.message;
                }
            }).finally(() => {
                this.loading = false
            });
        },
        getVerifications() {
            this.loading = true
            axios
                .get('/api/accounts_id_cards')
                .then(res => {
                    this.verifications = res.data
                    this.totalRows = this.verifications.length
                }).catch(error => {
                    console.error(error.response)
            }).finally(() => {
                this.loading = false
            });
        },
        doFilter() {
            this.request_url = '/api/accounts_id_cards?' +
                'bmn_no=' + this.selected_bmn_no;
            this.loading = true
            axios.get(this.request_url)
                .then(res => {
                    this.verifications = res.data
                    this.totalRows = this.verifications.length
                }).catch(error => {
                console.error(error.response.data.message)
            }).finally(() => {
                this.loading = false
            });
        },
        reset: function () {
            this.payment_type = '';
            this.payment_chq_no = '';
            this.payment_chq_date = new Date().toISOString().slice(0, 10);
            this.payment_bank = '';
            this.form.description = '';
            this.validationErrors = null;
            this.success = 'Organization Payment Successfully';
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
