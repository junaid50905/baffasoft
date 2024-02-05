<template>
    <div class="container">
        <h4 class="mt-5">All Election:</h4>
        <table class="table mt-5">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Session</th>
                <th scope="col">Election Date</th>
                <th scope="col">Status</th>
                <th scope="col">Submission Deadline</th>
                <th scope="col">Download</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(election,i) in elections">
                <th scope="row">{{ ++i }}</th>
                <td>{{ election.name }}</td>
                <td>{{ election.election_session }}</td>
                <td>{{ election.election_date }}</td>
                <td>{{ election.status }}</td>
                <td>{{ election.nomination_from_submission_deadline }}</td>
                <td>
                    <router-link title="Non-Voter List"
                        :to="{name: 'voters_download',query:{'list':'due_list'},params:{'election_id':election.id}}" class="btn btn-primary btn-sm">
                        NV
                    </router-link>
                    <router-link title="Preliminary Voter List"
                        :to="{name: 'voters_download',query:{'list':'preliminary_list'},params:{'election_id':election.id}}" class="btn btn-primary btn-sm">
                        P
                    </router-link>
                    <router-link title="Non Preliminary Voter List"
                        :to="{name: 'voters_download',query:{'list':'non_preliminary_list'},params:{'election_id':election.id}}" class="btn btn-primary btn-sm">
                        NP
                    </router-link>
                </td>
                <td>
                    <span v-if="checkAccess('assign-member-for-vote')">
                        <button v-if="election.status == 'Pending'" class="btn btn-icon"
                                @click="editOwner(election)"><i class="fa fa-edit"></i></button>
                        <button v-if="election.status == 'Pending'" class="btn btn-success btn-sm"
                                @click="assignMembers(election.id)">Assign Members
                        </button>
                    </span>
                    <!--                    <span v-if="checkAccess('edit_renew_member')">-->
                    <!--                        <router-link-->
                    <!--                            v-if="row.item.status == 'Active'"-->
                    <!--                            :to="{name: 'edit-member',params: { id: row.item.member_id}, query: {only_edit:'Yes'}}"-->
                    <!--                            class="btn btn-icon edit" title="Edit Member"-->
                    <!--                            data-toggle="tooltip" data-placement="top"><i class="fas fa-edit"></i>-->
                    <!--                        </router-link>-->
                    <!--                    </span>-->
                    <router-link
                        v-if="election.status == 'Verified' || election.status == 'Inspected' || election.status == 'Active' || election.status == 'Banned'" title="Voters"
                        :to="{name: 'voters',params:{'election_id':election.id}}" class="btn btn-success btn-sm">
                        <i class="fas fa-list"></i>
                    </router-link>
                    <span v-if="checkAccess('vote-casting-dhk')"><router-link
                        v-if="election.status == 'Active'" title="Dhaka Vote Casting"
                        :to="{name: 'dhaka_vote'}" class="btn btn-primary btn-sm">
                        D
                    </router-link></span>
                    <span v-if="checkAccess('vote-casting-ctg')"><router-link
                        v-if="election.status == 'Active'" title="Chattogram Vote Casting"
                        :to="{name: 'chattogram_vote'}" class="btn btn-primary btn-sm">
                        C
                    </router-link></span>
                    <span><router-link
                        v-if="election.status == 'Active'" title="Pie Chart" target="_blank"
                        :to="{name: 'admin_election_pie_chart'}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-chart-pie"></i>
                    </router-link></span>
                </td>
            </tr>
            </tbody>
        </table>
        <form v-if="checkAccess('new-election')" class="mt-5" @submit.prevent="submitForm" role="form" id="election-form" autocomplete="off"
              enctype="multipart/form-data">
            <div id="notification">
                <validation-errors :errors="validationErrors" :success="success"
                                   :warning_message="warning_message"></validation-errors>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input v-model="formData.name" type="text" class="form-control" name="name"
                               id="name">
                    </div>
                    <div class="form-group">
                        <label for="election_session">Session:</label>
                        <input v-model="formData.election_session" type="text" class="form-control"
                               name="election_session"
                               id="election_session">
                    </div>
                    <div class="form-group">
                        <label for="election_date">Election Date:</label>
                        <input v-model="formData.election_date" type="date" class="form-control" name="election_date"
                               id="election_date">
                    </div>
                    <div class="form-group">
                        <label for="nomination_from_submission_deadline">Voter Nomination Form Submission Deadline:</label>
                        <input v-model="formData.nomination_from_submission_deadline" type="date" class="form-control"
                               name="nomination_from_submission_deadline" id="nomination_from_submission_deadline">
                    </div>



                    <div class="form-group">
                        <label for="chairman_name">Chairman Name:</label>
                            <input
                                type="text"
                                class="form-control"
                                id="chairman_name"
                                name="chairman_name"
                                v-model="formData.chairman_name"
                                placeholder="Chairman Name"
                            />
                    </div>
                    <div class="form-group">
                        <label for="Participant">Chairman Signature:</label>
                            <ImageTag alt="Chairman Signature" name="attachment_chairman_signature" :src="formData.attachment_chairman_signature" />
                    </div>



                </div>
            </div>
            <div class="row">
                <div class="col-6 text-center">
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>
                <div class="col-6 text-center">
                    <button type="reset" class="btn btn-secondary" @click="resetForm">Cancel</button>
                </div>
                <div id="loader" v-if="loading"
                     v-bind:style="{'backgroundImage': 'url(' + addProjectPath('/assets/img/ajax-loader.gif') + ')'}"></div>
            </div>
        </form>
    </div>
