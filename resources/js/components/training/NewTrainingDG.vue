<template>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="card" v-if="visibility">
                    <div class="card-header text-center">
                        <h2>DG Training</h2>
                    </div>
                    <div class="card-body">
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
                        <div class="voter-form">
                            <form
                                class="needs-validation"
                                @submit.prevent="submitForm"
                                role="form"
                                id="new-training"
                            >
                                <div class="form-group row">
                                    <label for="Participant" class="col-sm-3 col-form-label"
                                    >Category:
                                    </label>
                                    <div class="col-sm-8">
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="Category"
                                            name="category_name"
                                            placeholder="Category name"
                                            v-model="form.category_name"
                                        />
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="Participant" class="col-sm-3 col-form-label">Title: </label>
                                    <div class="col-sm-8">
                                        <b-form-radio-group id="radio-group-2" v-model="form.title" name="title">
                                            <b-form-radio value="Mr.">Mr.</b-form-radio>
                                            <b-form-radio value="Ms.">Ms.</b-form-radio>
                                            <b-form-radio value="Mrs.">Mrs.</b-form-radio>
                                            <b-form-radio value="Dr.">Dr.</b-form-radio>
                                            <b-form-radio value="Prof.">Prof.</b-form-radio>
                                        </b-form-radio-group>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="Participant" class="col-sm-3 col-form-label"
                                    >Name of the Participant:
                                    </label>
                                    <div class="col-sm-8">
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="Participant"
                                            name="participant_name"
                                            placeholder="Participant name"
                                            v-model="form.participant_name"
                                        />
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="Participant" class="col-sm-3 col-form-label"
                                    >Participant Signature:
                                    </label>
                                    <div class="col-sm-8">
                                        <ImageTag alt="Participant Signature"
                                                  name="applicant_signature"
                                                  :src="form.applicant_signature" />
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="Designation" class="col-sm-3 col-form-label"
                                    >Designation:
                                    </label>
                                    <div class="col-sm-8">
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="Designation"
                                            name="participant_designation"
                                            v-model="form.participant_designation"
                                            placeholder="Designation Name"
                                        />
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="Organization" class="col-sm-3 col-form-label"
                                    >Name of the Organization:</label
                                    >
                                    <div v-if="is_member" class="col-sm-8">
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="Participant"
                                            placeholder="Participant name"
                                            name="participant_name"
                                            v-model="form.organization_name"
                                            disabled
                                        />
                                    </div>
                                    <div v-else class="col-sm-8">
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
                                    <div class="col-sm-8">
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
                                    <label for="voter" class="col-sm-3 col-form-label"
                                    >Select Owner's Name</label
                                    >
                                    <div class="col-sm-8">
                                        <v-select
                                            class="lower_border"
                                            style="display: inline-block"
                                            v-model="form.director_id"
                                            :options="company_owners"
                                            :reduce="(company_owners) => company_owners.id"
                                            label="name"
                                            name="director_id"
                                        />
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="ParticipantMobile" class="col-sm-3 col-form-label"
                                    >Participant's Mobile.</label
                                    >
                                    <div class="col-sm-8">
                                        <input
                                            type="number"
                                            class="form-control"
                                            id="ParticipantMobile"
                                            name="participant_mobile"
                                            placeholder="Participant Mobile"
                                            v-model="form.participant_mobile"
                                        />
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="email" class="col-sm-3 col-form-label">Email(optional)</label>
                                    <div class="col-sm-8">
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="email"
                                            name="participant_email"
                                            placeholder="Participant Email"
                                            v-model="form.participant_email"
                                        />
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="participant_dob" class="col-sm-3 col-form-label">
                                        Date Of Birth.</label
                                    >
                                    <div class="col-sm-8">
                                        <b-form-datepicker
                                            id="participant_dob"
                                            name="participant_dob"
                                            v-model="form.participant_dob"
                                            class="mb-2"
                                        ></b-form-datepicker>
                                    </div>
                                </div>
                                <div class="form-group row">

                                    <label for="AcademicQualification" class="col-sm-3 col-form-label">
                                        Academic Qualification.</label
                                    >
                                    <div class="col-sm-8">
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="AcademicQualification"
                                            name="participant_qualification"
                                            v-model="form.participant_qualification"
                                            placeholder="Academic Qualification"
                                        />
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="caabid" class="col-sm-3 col-form-label"
                                    >Brief Experience:</label
                                    >
                                    <div class="col-sm-8">
            <textarea
                class="form-control"
                id="exampleFormControlTextarea1"
                name="participant_experience"
                v-model="form.participant_experience"
                rows="3"
            ></textarea>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm">
                                        <button v-if="visibility" type="submit" class="btn btn-primary">Confirm</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card" v-else>
                    <div class="card-header text-center">
                        <h2>DG Training is Disabled</h2>
                    </div>
                    <div class="card-body" style="min-height: 300px;"></div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import ValidationErrors from "../ValidationErrors";
import moment from "moment/moment";
import vSelect from "vue-select";
import ImageTag from "../ImageTag";

