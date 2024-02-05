<template>
    <div>
        <nav class="navbar navbar-expand-lg position-absolute top-0 z-index-3 w-100 shadow-none my-3  navbar-transparent mt-4">
            <div class="container">
                <a class="navbar-brand font-weight-bolder ms-lg-0 ms-3 text-white" :href="addProjectPath('/')">
                    <img :src="addProjectPath('/front/assets/img/logo.png')" height="50">
                </a>
                <button class="navbar-toggler shadow-none ms-2" type="button" data-bs-toggle="collapse" data-bs-target="#navigation" aria-controls="navigation" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon mt-2">
          <span class="navbar-toggler-bar bar1"></span>
          <span class="navbar-toggler-bar bar2"></span>
          <span class="navbar-toggler-bar bar3"></span>
        </span>
                </button>
                <div class="collapse navbar-collapse w-100 pt-3 pb-2 py-lg-0" id="navigation">
                    <ul class="navbar-nav navbar-nav-hover mx-auto">
                    </ul>
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link me-2" href="register">
                                <i class="fas fa-user-circle opacity-6 text-dark me-1"></i>
                                Sign Up
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link me-2" href="login">
                                <i class="fas fa-key opacity-6 text-dark me-1"></i>
                                Sign In
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- End Navbar -->
        <section class="min-vh-100 mb-8">
            <div class="page-header align-items-start min-vh-50 pt-5 pb-11 m-3 border-radius-lg" v-bind:style="{'backgroundImage': 'url(' + addProjectPath('/front/assets/img/curved-images/curved14.jpg') + ')'}">
                <span class="mask bg-gradient-dark opacity-6"></span>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5 text-center mx-auto">
                            <h1 class="text-white mb-2 mt-5">Welcome!</h1>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row mt-lg-n10 mt-md-n11 mt-n10">
                    <div class="col-xl-4 col-lg-5 col-md-7 mx-auto">
                        <div class="card z-index-0">
                            <div class="card-header text-center pt-4">
                                <h5>Member Registration</h5>
                                <router-link :to="{name: 'vue-members'}" class="btn btn-primary mt-2">All Members</router-link>
                            </div>
                            <div class="card-body">
<!--                                @include('partials/messages')-->
                                <form @submit.prevent="savemember" role="form" id="registration-form" autocomplete="off" class="mt-3">
                                    <input type="hidden" value="<?= csrf_token() ?>" name="_token">
                                    <div class="mb-3">
                                        <input type="text" class="form-control" v-model="form.username" name="username" placeholder="Name" aria-label="Name" aria-describedby="email-addon">
                                    </div>
                                    <div class="mb-3">
                                        <input type="email" class="form-control" v-model="form.email" name="email"  placeholder="Email" aria-label="Email" aria-describedby="email-addon">
                                    </div>
                                    <div class="mb-3">
                                        <input type="password" class="form-control" v-model="form.password" name="password" placeholder="Password" aria-label="Password" aria-describedby="password-addon">
                                    </div>
                                    <div class="mb-3">
                                        <input type="password" class="form-control" v-model="form.password_confirmation" name="password_confirmation" placeholder="Password Confirmatoin" aria-label="Password" aria-describedby="password-addon">
                                    </div>
                                    <div class="mb-3 ">
                                        <datepicker input-class="form-control"  v-model="form.birth_date"/>
<!--                                        <input type="password" class="form-control" name="password" placeholder="Password" aria-label="Password" aria-describedby="password-addon">-->
                                    </div>
                                    <div class="mb-3">
                                        <select @change="disPlayDate" class="form-select" aria-label="Default select example" v-model="form.nationality_id">
                                            <option v-for="country in countries" :key="country.id" :value="country.id">{{country.name}}</option>
                                        </select>
                                    </div>
                                    <input type="file" class="file" name="attach_id_card_or_passport" v-on:change="setImage">
                                    <datepicker input-class="form-control" name="form_submit_date" v-model="form.form_submit_date"/>

                                    <div class="form-check form-check-info text-left">
                                        <input class="form-check-input" type="checkbox" value="1" name="tos" id="flexCheckDefault" checked>
                                        <label class="form-check-label" for="flexCheckDefault">
                                            I agree the <a href="javascript:;" class="text-dark font-weight-bolder">Terms and Conditions</a>
                                        </label>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn bg-gradient-dark w-100 my-4 mb-2">Sign up</button>
                                    </div>
                                    <p class="text-sm mt-3 mb-0">Already have an account? <a href="login" class="text-dark font-weight-bolder">Sign in</a></p>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- -------- START FOOTER 3 w/ COMPANY DESCRIPTION WITH LINKS & SOCIAL ICONS & COPYRIGHT ------- -->
        <Footer :firmType='firmTypes' />
        {{firmTypes}}
        <div class="form-check">
            <input class="form-check-input" type="radio" value="limited" name="flexRadioDefault" id="flexRadioDefault3" v-model="firmTypes">
            <label class="form-check-label" for="flexRadioDefault3">
                limited
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" value="partnership" name="flexRadioDefault" id="flexRadioDefault1" v-model="firmTypes">
            <label class="form-check-label" for="flexRadioDefault1">
                partnership
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" value="proprietorship" name="flexRadioDefault" id="flexRadioDefault2"  v-model="firmTypes">
            <label class="form-check-label" for="flexRadioDefault2">
                proprietorship
            </label>
        </div>
        <div style="margin: 20px"></div>
        <br>
        <br>
        <br>
        <br>
    </div>
</template>

<script>
import Datepicker from 'vuejs-datepicker';
import moment from "moment"
import Footer from "../members/Footer";
export default {
    name: "VueNewMember",
    components: {
        Footer,
        Datepicker,
        moment
    },
    data(){
        return{
            // state_date: this.format_date(new Date()),
            today_value: new Date().getFullYear(),
            countries:[],
            firmTypes:'partnership',
            form:{
                username:'',
                email:'',
                password:'',
                password_confirmation:'',
                birth_date:this.format_date(new Date()),
                nationality_id:null,
                firm_type:'proprietorship',
                attach_id_card_or_passport: null,
                form_submit_date: new Date().toISOString().slice(0, 10),
                firm_name: 'A Name'
            }
        }
    },
    created() {
        this.getCountries()
    },
    methods: {
        setImage(event) {
            this.form.attach_id_card_or_passport = event.target.files[0];
        },
        changeCompanyOwner(){
            this.components
            console.log('ss')

        },
        getCountries(){
            axios
                .get('/api/members/countries')
                .then(res => {
                    this.countries = res.data
                }).catch(error => {
                console.error(error.response.data.message)
            })
        },
        savemember(){
            let myForm = document.getElementById('registration-form');
            let data = new FormData(myForm);
            // data.set('form_submit_date', this.format_date(this.form.form_submit_date));
            // data.set('firm_name', this.form.firm_name);
            // data.append('email', this.form.email);
            // data.append('password', this.form.password);
            // data.append('password_confirmation', this.form.password_confirmation);

            axios
            .post('/api/members/save',{
                username: this.form.username,
                email: this.form.email,
                password: this.form.password,
                password_confirmation: this.form.password_confirmation
            })
        },
        format_date(value){
            if(value){
                return moment(String(value)).format('YYYY-MM-DD HH:mm:ss')
            }

        },
        disPlayDate(){
            console.log('Date: ',this.format_date(this.form.birth_date))
        }
    }

}
</script>

<style scoped>

</style>
