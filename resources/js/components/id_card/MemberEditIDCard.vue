<template>
    <div>
        <notifications group="foo" position="bottom right"/>
        <div class="card">
            <div class="card-header">
                <div id="notification">
                    <validation-errors :errors="validationErrors" :success="success"
                                       :warning_message="warning_message"></validation-errors>
                </div>
            </div>
            <div class="card-body">

                <main id="printMe">
                    <form class="needs-validation" @submit.prevent="submitForm" role="form" id="id-card-form" novalidate>
                        <div class="container">
                            <div class="form-field">
                                <dl>
                                    <dt><span></span>Card Type<span class="required">*</span></dt>
                                    <dd>
                                        <v-select class="lower_border" style="display: inline-block;" v-model="form.card_type" name="card_type"
                                                  :options="['Owner', 'Employee']"></v-select>
                                    </dd>
                                    <br>
                                    <dt><span></span>Form Year<span class="required">*</span></dt>
                                    <dd>
                                        <v-select class="lower_border" style="display: inline-block;" v-model="form.form_year" name="form_year"
                                                  :options="active_years"></v-select>
                                    </dd>
                                    <br>
                                    <dt><span></span>Card Holder's Photograph<span class="required">*</span></dt>
                                    <dd>
<!--                                        <input type="hidden" name="member_id" value="1">-->
                                        <input type="file" class="lower_border" name="card_holder_photograph_attachment" v-on:change="saveImage">
                                        <small id="emailHelp" class="form-text text-muted pd-lft">Size: 220px X 220px</small>
                                    </dd>
                                    <br>
                                    <dt>1.<span></span>Name of the Card Holder<span class="required">*</span></dt>
                                    <dd>
<!--                                        <input type="hidden" name="member_id" value="1">-->
                                        <input type="text" class="lower_border" name="card_holder_name" v-model="form.card_holder_name">
                                    </dd>
                                    <br>
                                    <dt>2.<span></span>Card Holder’s Designation<span class="required">*</span></dt>
                                    <dd><input type="text" class="lower_border" name="card_holder_designation" v-model="form.card_holder_designation"></dd>
                                    <br>
