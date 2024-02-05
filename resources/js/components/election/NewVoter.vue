<template>
    <div class="container">
        <div class="row">
            <link
                type="text/css"
                rel="stylesheet"
                :href="addProjectPath('/front/assets/css/voter-form.css')"
            />
            <div id="notification">
                <validation-errors :errors="validationErrors" :success="success"
                                   :warning_message="warning_message"></validation-errors>
            </div>
            <div class="col-sm-12">
                <!-- dash -->
                <div class="voter-form">
<!--                    <form class="needs-validation" @submit.prevent="submitForm" role="form" id="id-card-form" novalidate>-->

                    <form class="needs-validation" @submit.prevent="submitForm" role="form" id="new-voter" novalidate>
                        <div class="form-group row">
                            <label for="Election" class="col-sm-3 col-form-label">Election name</label>
                            <div class="col-sm-9">
                                <v-select class="lower_border" style="display: inline-block;"
                                          v-model="form.election_id"
                                          name="election_id"
                                          :options="active_election"
                                          :reduce="election => election.id"
                                          label="name"
                                ></v-select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="Member" class="col-sm-3 col-form-label">Member name</label>
                            <div class="col-sm-9">
                                <v-select class="lower_border"
                                          style="display: inline-block;"
                                          name="member_id"
                                          :options=organizations
                                          label="organization_name"
                                          @input="setCompanyOwners"
                                />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="Member" class="col-sm-3 col-form-label"
                            >Select Voter</label
                            >
                            <div class="col-sm-9">
                                <v-select class="lower_border"
                                          style="display: inline-block;"
                                          :options=company_owners
                                          label="name"
                                          @input="setVoter"
                                />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="voter" class="col-sm-3 col-form-label">Voter Name</label>
                            <div class="col-sm-9">
                                <input
                                    type="text"
                                    class="form-control"
                                    name="voter_name"
                                    v-model="voter.name"
                                    id="Votername"
                                    placeholder="Voter Name"
                                    disabled
                                />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="voter" class="col-sm-3 col-form-label">Voter Designation</label>
                            <div class="col-sm-9">
                                <input
                                    type="text"
                                    class="form-control"
                                    id="Voterdesignation"
                                    name="voter_designation"
                                    v-model="voter.designation"
                                    placeholder="Voter Designation"
                                    disabled
                                />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="voter_e_tin_no" class="col-sm-3 col-form-label">Voter E-Tin No.</label>
                            <div class="col-sm-3">
                                <input
                                    type="text"
                                    class="form-control"
                                    id="voter_e_tin_no"
                                    placeholder="Voter E-Tin No"
                                    name="voter_e_tin_no"
                                    v-model="member_detail.tin_number"
                                    disabled
                                />
                            </div>

                            <label for="voter" class="col-sm-3 col-form-label">e-TIN certificate</label>
                            <div class="col-sm-3">
                                <ImageTag alt="Voter Signature"
                                          name="no_upload"
                                          :src="member_detail.attach_e_tin_certificate" />
                                <!--                                <input
                                                                    type="file"
                                                                    class="form-control"
                                                                    id="Votersignature"
                                                                    placeholder="Voter Signature"
                                                                />-->
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="voter_tel" class="col-sm-3 col-form-label"
                            >Voter Telephone No.</label
                            >
                            <div class="col-sm-9">
                                <input
                                    type="text"
                                    class="form-control"
                                    id="voter_tel"
                                    placeholder="Voter Telephone"
                                    name="voter_tel"
                                    v-model="member_address.telephone_no"
                                    disabled
                                />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="voter_address" class="col-sm-3 col-form-label">Voter Address</label>
                            <div class="col-sm-9">
                                <input
                                    type="text"
                                    class="form-control"
                                    id="voter_address"
                                    placeholder="Voter Address"
                                    name="voter_address"
                                    v-model="member_address.address"
                                    disabled
                                />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="voter_mob" class="col-sm-3 col-form-label">Voter mobile No.</label>
                            <div class="col-sm-3">
                                <input
                                    type="text"
                                    class="form-control"
                                    id="voter_mob"
                                    placeholder="Voter mobile No."
                                    name="voter_mob"
                                    v-model="voter.mobile_no"
                                    disabled
                                />
                            </div>

                            <label for="voter_fax" class="col-sm-2 col-form-label">Voter Fax No.</label>
                            <div class="col-sm-4">
                                <input
                                    type="text"
                                    class="form-control"
                                    id="voter_fax"
                                    placeholder="Voter Fax No."
                                    name="voter_fax"
                                    v-model="member_address.fax_no"
                                    disabled
                                />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="voter" class="col-sm-3 col-form-label">Voter Email</label>
                            <div class="col-sm-9">
                                <input
                                    type="text"
                                    class="form-control"
                                    id="Voteremail"
                                    placeholder="Voter Email"
                                    name="voter_email"
                                    v-model="voter.email"
                                    disabled
                                />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="voter" class="col-sm-3 col-form-label">Voter Signature</label>
                            <div class="col-sm-3">
                                <ImageTag alt="Voter Signature"
                                          name="no_upload"
                                          :src="voter.attach_signature" @saveImage="saveImage" />
