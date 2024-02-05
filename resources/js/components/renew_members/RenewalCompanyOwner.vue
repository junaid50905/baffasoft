<template>
    <div class="container">

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header text-light bg-secondary bg-gradient"><h4 class="text-center">Company Owners
                        Information (Directors/Partners/Proprietor):</h4></div>
                    <div class="card-body">
                        <table class="table mt-5">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Designation</th>
                                <th scope="col">Signatory</th>
                                <th scope="col">Nominate</th>
                                <th scope="col">Authorized</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(company_owner,i) in company_owners">
                                <th scope="row">{{ ++i }}</th>
                                <td>{{ company_owner.name }}</td>
                                <td>{{ company_owner.designation }}</td>
                                <td>{{ company_owner.signatory }}</td>
                                <td>{{ company_owner.nominate_for_vote }}</td>
                                <td>{{ company_owner.authorized_person }}</td>
                                <td>
                                    <span v-if="is_member || checkAccess('new_company_owner')">
                                        <button v-if="!company_owner.is_active" class="btn btn-dark btn-sm" @click="editOwner(company_owner)">EDIT</button>
                                        <span v-if="company_owner.renew_member_status == 'Active'"><button v-if="!company_owner.is_active" class="btn btn-primary btn-sm" @click="activeOwner(company_owner.id)">Active</button></span>
                                    </span>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-sm-12" v-if="checkAccess('new_company_owner') || is_member">
                <div class="card">
                    <div class="card-body">
                        <form class="mt-5" @submit.prevent="submitForm" role="form" id="company-owner" autocomplete="off"
                              enctype="multipart/form-data">
                            <div id="notification">
                                <validation-errors :errors="validationErrors" :success="success"
                                                   :warning_message="warning_message"></validation-errors>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Name:</label>
                                        <input v-model="formData.name" type="text" class="form-control" name="name"
                                               id="exampleInputEmail1">
                                    </div>
                                    <div class="form-group">
                                        <label for="designation">Designation:</label>
                                        <input v-model="formData.designation" type="text" class="form-control" name="designation"
                                               id="designation">
                                    </div>
                                    <div class="form-group">
                                        <label for="nid_no">NID No:</label>
                                        <input v-model="formData.nid_no" type="text" class="form-control" name="nid_no" id="nid_no">
                                    </div>
                                    <div class="form-group">
                                        <label for="attach_nid">Attach NID:</label>
                                        <ImageTag alt="attach_nid"
                                                  name="attach_nid"
                                                  :src="formData.attach_nid" @saveImage="saveImage"/>
                                        <!--                <input type="file" class="form-control" name="attach_nid" id="attach_nid">-->
                                    </div>
                                    <div class="form-group">
                                        <label for="educational_qualification">Educational Qualification:</label>
                                        <input v-model="formData.educational_qualification" type="text" class="form-control"
                                               name="educational_qualification" id="educational_qualification">
                                    </div>
                                    <div class="form-group">
                                        <label for="attach_educational_qualification">Attach Educational Certificate:</label>
                                        <ImageTag alt="attach_educational_qualification"
                                                  name="attach_educational_qualification"
                                                  :src="formData.attach_educational_qualification" @saveImage="saveImage"/>
                                        <!--                <input type="file" class="form-control" name="attach_educational_qualification" id="exampleInputEmail1">-->
                                    </div>

                                    <div class="form-group">
                                        <label for="attach_photograph">Photograph:</label>
                                        <ImageTag alt="attach_photograph"
                                                  name="attach_photograph"
                                                  :src="formData.attach_photograph" @saveImage="saveImage"/>
                                        <!--                <input type="file" class="form-control" name="attach_photograph"  id="attach_photograph">-->
                                    </div>

                                    <fieldset class="form-group">
                                        <label for="nominate_for_vote">Nominate For Vote:</label>
                                        <div class="row">
                                            <div class="col-sm-10">
                                                <div class="form-check">
                                                    <input class="form-check-input" v-model="formData.nominate_for_vote" type="radio"
                                                           name="nominate_for_vote" id="nominate_for_vote1" value="1" checked>
                                                    <label class="form-check-label" for="nominate_for_vote1"> Yes </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" v-model="formData.nominate_for_vote" type="radio"
                                                           name="nominate_for_vote" id="nominate_for_vote2" value="0">
                                                    <label class="form-check-label" for="nominate_for_vote2"> No </label>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="mobile_no">Mobile No:</label>
                                        <input v-model="formData.mobile_no" type="text" class="form-control" name="mobile_no"
                                               id="mobile_no">
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email:</label>
                                        <input v-model="formData.email" type="text" class="form-control" name="email" id="email">
                                    </div>
                                    <div class="form-group">
                                        <label for="nationality_id">Nationality:</label>
                                        <select class="form-select form-control" aria-label="Default"
                                                name="nationality_id">
                                            <option v-for="country in countries" :selected="country.id === formData.nationality_id"
                                                    :key="country.id" :value="country.id">{{ country.name }}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="attach_signature">Specific Signature:</label>
                                        <ImageTag alt="attach_signature"
                                                  name="attach_signature"
                                                  :src="formData.attach_signature" @saveImage="saveImage"/>
                                    </div>
                                    <div class="form-group">
                                        <label for="experience_year">Experience Year:</label>
                                        <input type="text" class="form-control" name="experience_year" id="experience_year">
                                    </div>
                                    <div class="form-group">
                                        <label for="attach_experience_certificate">Attach Experience Certificate:</label>
                                        <ImageTag alt="attach_experience_certificate" name="attach_experience_certificate"
                                                  :src="formData.attach_experience_certificate" @saveImage="saveImage"/>
                                    </div>
                                    <fieldset class="form-group">
                                        <label for="signatory">Signatory:</label>
                                        <div class="row">
                                            <div class="col-sm-10">
                                                <div class="form-check">
                                                    <input class="form-check-input" v-model="formData.signatory" type="radio"
                                                           name="signatory" id="signatory1" value="1" checked>
                                                    <label class="form-check-label" for="signatory1"> Yes </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" v-model="formData.signatory" type="radio"
                                                           name="signatory" id="signatory2" value="0">
                                                    <label class="form-check-label" for="signatory2"> No </label>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <fieldset class="form-group">
                                        <label for="authorized_person">Authorized Person:</label>
                                        <div class="row">
                                            <div class="col-sm-10">
                                                <div class="form-check">
                                                    <input class="form-check-input" v-model="formData.authorized_person" type="radio"
                                                           name="authorized_person" id="authorized_person1" value="1" checked>
                                                    <label class="form-check-label" for="authorized_person1"> Yes </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" v-model="formData.authorized_person" type="radio"
                                                           name="authorized_person" id="authorized_person2" value="0">
                                                    <label class="form-check-label" for="authorized_person2"> No </label>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6 text-center">
                                    <button type="submit" class="btn btn-success">Submit</button>
                                </div>
                                <div class="col-6 text-center">
                                    <button type="reset" class="btn btn-secondary" @click="resetForm">Cancel</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import ImageTag from "../ImageTag";