<!--                                    <dt>3.<span></span>Name of the Member Organization(s)<span class="required">*</span>
                                    </dt>
                                    <dd>
                                        <v-select class="lower_border"
                                                  style="display: inline-block;"
                                                  multiple
                                                  v-model="selected_organizations"
                                                  name="organization_name"
                                                  :options=organizations
                                                  :reduce="members => members.id"
                                                  label="organization_name"
                                        />
                                    </dd>
                                    <br>-->
                                    <dt>4.<span></span>BAFFA Membership No.<span class="required">*</span></dt>
                                    <dd><input style="color:#808080" type="text" class="lower_border" name="memship_no" v-model="form.memship_no" readonly></dd>
                                    <br>
                                    <dt>5.<span></span>Office Address<span class="required">*</span></dt>
                                    <dd><input type="text" class="lower_border" name="office_address" v-model="form.office_address"></dd>
                                    <br>
                                    <dt>6.<span></span>Office Telephone No.<span class="required">*</span></dt>
                                    <dd><input type="text" class="lower_border" name="office_telephone" v-model="form.office_telephone"></dd>
                                    <br>
                                    <dt>7.<span></span>Date of Birth (above 18 years)<span class="required">*</span></dt>
                                    <dd><input type="date" class="lower_border" name="dob" v-model="form.dob"></dd>
                                    <br>
                                    <dt>8.<span></span>National ID/Passport/Birth Certificate<br>
                                        <span id="idTwo"></span>No.
                                        <span class="required">*</span>
                                    </dt>
                                    <dd>
                                        <div class="lower_border" style="display: inline-block">
                                            <select name="attachment_name" v-model="form.attachment_name"
                                                    style="padding: 4px;">
                                                <option>National ID</option>
                                                <option>Passport</option>
                                                <option>Birth Certificate</option>
                                            </select>
                                            <input type="text" name="attachment_number"
                                                   :placeholder="form.attachment_name + ' Number'" v-model="form.attachment_number">
                                            <input type="file" name="attachment_file" v-on:change="saveImage">
                                        </div>
                                    </dd>
                                    <br>
                                    <dt>9.<span></span>Blood Group<span class="required">*</span></dt>
                                    <dd>
                                        <select name="blood_group" class="lower_border" v-model="form.blood_group">
                                            <option value="A+">A+</option>
                                            <option value="A-">A-</option>
                                            <option value="B+">B+</option>
                                            <option value="B-">B-</option>
                                            <option value="O+">O+</option>
                                            <option value="O-">O-</option>
                                            <option value="AB+">AB+</option>
                                            <option value="AB-">AB-</option>
                                        </select>
                                    </dd>
                                    <br>
                                    <dt>10.<span id="id3"></span>Previous year ({{form.form_year - 1}}) ID Card No.</dt>
                                    <dd><input type="text" class="lower_border" name="previous_year_id_card_number" v-model="form.previous_year_id_card_number"></dd>
                                    <br>
                                    <dt>11.<span id="id3"></span>Police Verification/clearance issue date<span
                                        class="required">*</span>
                                    </dt>
                                    <dd>
                                        <div class="lower_border" style="display: inline-block">
                                            <input type="date" name="police_verification" v-model="form.police_verification">
                                            <input type="file" name="police_verification_attachment" v-on:change="saveImage">
                                        </div>
                                    </dd>
                                    <br>
                                    <dt>12.<span id="id3"></span>Cargo Security Awareness Training Status</dt>
                                    <dd><span id="id4"><input type="radio" name="training_status" id="training_status1"
                                                              v-model="form.training_status" value="yes"></span>
                                        <label for="training_status1">Yes</label>
                                        <span id="id4"><input type="radio" name="training_status" id="training_status2"
                                                              v-model="form.training_status" value="no"></span>
                                        <label for="training_status2">No</label>
                                        <span id="id4"></span><b>(Please mark √)</b>
                                    </dd>
                                    <br>
                                    <div v-if="form.training_status == 'yes'">
                                        <dt><span id="id4"></span>If “Yes” please mentioned details<span
                                            class="required">*</span></dt>
                                        <dd>Training Date : <input type="date" class="lower_border" name="training_date"
                                                                   v-model="form.training_date" style="width: 36%">
                                            <!--                                        _______/______/20_______-->
                                        </dd>

                                        <dt class="dt-dot">.</dt>
                                        <dd>Valid CAAB ID No. : <input type="text" class="lower_border" style="width: 31%"
                                                                       name="caab_id_no" v-model="form.caab_id_no"></dd>
                                    </div>
                                </dl>
                            </div>
                            <div class="sign-field_1">
                                <div class="second-sign">
                                    <div>
                                        <input type="file" class="lower_border" name="card_holder_signature_attachment"
                                               style="width: 100%" v-on:change="saveImage">
                                    </div>
                                    <div>
                                        <b>Card Holder’s Signature<span class="required">*</span></b>
                                    </div>
                                </div>
                                <br>
                                <div class="first-sign">
                                    <div>
                                        <input type="file" class="lower_border" name="signatory_attachment" style="width: 100%" v-on:change="saveImage">
                                    </div>
                                    <div>
                                        <b>Seal & Signature of Chairman/MD/ Director<span class="required">*</span></b>
                                    </div>
                                    <div>
                                        <b>Managing Partner/Proprietor</b>
                                    </div>
                                    <div class="ref7">
                                        <div>
                                            <p>Name of the Signatory</p>
                                            <p>:</p>
                                            <input type="text" disabled class="lower_border" name="caab_id_no" v-model="selected_company_owners">
