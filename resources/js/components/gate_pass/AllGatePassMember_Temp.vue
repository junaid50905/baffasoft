<template>
    <div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive" id="users-table-wrapper">
                    <validation-errors :errors="validationErrors" :success="success"
                                       :warning_message="warning_message"></validation-errors>
                    <table class="table table-borderless table-striped">
                        <thead>
                        <tr>
<!--                            <th></th>-->
                            <th class="min-width-80">Master Airway bill No.</th>
<!--                            <th class="min-width-150">Full Name</th>-->
<!--                            <th class="min-width-100">Email</th>-->
                            <th class="min-width-80">Registration Date</th>
<!--                            <th class="min-width-80">Status</th>-->
                            <th class="text-center min-width-150">Form Submission</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="member in members">
<!--                            <td style="width: 40px;">-->
<!--                                <a href="">-->
<!--                                    <img-->
<!--                                        class="rounded-circle img-responsive"-->
<!--                                        width="40"-->
<!--                                        src=""-->
<!--                                        alt="">-->
<!--                                </a>-->
<!--                            </td>-->
                            <td class="align-middle">
                                <a href="">
                                    {{ member.username }}
                                </a>
                            </td>
<!--                            <td class="align-middle">{{ member.first_name + ' ' + member.last_name }}</td>-->
<!--                            <td class="align-middle">{{ member.email }}</td>-->
                            <td class="align-middle">{{ member.created_at }}</td>
<!--                            <td class="align-middle">-->
<!--        <span class="badge badge-lg badge-success">-->
<!--            {{ member.status }}-->
<!--        </span>-->
<!--                            </td>-->
                            <td class="text-center align-middle">
<!--                                <a href=""-->
<!--                                   class="btn btn-icon edit"-->
<!--                                   title="Edit User"-->
<!--                                   data-toggle="tooltip" data-placement="top">-->
<!--                                    <i class="fas fa-edit"></i>-->
<!--                                </a>-->
                                <button v-if="!member.is_active" class="btn btn-icon" @click="doSubmit(member.id)"
                                        data-toggle="tooltip" data-placement="top"
                                        title="Submit"
                                ><i class="fas fa-save"></i></button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import ValidationErrors from "../ValidationErrors";
import {publicPath} from "../../../../vue.config";

export default {
    name: "AllGatePassMember_Temp",
    components: {ValidationErrors},
    props: ['warning_message','success'],
    data: () => ({
        gatePassId:null,
        members: [],
        errors: [],
        validationErrors: null,
        isLoggedIn: false,
        member:null
    }),
    created() {
        if (window.Laravel.isLoggedin) {
            this.isLoggedIn = true;
            this.member = window.Laravel.user;
            this.getGatePass();
            // this.member_name = window.Laravel.user.email
        }else{
            console.log('Member Not Log In')
        }
    },
    beforeRouteEnter(to, from, next) {
        if (!window.Laravel.isLoggedin) {
            window.location.href = publicPath;
        }
        next();
    },
    methods: {
        doSubmit(id) {
            axios.put('/api/gate_pass/'+id,{is_active:1})
                    .then(resp => {
                        console.log('Success',resp.data)
                        this.success = 'Gate-Pass Save and Submitted Successfully';
                        this.getGatePass();
                    })
                    .catch(error => {
                        console.error(error.response);
                    })
        },
        getGatePass() {
            axios
                .get('/api/gate_pass?member_id='+this.member.id)
                .then(res => {
                    this.members = res.data.data;
                }).catch(error => {
                console.error(error)
            })
        }
    }
}
</script>

<style>
.modal-backdrop {
    opacity: 0.1 !important;
}
</style>
