<template>
    <div>

        <div class="card">
            <div class="card-body">
                <div id="loader" v-if="loading" v-bind:style="{'backgroundImage': 'url(' + addProjectPath('/assets/img/ajax-loader.gif') + ')'}" ></div>
                <div class="table-responsive" id="users-table-wrapper">
                    <validation-errors :errors="validationErrors" :success="success"
                                       :warning_message="warning_message"></validation-errors>
                    <b-row>
                        <b-col sm="5" md="5" class="my-1">
                            <input type="text" class="form-control form-control-sm"  name="search_receipt_number" v-model="search_receipt_number">
                        </b-col>
                        <b-col sm="5" md="5" class="my-1">
<!--                            <label for="receipt_type" class="form-label">Money Receipt Type of Fields</label>-->
                            <b-select v-model="search_receipt_type" :options="options"></b-select>
<!--                            <datepicker input-class="form-control form-control-sm" name="seconded_by_date"-->
<!--                                        v-model="end_date" />-->
                        </b-col>
                        <b-col sm="2" md="2" class="my-1">
                            <div class="d-grid gap-2">
                                <b-button size="sm" @click="doFilter">Search</b-button>
                            </div>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col sm="12" md="12" class="my-1">
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
                    <b-table striped hover small show-empty
                             id="table-transition-example"
                             primary-key="receipt_no"
                             :items="members"
                             :fields="fields"
                             :current-page="currentPage"
                             :per-page="perPage"
                             :busy.sync="isBusy"
                    >
<!--                        <template #cell(sl_no)="data">-->
<!--                            {{ data.index + 1 }}-->
<!--                        </template>-->
                        <template #cell(actions)="row">
                            <span v-if="row.item.is_active">
<!--                                <router-link
                                    :to="{name: 'invoice',params: { id: row.item.id }}"
                                    class="btn btn-icon"
                                    title="Invoice" target="_blank"
                                    data-toggle="tooltip" data-placement="top"
                                ><i class="fas fa-download"></i>
                                </router-link>-->
                                <a class="btn btn-icon" target="_blank"
                                   :href="addProjectPath('/print_member_money_receipt/'+ row.item.id)">
                                    <i class="fas fa-download"></i>
                                </a>

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
import JsonExcel from "vue-json-excel";
import vSelect from 'vue-select';
import Datepicker from "vuejs-datepicker";
export default {
    name: "MemberCollectionReport",
    components: {ValidationErrors,JsonExcel,vSelect,Datepicker},
    props: ['warning_message','success'],
    data: () => ({
        search_receipt_number:null,
        search_receipt_type:null,
        header:['MONEY COLLECTION REPORT'],
        selected_user: null,
        request_url:null,
        selected_bmn_no:null,
        gatePassId:null,
        member: null,
        members: [],
        indexMembers: null,
        errors: [],
        validationErrors: null,
        isLoggedIn:false,
        user:null,
        loading:false,
        isBusy: false,
        totalRows: 1,
        currentPage: 1,
        perPage: 10,
        filter:null,
        pageOptions: [10, 15, { value: 100, text: "Show a lot" }],
        fields: [
            'sl_no','receipt_no',
            {
                key: 'receipt_type',
                label: 'Type',
                sortable: true
            },
            {
                key: 'transaction_date',
                label: 'Date'
            },'amount', {
                key: 'actions',
                label: 'Money Receipt'
            }],
        options: [
            { value: null, text: 'Please select an option' },
            { value: 'new_membership', text: 'New Membership', disabled: true },
            { value: 'membership_annual_subscription', text: 'Membership Annual Subscription', disabled: true },
            { value: 'id_card', text: 'ID Card' },
            { value: 'shed_rent', text: 'Shed Rent Inddor/Outdoor', disabled: true },
            { value: 'dgr_training', text: 'DGR Training', disabled: true },
            { value: 'advertisement', text: 'Adertisement', disabled: true },
            { value: 'gate_pass', text: 'Gate Pass / Amend' },
            { value: 'others', text: 'Others', disabled: true }
        ]
    }),
    created() {
        if (window.Laravel.isLoggedin) {
            this.isLoggedIn = true;
            this.member = window.Laravel.user;
            // this.member_name = window.Laravel.user.email
            this.getGatePass()
        }else{
            console.log('Member Not Log In')

        }
    },
    methods: {
        doFilter(){
            let receipt_number = this.receipt_number
            let purpose = this.purpose
                this.request_url = '/api/money_collection?' +
                    'receipt_number=' + this.search_receipt_number +
                    '&receipt_type=' + this.search_receipt_type +
                    '&member_id=' + this.member.id;
            console.log(this.request_url);
                this.loading = true;
                axios.get(this.request_url)
                    .then(res => {
                        this.members = res.data.data
                        this.members.map((e, i) => e.sl_no = i + 1);
                        this.totalRows = this.members.length
                    }).catch(error => {
                    console.error(error)
                }).finally(()=>{
                    this.loading =  false
                });

        },
        getGatePass() {
            this.loading = true;
            axios
                .get('/api/money_collection?member_id=' + this.member.id)
                .then(res => {
                    this.members = res.data.data
                    this.members.map((e, i) => e.sl_no = i + 1);
                    this.totalRows = this.members.length
                }).catch(error => {
                console.error(error)
            }).finally(()=>{
                this.loading =  false
            });
        }
    }
}
</script>

<style>
.modal-backdrop {
    opacity: 0.1 !important;
}
.card-body{  /* Components Root Element ID */
    position: relative;
}
.card-body #loader{
    /* Loader Div Class */
    position: absolute;
    top:0;
    right:0;
    width:100%;
    height:100%;
    background-color:#eceaea;
    background-size: 50px;
    background-repeat:no-repeat;
    background-position:center;
    z-index:10000000;
    opacity: 0.4;
    filter: alpha(opacity=40);
}
</style>
<style scoped>
img{
    width: 60px;
    height: 50px;
}
</style>
