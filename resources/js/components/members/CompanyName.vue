<template>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header text-light bg-secondary bg-gradient"><h4 class="text-center">Change Company Name</h4></div>
                    <div class="card-body">
                        <input type="text">
                    </div>
                </div>
            </div>
            <div class="col-sm-12" v-if="checkAccess('new_company_owner')">
                <div class="card">
                    <div class="card-body">
                        <form class="mt-5" @submit.prevent="submitForm" role="form" id="company-owner" autocomplete="off">
                            <div id="notification">
                                <validation-errors :errors="validationErrors" :success="success"
                                                   :warning_message="warning_message"></validation-errors>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Name:</label>
                                        <input v-model="formData.name" type="text" class="form-control" name="name"
                                               id="exampleInputEmail1">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6 text-center">
                                    <button type="submit" class="btn btn-success">Update Company Name</button>
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
    name: "CompanyOwner",
    components: {ImageTag, ValidationErrors},
    data: () => ({
        loading: false,
        errors: [],
        success: null,
        warning_message: null,
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
    },
    methods: {
        saveImage: function (event) {
            this.formData[event.target.name] = event.target.files[0];
        },
        editOwner(company_owner) {
            this.formData = company_owner;
            window.scroll(0, 500)
        },
        getCompanyOwners() {
            axios
                .post('/api/members/' + this.$route.params.id + '/change_company_name')
                .then(res => {
                    this.company_owners = res.data.data
                }).catch(error => {
                console.error(error.response)
            })
        },
        // getCountries() {
        //     axios
        //         .get('/api/members/countries')
        //         .then(res => {
        //             this.countries = res.data
        //         }).catch(error => {
        //         console.error(error.response.data.message)
        //     })
        // },
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
            data.append('member_id', this.$route.params.id);
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
                this.$router.push({
                    name: "company_owners",
                    params: {id: this.$route.params.id},
                    query: {success: this.success}
                });
            }).catch(error => {
                if (error.response.status == 422) {
                    this.validationErrors = error.response.data.errors;
                } else {
                    this.warning_message = error.response.data.message;
                }
            })
        },
        deleteMember(id) {
            if (confirm("Delete Company Owner?")) {
                if (confirm("All privilege will removed. So, Are you Sure?")) {
                    axios
                        .delete("/api/company_owner/" + id)
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
        }
    }
}
</script>

<style scoped>

</style>