export default {
    name: "NewTrainingDG",
    components: {ValidationErrors, moment, vSelect, ImageTag},
    props: ['is_member'],
    data() {
        return {
            visibility: false,
            isLoggedIn: false,
            user: null,
            created_user_name: null,
            created_user_id: null,
            updated_user_id: null,
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
                title: "Mr.",
                applicant_photograph: null,
                company_owner: null,
                member_id: null,
                participant_id: null,
                participant_name: null,
                director_id: null,
                applicantion_date: new Date().toISOString().slice(0, 10),
                participant_dob: new Date().toISOString().slice(0, 10),
                delivery_date: new Date().toISOString().slice(0, 10),
                organization_address: null,
            },
        };
    },
    created() {
        if (window.Laravel.isLoggedin) {
            this.isLoggedIn = true;
            this.user = window.Laravel.user;
            this.checkVisibility('dg');
            if(this.is_member){
                this.created_user_name = this.user.username;
                this.setCompanyOwnersForMembers(this.user)
            }
            else{
                this.created_user_id = this.user.id;
                this.getOrganizations();
            }
        } else {
            console.log("Member Not Log In");
        }
    },
    methods: {
        checkVisibility(type) {
            axios
                .get("/api/training_names/"+type)
                .then((res) => {
                    this.visibility = res.data.visibility;
                })
                .catch((error) => {
                    console.error(error.response);
                });
        },
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
        reset: function () {
            this.id_card_ids = [];
            this.form.member_id = null;
            // this.form.participant_id = null;
            // this.form.participant_name = null;
            this.form.director_id = null;
            this.form.organization_address = null;
            this.form.company_owner = null;
            this.company_owners = [];
            // this.form = Object.assign({}, initFormData)
            // for(let field in this.formData){
            //     this.formData[field] = null;
            // }
        },
        getMemberInfo(member_id) {
            axios
                .get("/api/members/" + member_id + "/edit")
                .then((res) => {
                    console.log(res.data.data)
                    this.company_owners = res.data.data.company_owners;
                    if (res.data.data.member_address.length) this.form.organization_address = res.data.data.member_address[0].address;
                })
                .catch((error) => {
                    console.error(error);
                });
        },
        setCompanyOwners(value) {
            this.reset();
            console.log(value);
            // this.getValidIdCard(value.id);
            this.form.member_id = value.id;
            this.company_owners = value.company_owners;
            if (value.head_office) this.form.organization_address = value.head_office.address;
            // if (value.member_address.length) this.form.organization_address = value.member_address[0].address;
        },
        setCompanyOwnersForMembers(value) {
            this.reset();
            console.log(value);
            this.form.member_id = value.id;
            this.form.organization_name = value.organization_name;
            // this.getValidIdCard(value.id);
            this.getMemberInfo(value.id);
        },
        // setParticipant(value) {
        //     console.log(value);
        //     if(value){
        //         this.form.participant_id = value.id;
        //         this.form.participant_name = value.name;
        //     }else{
        //         this.form.participant_id = null;
        //         this.form.participant_name = null;
        //     }
        // },
        submitForm: function () {
            this.errors = [];
            if (!this.form.member_id) this.errors.push(["member_id", ["Select Member."]]);
            if (!this.form.director_id) this.errors.push(["director_id", ["Select Owner."]]);
            if (!this.form.participant_mobile) this.errors.push(["participant_mobile", ["Participant Mobile Required."]]);
            if (!this.form.participant_name)
                this.errors.push(["participant_name", ["Participant Name Required."]]);

            if (this.errors.length) {
                // this.validationErrors = Object.assign({},this.errors)
                this.validationErrors = Object.fromEntries(this.errors);
            } else {
                this.validationErrors = null;
                this.saveGatePass();
            }
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
            // data.set("participant_id", this.form.participant_id);
            data.set("participant_name", this.form.participant_name);
            data.set("director_id", this.form.director_id);
            data.set("member_id", this.form.member_id);
            // data.set("id_card_id", this.form.id_card_id);
            data.set("training_name", "dg");
            data.set("applicantion_date", this.form.applicantion_date);
            // data.set("applicant_police_verification_date", this.form.applicant_police_verification_date);
            // data.set("applicant_national_id_card_number", this.form.applicant_national_id_card_number);
            data.set("delivery_date", this.form.delivery_date);
            if (this.created_user_id) data.set("created_user_id", this.created_user_id);
            if (this.created_user_name) data.set("created_user_name", this.created_user_name);

            // data.set('id', this.$route.params.id);

            axios
                .post("/api/training", data)
                .then((res) => {
                    this.success = "Training Updated Successfully";
                    // this.selected_id_no = res.data.id
                    // this.$bvModal.show('modal-make-payment')
                    if (!this.is_member)
                        this.$router.push({
                            name: "all-dg-training",
                            query: {success: this.success},
                        });
                    else
                        this.$router.push({
                            name: "all-dg-training_member",
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
            console.log(event.target.files[0]);
            this.form[event.target.name] = event.target.files[0];
        },
    },
};

/*$(function () {
  $(".sev_check").click(function (e) {
    $(".sev_check").not(this).prop("checked", false);
  });
});*/
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
