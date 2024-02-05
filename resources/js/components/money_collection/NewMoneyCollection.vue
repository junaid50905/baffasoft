<template>
    <form class="needs-validation" @submit.prevent="submitForm" role="form" id="money-collection-form" novalidate>
        <div id="notification">
            <validation-errors :errors="validationErrors" :success="success"
                               :warning_message="warning_message"></validation-errors>
        </div>
        <div class="form-group" v-if="!get_member_id">
            <label for="email">Select Organizatoin Name:</label>
            <v-select
                placeholder="Choose an Organization"
                v-model="form.selected_organization"
                @input="setSelected"
                :options="organizations"
                :reduce="organizations => organizations.id"
                label="organization_name" id="organization_name"></v-select>
        </div>
        <div class="form-group" v-else>
            <label for="email">Select Organizatoin Name:</label>
            <input class="form-control" :value="getOrganizationName" :disabled="true">
        </div>
        <div class="form-group" v-if="!get_receipt_type">
            <label for="receipt_type" class="form-label">Money Receipt Type of Fields</label>
            <b-form-select v-model="form.receipt_type" :options="receipt_types"></b-form-select>
<!--            <input class="form-control" list="datalistOptions" id="receipt_type" placeholder="Type to search...">-->
<!--            <datalist id="datalistOptions">-->
<!--                <option value="San Francisco">San Francisco</option>-->
<!--            </datalist>-->
        </div>
        <div class="form-group" v-else>
            <label for="receipt_type" class="form-label">Money Receipt Type of Fields: </label>
            <input class="form-control" :value="getReceiptType" :disabled="true">
        </div>
<!--        <b-row>-->
<!--            <b-col>-->
<!--                <div class="form-group">-->
<!--                    <label for="selected_year" class="form-label">Select Year</label>-->
<!--                    <b-form-select v-model="form.selected_year" :options="years"></b-form-select>-->
<!--                </div>-->
<!--            </b-col>-->
<!--            <b-col>-->
<!--                <div class="form-group">-->
<!--                    <label for="selected_months" class="form-label">Months</label>-->
<!--                    <b-form-select v-model="form.selected_months" :options="months" multiple :select-size="4"></b-form-select>-->
<!--                </div>-->
<!--            </b-col>-->
<!--        </b-row>-->
        <div class="form-group">
            <label for="receipt_year">Year:</label>
            <input type="number" class="form-control" name="receipt_year" v-model="form.receipt_year" :disabled="true"/>
        </div>

        <div class="form-group" v-if="!get_amount">
            <label for="amount">Amount:</label>
            <input v-if="props_receipt_type" type="number" v-model="form.amount" class="form-control" placeholder="Enter Amount" id="amount">
            <input v-else type="number" v-model="form.amount" class="form-control" placeholder="Enter Amount" id="amount">
        </div>
        <div class="form-group" v-else>
            <label for="amount">Amount:</label>
            <input type="number" class="form-control" :value="form.amount" :disabled="true">
        </div>
        <div class="form-group">
            <label for="description">Description:</label>
            <textarea class="form-control"  v-model="form.description" id="description" rows="1"></textarea>
        </div>
        <div class="form-group">
            <label for="payment_type">Mode of Receipt:</label>
            <b-form-select id="payment_type" v-model="form.payment_type" :options="payment_types"></b-form-select>
        </div>
        <div v-if="form.payment_type != 'Cash'">
            <div class="form-group">
                <label for="payment_chq_no">P.O/D.D/Chq.No.:</label>
                <input type="text" v-model="form.payment_chq_no" class="form-control" placeholder="P.O/D.D/Chq.No." id="payment_chq_no">
            </div>
            <div class="form-group">
                <label for="payment_chq_date">P.O/D.D/Chq.Date:</label>
                <datepicker input-class="form-control" name="payment_chq_date"
                            v-model="form.payment_chq_date"/>
    <!--            <input type="date" v-model="form.payment_chq_date" class="form-control" placeholder="P.O/D.D/Chq.No." id="payment_chq_date">-->
            </div>
            <div class="form-group">
                <label for="payment_bank">Bank:</label>
                <input type="text" v-model="form.payment_bank" class="form-control" placeholder="Bank Name" id="payment_bank">
            </div>
        </div>
        <div class="d-grid gap-2 col-4 mx-auto pt-3">
            <button type="submit" v-bind:class="[loading ? 'disabled btn-secondary' : 'btn-secondary','btn']" id="loader-btn">
                <span>Create Money Receipt</span>
                <div id="loader" v-if="loading" v-bind:style="{'backgroundImage': 'url(' + addProjectPath('/assets/img/ajax-loader.gif') + ')'}" ></div>
            </button>
        </div>
