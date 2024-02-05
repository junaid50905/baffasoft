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

                    <b-table striped hover small show-empty
                             id="table-transition-example"
                             primary-key="id"
                             :items="verifications"
                             :fields="fields"
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
                        <template #cell(total_amount)="row">
                            <p>{{row.item.verification_accept * 1000}}</p>
                        </template>
                        <template #cell(actions)="row">
                            <div class="btn-group">
                                <div v-if="row.item.is_payment">
                                    <span class="badge bg-success p-2">Paid</span>
                                        <router-link
                                            :to="{name: 'member-invoice',params: { id: row.item.money_collection_id }}"
                                            class="btn btn-icon"
                                            title="Invoice" target="_blank"
                                            data-toggle="tooltip" data-placement="top"
                                        ><i class="fas fa-download"></i>
                                        </router-link>
                                </div>
                                <div v-else>
                                    <span class="badge bg-secondary p-2">UnPaid</span>
                                </div>
                            </div>
                        </template>
                    </b-table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import ValidationErrors from "../ValidationErrors";

export default {
    name: "MemberIdCardReceipt",
    components: {ValidationErrors},
    data: () => ({
        loading: false,
        verifications: [],
        errors: [],
        validationErrors: null,
        success: '',
        warning_message:'',
        approval_image: null,
        max: 1,
        validationVerification: true,
        verification_accept: 0,
        verification_required: 5,
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
                key: 'row_num',
                label: 'SL. No.',
                thClass: "whiteSpace"
            },'purpose',
            {
                key:'approved_date',
                thClass: "whiteSpace"
            },
            {
                key: 'desired_id_card',
                label: 'Desired'
            },
            {
                key: 'verification_accept',
                label: 'Approved Quantity',
                thClass: "whiteSpace"
            },
            {
                key: 'total_amount',
                thClass: "whiteSpace"
            },'actions'],
        payment_types: [
            {value:'Cash',text:'Cash On hand'},
            {value:'Cheque',text:'Cheque'},
            {value:'Pay order',text:'Pay order'}
        ],
        form:{
            verification_id: null,
            member_id:null,
            receipt_type:'id_card',
            amount:'id_card',
            description: '',

        },
        payment_type: 'Cash',
        payment_chq_no: '',
        payment_bank: '',
        isLoggedIn:false,
        user:null,
    }),
    created() {
        if (window.Laravel.isLoggedin) {
            this.isLoggedIn = true;
            this.member = window.Laravel.user;
            this.getVerifications();
            // this.member_name = window.Laravel.user.email
        }else{
            console.log('Member Not Log In')
        }
    },
    methods: {
        getVerifications() {
            this.loading = true
            axios
                .get('/api/member_id_card_receipts/'+this.member.id)
                .then(res => {
                    this.verifications = res.data
                    this.totalRows = this.verifications.length
                }).catch(error => {
                    console.error(error.response)
            }).finally(() => {
                this.loading = false
            });
        }
    }
}
</script>
<style>
.whiteSpace{
    white-space: normal !important;
    width: 1%;
}
</style>
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
