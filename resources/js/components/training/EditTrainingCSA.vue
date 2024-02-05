<template>
    <div class="container">
        <div class="row">
            <link
                type="text/css"
                rel="stylesheet"
                :href="addProjectPath('/front/assets/css/voter-form.css')"
            />
            <div id="notification">
                <validation-errors
                    :errors="validationErrors"
                    :success="success"
                    :warning_message="warning_message"
                ></validation-errors>
            </div>

            <div class="col-sm-12">
                <!-- dash -->
                <div class="voter-form">
                    <form
                        class="needs-validation"
                        @submit.prevent="submitForm"
                        role="form"
                        id="new-training"
                    >
                        <div class="form-group row">
                            <label for="Organization" class="col-sm-3 col-form-label"
                            >Name of the Organization:</label
                            >
                            <div class="col-sm-9">
                                <v-select
                                    class="lower_border"
                                    style="display: inline-block"
                                    name="member_id"
                                    :options="organizations"
                                    label="organization_name"
                                    @input="setCompanyOwners"
                                />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="organization_address" class="col-sm-3 col-form-label"
                            >Organization Address:
                            </label>
                            <div class="col-sm-9">
                                <input
                                    type="text"
                                    class="form-control"
                                    id="organization_address"
                                    placeholder="Organization Address"
                                    name="organization_address"
                                    v-model="form.organization_address"
                                />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="voter" class="col-sm-3 col-form-label">Select Manager Name</label>
                            <div class="col-sm-9">
                                <v-select class="lower_border"
                                          style="display: inline-block;"
                                          v-model="form.director_id"
                                          :options=company_owners
                                          :reduce="company_owners => company_owners.id"
                                          label="name"
                                          name="director_id"
                                />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="Participant" class="col-sm-3 col-form-label"
                            >Select Participant:
                            </label>
                            <div class="col-sm-9">
                                <v-select class="lower_border"
                                          style="display: inline-block;"
                                          v-model="form.company_owner"
                                          :options=company_owners
                                          label="name"
                                          name="participant_id"
                                          @input="setParticipant"
                                />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="Participant" class="col-sm-3 col-form-label"
                            >Name of the Participant:
                            </label>
                            <div class="col-sm-9">
                                <input
                                    type="text"
                                    class="form-control"
                                    id="Participant"
                                    placeholder="Participant name"
                                    name="participant_name"
                                    v-model="form.participant_name"
                                    disabled
                                />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="Designation" class="col-sm-3 col-form-label"
                            >Designation:
                            </label>
                            <div class="col-sm-9">
                                <input
                                    type="text"
                                    class="form-control"
                                    id="Designation"
                                    placeholder="Designation Name"
                                    name="participant_designation"
                                    v-model="form.participant_designation"
                                />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="ParticipantMobile" class="col-sm-3 col-form-label"
                            >Participant's Mobile.</label
                            >
                            <div class="col-sm-9">
                                <input
                                    type="number"
                                    class="form-control"
                                    id="ParticipantMobile"
                                    placeholder="Participant Mobile"
                                    name="participant_mobile"
                                    v-model="form.participant_mobile"
                                />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-sm-3 col-form-label">Email(optional)</label>
                            <div class="col-sm-9">
                                <input
                                    type="text"
                                    class="form-control"
                                    id="email"
                                    placeholder="Participant Email"
                                    name="participant_email"
                                    v-model="form.participant_email"
                                />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="id_card_id" class="col-sm-3 col-form-label"
                            >BAFFA valid ID card No:</label
                            >
                            <div class="col-sm-9">
                                <!--                                <input
                                                                    type="number"
                                                                    class="form-control"
                                                                    id="id_card_id"
                                                                    placeholder="BAFFA valid ID card No"
                                                                    name="id_card_id"
                                                                    v-model="form.id_card_id"
                                                                />-->
                                <v-select class="lower_border"
                                          style="display: inline-block;"
                                          v-model="form.id_card_id"
                                          :options=id_card_ids
                                          :reduce="id_card_ids => id_card_ids.id"
                                          label="id_card_number"
                                          name="id_card_id"
                                />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="previous_caab_id_no" class="col-sm-3 col-form-label"
                            >Previous Caab Id No.</label
                            >
                            <div class="col-sm-9">
                                <input
                                    type="number"
                                    class="form-control"
                                    id="previous_caab_id_no"
                                    placeholder="Previous Caab Id No"
                                    name="previous_caab_id_no"
                                    v-model="form.previous_caab_id_no"
                                />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="Participant" class="col-sm-3 col-form-label"
                            >Participant’s photograph:
                            </label>
                            <div class="col-sm-9">
                                <b-form-file accept=".jpg, .png, .gif" v-on:change="saveImage" name="applicant_photograph_attachment"></b-form-file>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="applicant_national_id_card_number" class="col-sm-3 col-form-label"
                            >Participant’s National ID/Passport/Birth certificate:
                            </label>
                            <div class="col-sm-5">
                                <input
                                    type="text"
                                    class="form-control"
                                    id="applicant_national_id_card_number"
                                    placeholder="National ID/ Passport/ Birth certificate Number"
                                    name="applicant_national_id_card_number"
                                    v-model="form.applicant_national_id_card_number"
                                />
                            </div>
                            <div class="col-sm-4">
                                <b-form-file accept=".jpg, .png, .gif" v-on:change="saveImage" name="applicant_national_id_card_attachment"></b-form-file>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="applicant_police_verification_date" class="col-sm-3 col-form-label"
                            >Participant’s Police Verification/Clearance Certificate:
                            </label>
                            <div class="col-sm-5">
                                <b-form-datepicker id="applicant_police_verification_date" v-model="form.applicant_police_verification_date" class="mb-2"></b-form-datepicker>
                                <!--                                <input
                                                                    type="date"
                                                                    class="form-control"
                                                                    id="applicant_police_verification_date"
                                                                    placeholder="Police Verification/ Clearance Certificate Date"
                                                                    name="applicant_police_verification_date"
                                                                    v-model="form.applicant_police_verification_date"
                                                                />-->
                            </div>
                            <div class="col-sm-4">
                                <b-form-file accept=".jpg, .png, .gif" v-on:change="saveImage" name="applicant_police_verification_attachment"></b-form-file>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-10 offset-sm-6 p-10">
                                <button type="submit" class="btn btn-primary">Confirm</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import moment from "moment";