<!--                                <input
                                    type="file"
                                    class="form-control"
                                    id="Votersignature"
                                    placeholder="Voter Signature"
                                />-->
                            </div>

                            <label for="voter_image" class="col-sm-2 col-form-label">Voter Image</label>
                            <div class="col-sm-4">
                                <ImageTag alt="Voter Image"
                                          name="no_upload"
                                          :src="voter.attach_photograph" @saveImage="saveImage" />
<!--                                <input
                                    type="file"
                                    class="form-control"
                                    id="Voterimage"
                                    placeholder="Voter Image"
                                />-->
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="voter_location" class="col-sm-3 col-form-label">Voter Location</label>
                            <div class="col-sm-9">
                                <input
                                    type="text"
                                    class="form-control"
                                    id="voter_location"
                                    placeholder="Voter Location"
                                    name="voter_location"
                                    v-model="member_detail.place_of_enlistment"
                                    disabled
                                />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="voter" class="col-sm-3 col-form-label">Manager ID</label>
                            <div class="col-sm-9">
                                <v-select class="lower_border"
                                          style="display: inline-block;"
                                          :options=company_owners
                                          label="name"
                                          @input="setManager"
                                />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="manager_name" class="col-sm-3 col-form-label">Manager Name</label>
                            <div class="col-sm-9">
                                <input
                                    type="text"
                                    class="form-control"
                                    id="manager_name"
                                    placeholder="Manager Name"
                                    name="manager_name"
                                    v-model="manager.name"
                                    disabled
                                />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="manager_designation" class="col-sm-3 col-form-label"
                            >Manager Designation</label
                            >
                            <div class="col-sm-9">
                                <input
                                    type="text"
                                    class="form-control"
                                    id="manager_designation"
                                    placeholder="Manager Designaiton"
                                    name="manager_designation"
                                    v-model="manager.designation"
                                    disabled
                                />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="voter" class="col-sm-3 col-form-label">Date</label>
                            <div class="col-sm-3">
                                <input
                                    type="date"
                                    class="form-control"
                                    v-model="form.manager_date"
                                    id="managerdate"
                                    placeholder="Manager Date"
                                    name="manager_date"
                                />
                            </div>
                            <label for="voter" class="col-sm-2 col-form-label">Manager Signature</label>
                            <div class="col-sm-4">
                                <ImageTag alt="Voter Image"
                                          name="no_upload"
                                          :src="manager.attach_signature" />
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
import moment from "moment/moment";
import ValidationErrors from "../ValidationErrors";
import vSelect from "vue-select";
import ImageTag from "../ImageTag";