<!--        <button type="submit" class="btn btn-primary mb-2">Submit</button>-->
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
    </form>
</template>

<script>
import ValidationErrors from "../ValidationErrors";
import JsonExcel from "vue-json-excel";
import vSelect from "vue-select";
import moment from "moment";
import Datepicker from "vuejs-datepicker";

export default {
    name: "NewMoneyCollection",
    components: {ValidationErrors,vSelect,Datepicker},
    props: ['props_id','props_receipt_type','props_receipt_year'],
    data: () => ({
        form:{
            member_id:null,
            receipt_type:'gate_pass',
            receipt_year:new Date().getFullYear(),
            receipt_month_year:new Date(),
            description:'',
            payment_type:'Cash',
            payment_chq_no:'',
            payment_chq_date:new Date().toISOString().slice(0, 10),
            payment_bank:'',
            amount:null,
            selected_organization:null,
            selected_year:'2022',
            selected_months:[]
        },
        years: [
            { value: null, text: 'Please select an Year' },
            {value:2020,text:'2020'},
            {value:2021,text:'2021'},
            {value:2022,text:'2022'}
        ],
        months: [
            {value:1,text:'Jan', disabled: true},
            {value:2,text:'Feb'},
            {value:3,text:'Mar'},
            {value:4,text:'Apr'},
            {value:5,text:'May'},
            {value:6,text:'Jun'},
            {value:7,text:'July'},
            {value:8,text:'Aug'},
            {value:9,text:'Sep'},
            {value:10,text:'Oct'},
            {value:11,text:'Nov'},
            {value:12,text:'Dec'}
        ],
        receipt_types: [
            // { value: null, text: 'Please select an option' },
            { value: 'new_membership', text: 'New Membership', disabled: true },
            { value: 'newsletter', text: 'Newsletter'},
            { value: 'membership_annual_subscription', text: 'Membership Annual Subscription', disabled: true },
            { value: 'membership_structure_change', text: 'Change of Company Structure', disabled: true },
            { value: 'id_card', text: 'ID Card', disabled: true },
            { value: 'reissue_id_card', text: 'Reissue ID Card', disabled: true },
            { value: 'shed_rent_indoor', text: 'Shed Rent Indoor', disabled: true },
            { value: 'shed_rent_outdoor', text: 'Shed Rent Outdoor', disabled: true },
            { value: 'dgr_training', text: 'DGR Training', disabled: true },
            { value: 'csa_training', text: 'CSA Training', disabled: true },
            { value: 'other_training', text: 'Other Training', disabled: true },
            { value: 'advertisement', text: 'Adertisement', disabled: true },
            { value: 'gate_pass', text: 'Gate Pass / Amend' },
            { value: 'others', text: 'Others', disabled: true }
        ],
        payment_types: [
            { value: null, text: 'Please select Payment Types' },
            {value:'Cash',text:'Cash'},
            {value:'Cheque',text:'Cheque'},
            {value:'Pay order',text:'Pay order'}
        ],
        organizations:[],
        errors: [],
        validationErrors: null,
        success: null,
        warning_message: null,
        isLoggedIn:false,
        user:null,
        loading:false,
        get_member_id:false,
        get_receipt_type:false,
        get_amount:false,
    }),
    created() {
        if(this.props_receipt_type == 'new_membership'){
            this.getAllVerifiedOrganizationName()
        }else{
            this.getOrganizations()
        }
        if (window.Laravel.isLoggedin) {
            this.isLoggedIn = true;
            this.user = window.Laravel.user;
            // this.member_name = window.Laravel.user.email
        }else{
            console.log('Member Not Log In')
        }
        if(this.$route.params.member_id){
            this.form.member_id = this.$route.params.member_id;
            this.get_member_id = true;
            this.form.receipt_id = this.props_id;
            this.form.receipt_type = this.props_receipt_type;
            this.get_receipt_type = true;
            if(this.props_receipt_type == 'reissue_id_card'){
                this.form.amount = '1000';
                this.get_amount = true;
                this.form.description = 'Reissue ID Card';
            }else if(this.props_receipt_type == 'id_card'){
                this.form.description = 'ID Card';
            }else if(this.props_receipt_type == 'new_membership'){
                // this.form.receipt_year = this.props_receipt_year;
                this.form.description = 'New Membership';
            }else if(this.props_receipt_type == 'membership_annual_subscription'){
                this.form.receipt_year = this.props_receipt_year;
                this.get_amount = true;
                this.getAnnualAmount();
            }else if(this.props_receipt_type == 'dgr_training'){
                this.form.receipt_year = this.props_receipt_year;
                this.form.description = 'DGR Training - ' + this.props_receipt_year;
            }else if(this.props_receipt_type == 'csa_training'){
                this.form.description = 'CSA Training - ' + this.props_receipt_year;
                this.form.receipt_year = this.props_receipt_year;
            }else if(this.props_receipt_type == 'other_training'){
                this.form.description = 'Other Training - ' + this.props_receipt_year;
                this.form.receipt_year = this.props_receipt_year;
            }else if(this.props_receipt_type == 'membership_structure_change'){
                this.form.description = 'Change of Company Structure';
                this.form.receipt_year = this.props_receipt_year;
                // this.get_amount = true;
                // this.form.amount = '1000';
            }
        }
    },
    computed: {
        getReceiptType() {
            let field = this.receipt_types.find(({ value }) => value === this.form.receipt_type)
            return field ? field.text : ''
        },
        getOrganizationName() {
            let field = this.organizations.find(({ id }) => id == this.form.member_id)
            return field ? field.organization_name : ''
        }
    },
    methods:{
        getOrganizations(){
            axios
                .get('/api/members/organizations')
                .then(res => {
                    this.organizations = res.data
                }).catch(error => {
                console.error(error)
            })
        },
        getAllVerifiedOrganizationName(){
            axios
                .get('/api/members/verified_organizations')
                .then(res => {
                    this.organizations = res.data
                }).catch(error => {
                console.error(error)
            })
        },
        getAnnualAmount(){
            axios
                .get('/api/renew_member/check_renewal_fees/'+this.form.receipt_id)
                .then(res => {
                    this.form.amount = res.data.amount;
                    this.form.description = res.data.description;
                }).catch(error => {
                console.error(error)
            })
        },
        setSelected(value)
        {
            this.form.member_id = value;
            console.log('Value: ',value)
            //  trigger a mutation, or dispatch an action
        },
        submitForm: function () {
            this.errors = [];
            if (!this.form.member_id) this.errors.push(["member_id", ["Member No. required."]]);
            if (this.form.amount <=0 ) this.errors.push(["amount", ["Amount is greater than 0."]]);
            if (this.errors.length) {
                // this.validationErrors = Object.assign({},this.errors)
                this.validationErrors = Object.fromEntries(this.errors)
            } else {
                // console.log(this.form)
                // console.log(initFromData)
                // if (!this.errors.length) return true;
                this.loading = true;
                this.saveCollection()
            }
        },
        saveCollection: function () {
            const data = new FormData();
            data.set('member_id', this.form.member_id);
            data.set('receipt_id', this.form.receipt_id);
            data.set('receipt_type', this.form.receipt_type);
            data.set('receipt_year', this.form.receipt_year);
            data.set('amount', this.form.amount);
            data.set('description', this.form.description);
            data.set('payment_type', this.form.payment_type);
            data.set('payment_chq_no', this.form.payment_chq_no);
            data.set('payment_chq_date', moment(this.form.payment_chq_date).format('YYYY-MM-DD'));
            data.set('payment_bank', this.form.payment_bank);
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
        }
    }
}
</script>

<style scoped>

</style>