<!--                                            <ol class="lower_border">-->
<!--                                                <li v-for="company_owners in selected_company_owners">-->
<!--                                                    {{ company_owners }}-->
<!--                                                </li>-->
<!--                                            </ol>-->
<!--                                            <br/>-->
<!--                                            <v-select class="lower_border"-->
<!--                                                      style="display: inline-block;"-->
<!--                                                      :options=selected_company_owners-->
<!--                                                      :reduce="owner => owner.id"-->
<!--                                                      label="name"-->
<!--                                                      v-model="form.company_owner_id"-->
<!--                                                      name="company_owner_id"-->
<!--                                            />-->
                                        </div>
                                        <div style="display: flex;">
                                            <p>Designation</p>
                                            <p class="ref9">:</p>
                                            <!--                                            <v-select class="lower_border" v-model="form.designation" name="designation"
                                                                                            :options="['Director', 'Managing Director','Partner','Chairman']"></v-select>-->
                                            <input type="text" name="designation" class="lower_border" v-model="form.designation">
                                        </div>
                                        <div style="display: flex;">
                                            <p>Company Name</p>
                                            <p class="ref10">:</p>
                                            <ol>
                                                <li v-for="organization_name in selected_organization_names">
                                                    {{ organization_name }}
                                                </li>
                                            </ol>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="box12 mt-5">
                            <div class="d-grid gap-2 col-12 mx-auto" >
                                <button type="submit" v-bind:class="[loading ? 'disabled btn-success' : 'btn-success','btn']" id="loader-btn" style="width:100%;font-size:20px;">
                                    <span>Update ID Card</span>
                                    <div id="loader" v-if="loading" v-bind:style="{'backgroundImage': 'url(' + addProjectPath('/assets/img/ajax-loader.gif') + ')'}" ></div>
                                </button>
                            </div>
                        </div>
                    </form>
                </main>


            </div>
        </div>
        <link type="text/css" rel="stylesheet" :href="addProjectPath('/front/assets/css/id-card-style.css')">
    </div>
</template>

<script>
import ValidationErrors from "../ValidationErrors";
import moment from "moment";
import vSelect from "vue-select";