export default {
    name: "NewVoter",
    components: {ValidationErrors, moment, vSelect, ImageTag},
    data() {
        return {
            loading: false,
            errors: [],
            validationErrors: null,
            success: null,
            warning_message:null,
            election_name: [],
            organizations: [],
            voter:{
                name: null,
                designation: null,
                email: null,
                mobile_no: null,
                attach_photograph: null,
                attach_signature: null,
            },
            manager:{
                name: null,
                designation: null,
                attach_signature: null,
            },
            company_owners:[],
            member_address:{
                address:null,
                fax_no:null,
                telephone_no:null,
            },
            member_detail:{
                place_of_enlistment:null,
                tin_number:null,
                attach_e_tin_certificate:null,
            },
            active_election: [],
            form: {
                election_id:null,
                member_id:null,
                company_owner_id:null,
                manager_id:null,
                manager_date:new Date().toISOString().slice(0, 10),
            },
        }
    },
    created() {
        this.getVoter();
        this.getOrganizations();
        this.election_name = 'A New Election';
    },
    methods: {
        saveImage: function (event) {
            console.log(event.target.files[0])
            this.form[event.target.name] = event.target.files[0];
        },
        getOrganizations() {
            axios
                .get('/api/members/organizations_for_election')
                .then(res => {
                    this.organizations = res.data
                }).catch(error => {
                console.error(error.response)
            })
        },
        getVoter() {
            axios.get('/api/election/all/active')
                .then(res => {
                    this.active_election = res.data
                    // ths.form.election_id = this.
                    // this.form.members = this.form.members.map(v => v.organization_name);
                }).catch(error => {
                console.log('Error: ', error.response)
            })
        },
        setCompanyOwners(value) {
            console.log(value);
            this.form.member_id = value.id;
            this.company_owners = value.company_owners;
            // if(value.member_address.length) this.member_address = value.member_address[0];
            this.member_detail.place_of_enlistment = value.member_detail.place_of_enlistment;
            this.member_detail.tin_number = value.member_detail.tin_number;
            this.member_detail.attach_e_tin_certificate = value.member_detail.attach_e_tin_certificate;
            // if(this.member_address){
            //
            // }
            // this.company_owner.voter_address = value.member_address;
            // this.company_owner.voter_fax = value.member_address;
            // this.company_owner.voter_tel = value.member_address;
            // axios.get('/api/members/'+this.form.member_id+'/company_owners')
            //     .then(res => {
            //         this.company_owners = res.data.data
            //         // ths.form.election_id = this.
            //         // this.form.members = this.form.members.map(v => v.organization_name);
            //     }).catch(error => {
            //     console.log('Error: ', error.response)
            // })
        },
        setVoter(value) {
            this.voter = value
            this.form.company_owner_id = this.voter.id
            // console.log(value);
        },
        setManager(value) {
            this.manager = value;
            this.form.manager_id = this.manager.id
            // console.log(value);
        },
        // getVoter() {
        //     axios.get('/api/voter/' + this.$route.params.id)
        //         .then(res => {
        //             this.form = res.data.data
        //             // this.form.members = this.form.members.map(v => v.organization_name);
        //         }).catch(error => {
        //         console.log('Error: ', error.response)
        //     })
        // },
        getMembers() {
            axios
                .get('/api/members/organizations')
                .then(res => {
                    this.members = res.data
                }).catch(error => {
                console.error(error.response.data.message)
            })
        },
        submitForm: function () {
            console.log('Click');
            this.errors = [];
            if (!this.form.member_id) this.errors.push(["member_id", ["Select Member."]]);
            if (!this.form.election_id) this.errors.push(["election_id", ["Select Election."]]);
            if (!this.form.company_owner_id) this.errors.push(["company_owner_id", ["Select Voter."]]);
            if (!this.form.manager_id) this.errors.push(["manager_id", ["Select Manager."]]);
            if (!this.voter.name) this.errors.push(["voter_name", ["Voter Name Required."]]);

            if (this.errors.length) {
                // this.validationErrors = Object.assign({},this.errors)
                this.validationErrors = Object.fromEntries(this.errors)
            } else {
                this.validationErrors = null
                this.saveGatePass()
            }
        },
        saveGatePass: function () {
            this.loading = true;
            // const data = new FormData();
            let newVoter = document.getElementById('new-voter');
            let data = new FormData(newVoter);
            console.log(data)
            // data.set('date', moment(String(this.form.date)).format('YYYY-MM-DD'));
            if (this.form.manager_date) data.set('manager_date', moment(String(this.form.manager_date)).format('YYYY-MM-DD'));
            data.set('member_id', this.form.member_id);
            data.set('election_id', this.form.election_id);
            data.set('company_owner_id', this.form.company_owner_id);
            data.set('manager_id', this.form.manager_id);

            data.set('voter_name', this.voter.name);
            data.set('voter_designation', this.voter.designation);
            data.set('voter_address', this.member_address.address);
            data.set('voter_tel', this.member_address.telephone_no);
            data.set('voter_mob', this.voter.mobile_no);
            data.set('voter_fax', this.member_address.fax_no);
            data.set('voter_email', this.voter.email);
            data.set('voter_signature', this.voter.attach_signature);
            data.set('voter_image', this.voter.attach_photograph);
            data.set('voter_location', this.member_detail.place_of_enlistment);
            data.set('voter_e_tin_no', this.member_detail.tin_number);
            data.set('voter_e_tin_attachment', this.member_detail.attach_e_tin_certificate);

            data.set('manager_signature', this.manager.attach_signature);
            data.set('manager_name', this.manager.name);
            data.set('manager_designation', this.manager.designation);

            // data.set('id', this.$route.params.id);

            axios.post("/api/voter/", data).then(res => {
                this.success = 'Voter Updated Successfully';
                // this.selected_id_no = res.data.id
                // this.$bvModal.show('modal-make-payment')
                this.$router.push({name: "view-voter", params: { id: res.data.id}, query: {success: this.success}});
                // this.$router.push({name: "voters", params: { election_id: res.data.election_id}, query: {success: this.success}});
            }).catch(error => {
                if (error.response.status == 422) {
                    this.validationErrors = error.response.data.errors;
                } else {
                    this.warning_message = error.response.data.message;
                }
                console.error(error.response)
                // this.$nextTick(() => {
                //     this.$bvModal.hide('modal-make-payment')
                // })
            }).finally(() => {
                this.loading = false
                // done();
            });
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
