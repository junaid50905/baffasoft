<template>
    <div class="container">

        <div class="row"><div class="col-sm-12">
            <div class="card">
            <div class="card-header text-light bg-secondary bg-gradient"><h4 class="text-center">Training Activity (DG/CSA/Other)</h4></div>
            <div class="card-body">
                <table class="table mt-5">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Activity</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(training_name,i) in training_names">
                        <th scope="row">{{ ++i }}</th>
                        <td>{{ training_name.training_name }}</td>
                        <td><div>
                            <b-form-checkbox
                                v-model="training_name.visibility"
                                value="1"
                                unchecked-value="0"
                                name="visibility"
                                @change="updateChanges(training_name.id,training_name.visibility)"
                                switch size="lg">
                            </b-form-checkbox>
                        </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div></div></div></div>
    </div>
</template>

<script>
import ImageTag from "../ImageTag";
import ValidationErrors from "../ValidationErrors";

export default {
    name: "TrainingName",
    components: {ImageTag, ValidationErrors},
    data: () => ({
        loading: false,
        errors: [],
        success: null,
        warning_message:null,
        validationErrors: null,
        training_names: [],
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
        // this.getCompanyOwners();
        this.getTraining();
    },
    methods: {
        checkActivity(type) {
            return type ? true : false
        },
        getTraining() {
            axios
                .get('/api/training_names/all')
                .then(res => {
                    this.training_names = res.data;
                }).catch(error => {
                console.error(error.response.data.message)
            })
        },
        updateChanges(id,visibility) {
            console.log(id,visibility)
            axios
                .get('/api/training_names/' + id + '/'+ visibility )
                .then(res => {
                    this.$router.go()
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
        }
    }
}
</script>

<style scoped>

</style>