export default {
    name: "MemberNewIDCard",
    components: {ValidationErrors, moment,vSelect},
    data: () => ({
        organizations: [],
        active_years: [],
        selected_organization_names: null,
        selected_organization_ids: null,
        selected_company_owners: [],
        member_id:null,
        selected_organizations:[],
        loading: false,
        errors: [],
        validationErrors: null,
        success: null,
        warning_message:null,
        user: null,
        isLoggedIn:false,
        member: null,
        form: {
            card_holder_name: '',
            company_owner_id: null,
            // training_status: 'yes',
            // attachment_name: 'National ID',
            // dob: new Date(2002,0,1).toISOString().slice(0, 10),
            // training_date: new Date().toISOString().slice(0, 10),
            // police_verification: new Date().toISOString().slice(0, 10),
            designation:null,
            // card_type:'Owner',
            // form_year:new Date().getFullYear(),

            attachment_file: null,
            card_holder_signature: null,
            signature: null,
        }

    }),
    created(){
        if (window.Laravel.isLoggedin) {
            this.isLoggedIn = true;
            this.member = window.Laravel.user;
            // this.member_name = window.Laravel.user.email
            this.selected_organizations.push(this.member.id);
            // this.form.created_user_name = this.member.username;
            // this.form.member_id = this.member.id;
            // this.getGatePass()
        }else{
            console.log('Member Not Log In')
        }
        this.getOrganizations();
        this.getActiveYears();
    },
    watch:{
        selected_organizations:function(val) {
            this.doOnChangeOrganization(val);
        }
    },
    methods: {
        doOnChangeOrganization(val){
            console.log(val);
            this.selected_organization_names = [];
            let selected_organization_usernames = [];
            let selected_company_owners = [];
            val.forEach((item) => {
                // console.log(val)
                this.selected_organization_names.push(this.organizations.filter(j => j.id === item).map(item => item.organization_name)[0]);
                selected_organization_usernames.push(this.organizations.filter(j => j.id === item).map(item => item.username)[0]);
                selected_company_owners.push(this.organizations.filter(j => j.id === item).map(value => value.company_owners.map(k => ({'id':k.id,'name':k.name}))));
            })
            this.selected_company_owners = this.multiDimensionalUnique(selected_company_owners.flat(2));
            this.selected_organization_ids = selected_organization_usernames.toString();
        },
        multiDimensionalUnique: function (arr) {
            let uniques = [];
            let itemsFound = {};
            for(let i = 0, l = arr.length; i < l; i++) {
                let stringified = JSON.stringify(arr[i]);
                if(itemsFound[stringified]) { continue; }
                uniques.push(arr[i]);
                itemsFound[stringified] = true;
                // console.log(itemsFound)
            }
            return uniques;
        },
        saveImage: function (event) {
            console.log(event.target.files[0])
            this.form[event.target.name] = event.target.files[0];
        },
        submitForm: function () {
            this.errors = [];
            if (!this.form.company_owner_id) this.errors.push(["company_owner_id", ["Name of the Signatory required."]]);
            if (!this.form.card_holder_name) this.errors.push(["card_holder_name", ["Card Holder Name equired."]]);
            if (!this.form.card_holder_designation) this.errors.push(["card_holder_designation", ["Card Holder Designation required."]]);
            if (!this.form.office_address) this.errors.push(["office_address", ["Office Address required."]]);
            if (!this.form.office_telephone) this.errors.push(["office_telephone", ["Office Telephone required."]]);
            if (!this.form.attachment_number) this.errors.push(["attachment_number", ["National ID/Passport/Birth Certificate required."]]);

            if(!this.form.dob){
                this.errors.push(["dob", ["Date of Birth required."]]);
            }else{
                let given = moment(this.form.dob, "YYYY-MM-DD");
                let current = moment().startOf('day');
                let distance = moment.duration(current.diff(given)).years();
                if(distance < 18){
                    this.errors.push(["dob", ["Date of Birth above 18 years."]]);
                }
            }
            // if(this.selected_organization_ids){
            //     console.log(this.selected_organization_ids,this.member.username)
            //     if(!this.selected_organization_ids.includes(this.member.username)){
            //         this.errors.push(["member_organization", ["Please, Select Your Organization Name."]]);
            //     }
            // }else{
            //     this.errors.push(["organizations", ["Please, Select a Organization Name."]]);
            // }
            if (this.errors.length) {
                // this.validationErrors = Object.assign({},this.errors)
                this.validationErrors = Object.fromEntries(this.errors)
            } else {
                // console.log(this.form)
                // console.log(initFromData)
                // if (!this.errors.length) return true;
                this.loading = true;
                this.saveIdCard()
            }
        },
        saveIdCard: function () {
            // const data = new FormData();
            let myForm = document.getElementById('id-card-form');
            let data = new FormData(myForm);
            // data.set('company_owner_id', this.form.company_owner_id);
            // data.set('designation', this.form.designation);
            data.set('card_type', this.form.card_type);
            data.set('form_year', this.form.form_year);
            // data.set('selected_organizations', this.selected_organizations);
            data.set('status', '0');
            // data.set('member_id', this.member.id);
            // data.set('dob', moment(String(this.form.dob)).format('YYYY-MM-DD'));
            // data.set('training_date', moment(String(this.form.training_date)).format('YYYY-MM-DD'));
            axios.post("/api/id_cards/"+ this.$route.params.id + '/update', data).then(res => {
                // this.reset();
                // console.log(res.data.id)
                this.success = 'ID Card Saved Successfully';
                this.$router.push({name: "member-all-id-card", query: {success: this.success}});
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
        getOrganizations() {
            axios
                .get('/api/members/organizations')
                .then(res => {
                    this.organizations = res.data
                    this.getIdCard();
                }).catch(error => {
                console.error(error.response)
            })
        },
        getIdCard() {
            axios
                .get('/api/id_cards/' + this.$route.params.id)
                .then(res => {
                    this.form = res.data
                    this.selected_organization_names = this.form.members.map(v => v.organization_name);
                    if(this.form.company_owner){
                        // this.selected_company_owners = this.form.company_owner.id;
                        this.selected_company_owners = this.form.company_owner.name;
                    }
                    if(this.form.dob) this.form.dob = new Date(res.data.dob).toISOString().slice(0, 10)
                    if(this.form.training_date) this.form.training_date = new Date(res.data.training_date).toISOString().slice(0, 10)
                    if(this.form.police_verification) this.form.police_verification = new Date(res.data.police_verification).toISOString().slice(0, 10)
                    console.log(this.form)
                }).catch(error => {
                console.error('My Error: ' + error)
            })
        },
        getActiveYears() {
            axios
                .get('/api/id_cards/active_years/all')
                .then(res => {
                    this.active_years = res.data
                }).catch(error => {
                console.error(error.response)
            })
        }
    }

}
</script>

<style scoped>
.lower_border {
    width: 49%;
    border: none;
    border-bottom: 1px solid black;
    padding: 5px 10px;
    outline: none;
}
.ref7{
    margin-top: 5px;
}
.ref7 div{
    padding-top: 3.5px;
}
.ref7 div p{
    display: inline;
}
.ref9{
    padding-left: 68px;
}
.ref10{
    padding-left: 40px;
}
.pd-lft{
    padding-left:0px;
}
@media (min-width: 768px) {
    .pd-lft{
        padding-left:260px;
    }
}
</style>
