<template>
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header text-center bg-info"><h4>ID Card Year:</h4></div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Year</th>
                                <th scope="col">Active</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(company_owner,i) in company_owners">
                                <th scope="row">{{ ++i }}</th>
                                <td>{{ company_owner.year }}</td>
                                <td>{{ company_owner.is_active }}</td>
                                <td>
                                    <button class="btn btn-icon" @click="editOwner(company_owner)"><i class="fa fa-edit"></i></button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <form @submit.prevent="submitForm" role="form" id="company-owner" autocomplete="off"
                              enctype="multipart/form-data">
                            <div id="notification">
                                <validation-errors :errors="validationErrors" :success="success"
                                                   :warning_message="warning_message"></validation-errors>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Year:</label>
                                        <input v-model="formData.year" type="text" class="form-control" name="year"
                                               id="exampleInputEmail1">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="is_active">Activation:</label>
                                        <input v-model="formData.is_active" type="number" class="form-control" name="is_active"
                                               id="is_active" max="1" min="0">
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
        warning_message:null,
        validationErrors: null,
        date_of_today: new Date(),
        company_owner: 1,
        company_owners: [],
        countries: [],
        formData: {},
        initFromData: {
            id: null,
            year: null,
            is_activation: null
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
                .get('/api/id_card_year')
                .then(res => {
                    this.company_owners = res.data
                }).catch(error => {
                console.error(error.response)
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
            if (!this.formData.year) this.errors.push(["name", ["Year required."]]);
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
            axios.post("/api/id_card_year", data).then(res => {
                this.success = 'ID Card Year Updated Successfully';
                this.formData = this.initFromData;
                this.validationErrors = null;
                this.getCompanyOwners();
                this.$router.push({
                    name: "id_card_year",
                    query: {success: this.success}
                });
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