</template>

<script>
import ImageTag from "../ImageTag";
import ValidationErrors from "../ValidationErrors";
import moment from "moment";

export default {
    name: "AllElection",
    components: {ImageTag, ValidationErrors, moment},
    data: () => ({
        loading: false,
        errors: [],
        success: null,
        warning_message: null,
        validationErrors: null,
        date_of_today: new Date(),
        election: 1,
        elections: [],
        countries: [],
        formData: {},
        initFromData: {
            id: null,
            name: null,
            election_session: null,
            chairman_name: null,
            attachment_chairman_signature: null,
            election_date: new Date().toISOString().slice(0, 10),
            nomination_from_submission_deadline: new Date().toISOString().slice(0, 10)
        }
    }),
    // computed:{
    // firmName: function (){
    //     return 'election['+this.firmTypes+'][attach_signature]'
    // }
    // },
    created: function () {
        this.getElections();
        // this.getCountries();
    },
    methods: {
        saveImage: function (event) {
            this.formData[event.target.name] = event.target.files[0];
        },
        editOwner(election) {
            console.log(election)
            this.formData = Object.assign({}, election);
            // this.formData = election;
            this.formData.election_date = moment(String(this.formData.election_date), 'DD-MM-YYYY').format('YYYY-MM-DD');
            this.formData.nomination_from_submission_deadline = moment(String(this.formData.nomination_from_submission_deadline), 'DD-MM-YYYY').format('YYYY-MM-DD');

            window.scroll(0, 500)
        },
        assignMembers(id) {
            if (confirm("Do you really want to Assign Member?")) {
                this.loading = true;
                axios
                    .get('/api/election/' + id)
                    .then(res => {
                        // this.showMessage = true;
                        this.success = res.data;
                        // this.getMembers();
                        this.success = 'Voter Assigned Successfully';
                        this.getElections();
                    }).catch(error => {
                        console.error(error.response.data.message)
                    }).finally(() => {
                        this.loading = false
                    });
            }
        },
        getElections() {
            axios
                .get('/api/election')
                .then(res => {
                    this.elections = res.data.data
                }).catch(error => {
                console.error(error.response)
            })
        },
        getCountries() {
            axios
                .get('/api/members/countries')
                .then(res => {
                    this.countries = res.data
                }).catch(error => {
                console.error(error.response.data.message)
            })
        },
        resetForm() {
            // if shallow copy
            this.formData = Object.assign({}, this.initFromData);
            // if deep copy
            // this.formData = JSON.parse(JSON.stringify(this.initFromData));
        },
        submitForm: function () {
            this.errors = [];
            // if (!this.formData.username) this.errors.push(["username", ["Name required."]]);
            // if (!this.formData.email) this.errors.push(["email", ["Email required."]]);
            if (!this.formData.name) this.errors.push(["name", ["Name required."]]);
            if (!this.formData.election_session) this.errors.push(["election_session", ["Election Session required."]]);
            if (this.errors.length) {
                // this.validationErrors = Object.assign({},this.errors)
                this.validationErrors = Object.fromEntries(this.errors)
            } else {
                this.loading = true;
                this.saveMemberDetails()
            }
        },
        saveMemberDetails: function () {
            // const data = new FormData();
            let myForm = document.getElementById('election-form');
            let data = new FormData(myForm);
            data.set('election_date', moment(String(this.formData.election_date)).format('YYYY-MM-DD'));
            data.set('nomination_from_submission_deadline', moment(String(this.formData.nomination_from_submission_deadline)).format('YYYY-MM-DD'));
            data.append('id', this.formData.id);
            axios.post("/api/election", data).then(res => {
                this.success = 'Election Updated Successfully';
                this.validationErrors = null;
                this.getElections();
                this.resetForm();
                // this.success = 'Member Created';
                // this.$router.push({
                //     name: "all-election",
                //     query: {success: this.success}
                // });
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
#loader {
    /* Loader Div Class */
    position: fixed;
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
