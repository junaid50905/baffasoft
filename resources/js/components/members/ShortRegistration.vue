<template>
    <form class="needs-validation" @submit.prevent="submitForm" role="form" id="money-collection-form" novalidate>
        <div id="notification">
            <validation-errors :errors="validationErrors" :success="success"
                               :warning_message="warning_message"></validation-errors>
        </div>
        <div class="form-group">
            <label for="company_name">Company Name:</label>
            <input type="text" v-model="form.company_name" class="form-control" placeholder="Company Name."
                   id="company_name">
        </div>
        <div class="form-group">
            <label for="bmn">BMN:</label>
            <input type="text" v-model="form.bmn" class="form-control" placeholder="BMN"
                   id="bmn">
        </div>
<!--        <div class="form-group">-->
<!--            <label for="email">E-mail:</label>-->
<!--            <input type="email" v-model="form.email" class="form-control" placeholder="Email"-->
<!--                   id="email">-->
<!--        </div>-->
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="text" v-model="form.password" class="form-control" placeholder="Password"
                   id="password">
        </div>
        <div class="d-grid gap-2 col-4 mx-auto pt-3">
            <button type="submit" v-bind:class="[loading ? 'disabled btn-secondary' : 'btn-secondary','btn']"
                    id="loader-btn">
                <span>Create Member</span>
                <div id="loader" v-if="loading"
                     v-bind:style="{'backgroundImage': 'url(' + addProjectPath('/assets/img/ajax-loader.gif') + ')'}"></div>
            </button>
        </div>
    </form>
</template>

<script>
import ValidationErrors from "../ValidationErrors";
import JsonExcel from "vue-json-excel";
import vSelect from "vue-select";
import moment from "moment";
import Datepicker from "vuejs-datepicker";

export default {
    name: "ShortRegistration",
    components: {ValidationErrors, vSelect, Datepicker},
    data: () => ({
        form: {
            member_id: null,
            company_name:null,
            bmn: null,
            email: 'member@baffa.com',
            password: null,
        },
        member_count:0,
        errors: [],
        validationErrors: null,
        success: null,
        warning_message:null,
        isLoggedIn: false,
        user: null,
        loading: false
    }),
    created() {
        this.getOrganizations()
        if (window.Laravel.isLoggedin) {
            this.isLoggedIn = true;
            this.user = window.Laravel.user;
            // this.member_name = window.Laravel.user.email
        } else {
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
        setSelected(value) {
            this.form.member_id = value;
            console.log('Value: ', value)
            //  trigger a mutation, or dispatch an action
        },
        submitForm: function () {
            this.errors = [];
            if(this.form.company_name && this.form.bmn && this.form.password){
                let company_name = this.form.company_name
                let bmn = this.form.bmn
                axios
                    .get('/api/members/check_company_uniqueness?bmn=' + bmn +'&company_name=' + company_name)
                    .then(res => {
                        console.log(res.data)
                        this.member_count = res.data
                        if(this.member_count > 0)
                            this.errors.push(["company_name", ["Company is already exists"]]);
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
                    }).catch(error => {
                    console.error(error.response)
                })
            }else{
                if (!this.form.bmn) this.errors.push(["bmn", ["BMN Required"]]);
                if (!this.form.password) this.errors.push(["password", ["Password Required"]]);
                if(!this.form.company_name){
                    this.errors.push(["company_name", ["Company Name Required."]]);
                }

                if (this.errors.length) {
                    this.validationErrors = Object.fromEntries(this.errors)
                } else {
                    this.loading = true;
                }
            }
        },
        saveCollection: function () {
            const data = new FormData();
            data.set('organization_name', this.form.company_name);
            data.set('username', this.form.bmn);
            data.set('email', this.form.bmn + '@baffa.com');
            data.set('password', this.form.password);
            data.set('password_confirmation', this.form.password);
            axios.post("/api/members/save_short_member", data).then(res => {
                this.success = 'Member Saved Successfully';
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