import ValidationErrors from "../ValidationErrors";

export default {
    name: "RenewalCompanyOwner",
    components: {ImageTag, ValidationErrors},
    props: ["is_member"],
    data: () => ({
        loading: false,
        errors: [],
        success: null,
        warning_message:null,
        validationErrors: null,
        date_of_today: new Date(),
        company_owner: 1,
        company_owners: [],
        countries: [],
        formData: {},
        initFromData: {
            id: null,
            name: null,
            designation: null,
            nid_no: null,
            attach_nid: null,
            educational_qualification: null,
            attach_educational_qualification: null,
            attach_photograph: null,
            mobile_no: null,
            email: null,
            nationality_id: null,
            attach_signature: null,
            experience_year: null,
            attach_experience_certificate: null
        }
    }),
    // computed:{
    // firmName: function (){
    //     return 'company_owner['+this.firmTypes+'][attach_signature]'
    // }
    // },
    created: function () {
        this.getCompanyOwners();
        this.getCountries();
    },
    methods: {
        saveImage: function (event) {
            this.formData[event.target.name] = event.target.files[0];
        },
        editOwner(company_owner) {
            this.formData = company_owner;
            window.scroll(0, 500)
        },
        activeOwner(id) {
            if (confirm("Active Company Owner?")) {
                if (confirm("All privilege will approved. So, Are you Sure?")) {
                    axios
                        .get("/api/company_owner/active/" + id + '/' + this.$route.params.id)
                        .then((res) => {
                            // this.showMessage = true;
                            this.success = res.data;
                            this.getCompanyOwners();
                        })
                        .catch((error) => {
                            console.error(error.response.data.message);
                        });
                }
            }
        },
        getCompanyOwners() {
            axios
                .get('/api/renew_member/company_owners/' + this.$route.params.id )
                .then(res => {
                    this.company_owners = res.data.data
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
            if (!this.formData.designation) this.errors.push(["designation", ["Designation required."]]);
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
            let myForm = document.getElementById('company-owner');
            let data = new FormData(myForm);
            data.append('id', this.formData.id);
            // data.append('member_id', this.$route.params.id);
            data.append('renew_member_id', this.$route.params.id);
            data.append('is_active', '0');
            const config = {
                headers: { //'content-type': 'multipart/form-data' }
                    'content-type': 'multipart/form-data',
                    'accept': 'application/json'
                }
            }

            axios.post("/api/company_owner", data, config).then(res => {
                this.success = 'Company Owner Updated Successfully';
                this.formData = this.initFromData;
                this.validationErrors = null;
                this.getCompanyOwners();
                if(this.is_member){
                    this.$router.push({
                        name: "renewal-company-owners-for-member",
                        params: {id: this.$route.params.id},
                        query: {success: this.success}
                    });
                }else{
                    this.$router.push({
                        name: "renewal-company-owners",
                        params: {id: this.$route.params.id},
                        query: {success: this.success}
                    });
                }
            }).catch(error => {
                if (error.response.status == 422) {
                    this.validationErrors = error.response.data.errors;
                } else {
                   this.warning_message = error.response.data.message;
                }
            })
        }
    }
}
</script>

<style scoped>

</style>
