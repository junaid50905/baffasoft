<template>
    <div>
        <div class="col-xl-5 col-lg-5 col-md-7 mx-auto">
            <div class="card z-index-0">
                <div class="card-header text-center pt-4">
                    <h5>Member Registration</h5>
                </div>
                <div class="card-body">
                    <!--                                <p v-if="errors.length">-->
                    <!--                                    <b>Please correct the following error(s):</b>-->
                    <!--                                <ul>-->
                    <!--                                    <li v-for="error in errors">{{ error }}</li>-->
                    <!--                                </ul>-->
                    <!--                                </p>-->
                    <validation-errors :errors="validationErrors" :success="success"
                                       :warning_message="warning_message"></validation-errors>
                    <!--  @include('partials/messages')-->
                    <form ref="form" @submit.prevent="submitForm" role="form" id="registration-form" autocomplete="off"
                          enctype="multipart/form-data" class="mt-3">
                        <div class="mb-3">
                            <input type="text" class="form-control" v-model="form.username" name="username"
                                   placeholder="Name" maxlength="10" aria-label="Name" aria-describedby="email-addon">
                        </div>
                        <div class="mb-3">
                            <input type="email" class="form-control" v-model="form.email" name="email"
                                   placeholder="Email" aria-label="Email" aria-describedby="email-addon">
                        </div>
                        <div class="mb-3">
                            <input type="password" class="form-control" v-model="form.password"
                                   name="password" placeholder="Password" aria-label="Password"
                                   aria-describedby="password-addon">
                        </div>
                        <div class="mb-3">
                            <input type="password" class="form-control" v-model="form.password_confirmation"
                                   name="password_confirmation" placeholder="Password Confirmatoin"
                                   aria-label="Password" aria-describedby="password-addon">
                        </div>
                        <div class="form-check form-check-info text-left">
                            <input class="form-check-input" type="checkbox" name="terms"
                                   id="terms" v-model="form.terms">
                            <label class="form-check-label" for="terms">
                                I agree the <a :href="addProjectPath('/assets/Terms_and_Conditions.pdf')" target=”_blank” class="text-dark font-weight-bolder text-decoration-underline">Terms
                                and Conditions</a>
                            </label>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn bg-gradient-dark w-100 my-4 mb-2">Sign up
                            </button>
                        </div>
                        <p class="text-sm mt-3 mb-0">Already have an account?
<!--                            <a :href="route('member.login')" class="text-dark font-weight-bolder">Sign in</a>-->
                            <a :href="addProjectPath('/login')" class="text-dark font-weight-bolder">Sign in</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import ValidationErrors from "../ValidationErrors";
import Datepicker from "vuejs-datepicker";
const initFormData = {
    username: '',
    email: '',
    password: '',
    password_confirmation: '',
    terms: false
}
export default {
    name: "Registration",
    components: {ValidationErrors,Datepicker},
    props: ['warning_message','success'],
    data() {
        return {
            form: Object.assign({}, initFormData),
            errors: [],
            validationErrors: null
        }
    },
    methods: {
        submitForm: function () {
            this.errors = [];
            if (!this.form.username) this.errors.push(["username", ["Name required."]]);
            if (!this.form.email) this.errors.push(["email", ["Email required."]]);
            if (!this.form.terms) this.errors.push(["terms", ["Agree Terms & Conditions."]]);
            if (this.errors.length) {
                // this.validationErrors = Object.assign({},this.errors)
                this.validationErrors = Object.fromEntries(this.errors)
            } else {
                // console.log(this.form)
                // console.log(initFromData)
                // if (!this.errors.length) return true;
                this.saveMember()
            }
        },
        saveMember: function () {
            // {
            //     username: this.form.username,
            //         email: this.form.email,
            //     password: this.form.password,
            //     password_confirmation: this.form.password_confirmation
            // }
            let myForm = document.getElementById('registration-form');
            let data = new FormData(myForm);
            axios
                .post('/api/members/create', data).then(res => {
                this.validationErrors = null;
                // this.success = 'Login Credential Updated Successfully';
                this.form = Object.assign({}, initFormData)
                this.$router.push({ name: "new-member" });
                // this.$router.push({ name: "new-member", query: { member: res.data } });// with query => /new-member?member=data
            }).catch(error => {
                if (error.response.status == 422) {
                    this.validationErrors = error.response.data.errors;
                }
            });
        }
    }
}
</script>

<style scoped>

</style>