import ValidationErrors from "../ValidationErrors";
import vSelect from "vue-select";
import ImageTag from "../ImageTag";

export default {
    name: "EditTrainingCSA",
    components: {ValidationErrors, moment, vSelect, ImageTag},
    data() {
        return {
            isLoggedIn: false,
            user: null,
            created_user_id:null,
            updated_user_id:null,
            loading: false,
            errors: [],
            validationErrors: null,
            success: null,
            warning_message: null,
            election_name: [],
            organizations: [],
            company_owners: [],
            id_card_ids: [],
            form: {
                applicant_photograph: null,
                company_owner:null,
                member_id: null,
                participant_id: null,
                participant_name: null,
                director_id: null,
                applicantion_date: new Date().toISOString().slice(0, 10),
                applicant_police_verification_date: new Date().toISOString().slice(0, 10),
                delivery_date: new Date().toISOString().slice(0, 10),
                organization_address: null
            }
        };
    },
    created() {
        this.getOrganizations();
        if (window.Laravel.isLoggedin) {
            this.isLoggedIn = true;
            this.user = window.Laravel.user;
            this.created_user_id = this.user.id;
            // this.member_name = window.Laravel.user.email
            this.getTraining()
        } else {
            console.log('Member Not Log In')

        }
    },
    methods: {
        getOrganizations() {
            axios
                .get("/api/members/organizations_for_election")
                .then((res) => {
                    this.organizations = res.data;
                })
                .catch((error) => {
                    console.error(error.response);
                });
        },
        getValidIdCard(member_id) {
            axios
                .get("/api/members/" + member_id + "/active_id_card")
                .then((res) => {
                    this.id_card_ids = res.data;
                })
                .catch((error) => {
                    console.error(error.response);
                });
        },
        reset: function () {
            this.id_card_ids = [];
            this.form.member_id = null;
            this.form.participant_id = null;
            this.form.participant_name = null;
            this.form.director_id = null;
            this.form.organization_address = null;
            this.form.company_owner = null;
            this.company_owners = [];
            // this.form = Object.assign({}, initFormData)
            // for(let field in this.formData){
            //     this.formData[field] = null;
            // }
        },
        setCompanyOwners(value) {
            this.reset();
            console.log(value);
            this.getValidIdCard(value.id);
            this.form.member_id = value.id;
            this.company_owners = value.company_owners;
            if (value.member_address.length) this.form.organization_address = value.member_address[0].address;

        },
        setParticipant(value) {
            console.log(value);
            if(value){
                this.form.participant_id = value.id;
                this.form.participant_name = value.name;
            }else{
                this.form.participant_id = null;
                this.form.participant_name = null;
            }
        },
        submitForm: function () {
            console.log("Click");
            this.errors = [];
            if (!this.form.member_id) this.errors.push(["member_id", ["Select Member."]]);
            if (!this.form.participant_id) this.errors.push(["participant_id", ["Select Participant."]]);
            if (!this.form.director_id) this.errors.push(["director_id", ["Select Director."]]);
            if (!this.form.participant_name) this.errors.push(["participant_name", ["Participant Name Required."]]);

            if (this.errors.length) {
                // this.validationErrors = Object.assign({},this.errors)
                this.validationErrors = Object.fromEntries(this.errors);
            } else {
                this.validationErrors = null;
                this.saveGatePass();
            }
        },
        getTraining() {
            axios
                .get("/api/training/"  + this.$route.params.id)
                .then((res) => {
                    this.form = res.data.data;
                })
                .catch((error) => {
                    console.error("My Error: " + error);
                });
        },
        saveGatePass: function () {
            this.loading = true;
            // const data = new FormData();
            let newVoter = document.getElementById("new-training");
            let data = new FormData(newVoter);
            // data.set('date', moment(String(this.form.date)).format('YYYY-MM-DD'));
            // if (this.form.manager_date)
            //     data.set(
            //         "manager_date",
            //         moment(String(this.form.manager_date)).format("YYYY-MM-DD")
            //     );
            data.set("member_id", this.form.member_id);
            data.set("organization_address", this.form.organization_address);
            data.set("participant_id", this.form.participant_id);
            data.set("participant_name", this.form.participant_name);
            data.set("director_id", this.form.director_id);
            data.set("member_id", this.form.member_id);
            data.set("id_card_id", this.form.id_card_id);
            data.set("training_name", 'csa');
            data.set("applicantion_date", this.form.applicantion_date);
            data.set("applicant_police_verification_date", this.form.applicant_police_verification_date);
            data.set("applicant_national_id_card_number", this.form.applicant_national_id_card_number);
            data.set("delivery_date", this.form.delivery_date);
            if(this.created_user_id) data.set('created_user_id', this.created_user_id);

            // data.set('id', this.$route.params.id);

            axios
                .post("/api/training", data)
                .then((res) => {
                    this.success = "Training Updated Successfully";
                    // this.selected_id_no = res.data.id
                    // this.$bvModal.show('modal-make-payment')

                    this.$router.push({
                        name: "all-csa-training",
                        query: {success: this.success},
                    });

                    // this.$router.push({name: "voters", params: { election_id: res.data.election_id}, query: {success: this.success}});
                })
                .catch((error) => {
                    if (error.response.status == 422) {
                        this.validationErrors = error.response.data.errors;
                    } else {
                        this.warning_message = error.response.data.message;
                    }
                    console.error(error.response);
                    // this.$nextTick(() => {
                    //     this.$bvModal.hide('modal-make-payment')
                    // })
                })
                .finally(() => {
                    this.loading = false;
                    // done();
                });
        },
        saveImage: function (event) {
            console.log(event.target.files[0])
            this.form[event.target.name] = event.target.files[0];
        }
    }
};
</script>

<style scoped>
.lower_border {
    width: inherit;
    border: none;
    /*border-bottom: 1px solid black;*/
    padding: 5px 10px;
    outline: none;
}
</style>

