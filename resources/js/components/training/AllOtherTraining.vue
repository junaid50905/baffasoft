<template>
    <div class="container"><div class="row"><div class="col-sm-12"><div class="card">
        <div class="card-header text-light bg-secondary bg-gradient"><h4 class="text-center">Other Training</h4></div>
        <div class="card-body">
        <validation-errors
            :errors="validationErrors"
            :success="success"
            :warning_message="warning_message"
        ></validation-errors>
        <b-row v-if="!is_member">
            <b-col lg="6" class="my-1"></b-col>
            <b-col lg="3" class="my-1"></b-col>
            <b-col sm="3" md="3" class="my-1">
                <json-excel
                    class="btn btn-sm btn-outline-success"
                    :header="header"
                    :data="company_owners"
                    :fields="json_fields"
                    :before-generate="beforeExcelGenerate"
                    :before-finish="() => (loading = false)"
                    worksheet="BAFFA Worksheet"
                    name="Training.xls"
                >
                    Download
                    <i class="fas fa-file-excel text-success"/>
                    <!--                                <img :src="addProjectPath('/images/download-excel.png')"  />-->
                </json-excel>
            </b-col>
        </b-row>
        <b-row v-if="!is_member">
            <b-col sm="2" md="2" class="my-1">
                <b-input-group>
                    <b-form-input
                        v-model="submission_year"
                        name="submission_year"
                        type="number"
                        placeholder="Year"
                    ></b-form-input>
                </b-input-group>
            </b-col>
            <b-col sm="3" md="3" class="my-1">
                <b-input-group>
                    <b-form-input
                        v-model="select_participant"
                        name="select_participant"
                        type="search"
                        placeholder="Participant Name"
                    ></b-form-input>
                </b-input-group>
            </b-col>
            <b-col sm="3" md="3" class="my-1">
                <v-select
                    v-model="selected_bmn_no"
                    :options="organizations"
                    :reduce="(organizations) => organizations.id"
                    label="organization_name"
                ></v-select>
            </b-col>
            <b-col lg="4" md="4" class="my-1">
                <b-form-group class="mb-0">
                    <b-input-group size="sm">
                        <b-form-select v-model="select_status" size="sm" class="w-25">
                            <option value="">Select Status</option>
                            <option value="Pending">Pending</option>
                            <option value="Verified">Verified</option>
                            <option value="Paid">Paid</option>
                        </b-form-select>
                    </b-input-group>
                </b-form-group>
            </b-col>
        </b-row>
        <b-row v-if="!is_member">
            <b-col sm="5" md="5" class="my-1">
                <datepicker
                    input-class="form-control form-control-sm"
                    name="seconded_by_date"
                    v-model="start_date"
                />
            </b-col>
            <b-col sm="5" md="5" class="my-1">
                <datepicker
                    input-class="form-control form-control-sm"
                    name="seconded_by_date"
                    v-model="end_date"
                />
            </b-col>
            <b-col sm="2" md="2" class="my-1">
                <div class="d-grid gap-2">
                    <b-button size="sm" :disabled="!end_date" @click="doFilterByDate"
                    >Generate Report
                    </b-button>
                </div>
            </b-col>
        </b-row>
        <b-row>
            <b-col sm="5" md="6" class="my-1">
                <b-form-group
                    label="Per page"
                    label-for="per-page-select"
                    label-cols-sm="6"
                    label-cols-md="4"
                    label-cols-lg="3"
                    label-align-sm="right"
                    label-size="sm"
                    class="mb-0"
                >
                    <b-form-select
                        id="per-page-select"
                        v-model="perPage"
                        :options="pageOptions"
                        size="sm"
                    ></b-form-select>
                </b-form-group>
            </b-col>

            <b-col sm="7" md="6" class="my-1">
                <b-pagination
                    v-model="currentPage"
                    :total-rows="totalRows"
                    :per-page="perPage"
                    align="fill"
                    size="sm"
                    class="my-0"
                ></b-pagination>
            </b-col>
        </b-row>
        <br/>
        <b-table
            striped
            hover
            small
            show-empty
            id="table-transition-example"
            primary-key="id"
            :items="company_owners"
            :fields="fields"
            :current-page="currentPage"
            :per-page="perPage"
            :busy.sync="isBusy"
        >
            <template #cell(actions)="row">
          <span v-if="!is_member">
<!--        <span v-if="checkAccess('edit-training')">
          <router-link
            title="Training"
            :to="{ name: 'edit_training_csa', params: { id: row.item.id } }"
            class="btn btn-secondary btn-sm"
          >
            Edit
          </router-link>
        </span>-->
        <span v-if="checkAccess('view-training')">
          <router-link
              title="Training"
              :to="{ name: 'training_other', params: { id: row.item.id } }"
              class="btn btn-secondary btn-sm"
          >
            View
          </router-link>
        </span>
        <span v-if="checkAccess('approve-training')">
          <button
              v-if="row.item.status === 'Pending' ? true : false"
              @click="verifyMember(row.item.id)"
              class="btn btn-warning btn-sm"
          >
            Approval
          </button>
        </span>
              <span v-if="checkAccess('delete-training')">
                    <button v-if="row.item.status === 'Pending' ? true : false"
                            @click="deleteMember(row.item.id)"  class="btn btn-danger btn-sm">X
                                    </button>
                </span>


        <span v-if="checkAccess('payment-training')">
          <router-link
              v-if="row.item.status === 'Verified' ? true : false"
              :to="{
              name: 'new-collection',
              params: { member_id: row.item.member_id },
              query: {
                  props_id: row.item.id,
                  props_receipt_type: 'other_training',
                  props_receipt_year: row.item.submission_year
                },
            }"
              class="btn btn-success btn-sm"
          >Payment</router-link
          >
        </span>
        <a
            v-if="row.item.is_payment"
            class="btn btn-primary btn-sm"
            target="_blank"
            :href="addProjectPath('/print_money_receipt/' + row.item.money_collection_id)"
        >Voucher</a
        ></span>
            </template>
        </b-table>
        <div
            id="loader"
            v-if="loading"
            v-bind:style="{
        backgroundImage: 'url(' + addProjectPath('/assets/img/ajax-loader.gif') + ')',
      }"
        ></div>
        </div></div></div></div></div>
</template>

<script>
import ValidationErrors from "../ValidationErrors";
import JsonExcel from "vue-json-excel";
import vSelect from "vue-select";
import Datepicker from "vuejs-datepicker";

export default {
    name: "AllDGTraining",
    components: {JsonExcel, ValidationErrors, vSelect, Datepicker},
    props: ["success", 'is_member'],
    data: () => ({
        role:null,
        submission_year:'',
        isLoggedIn: false,
        user: null,
        updated_user_id: null,
        nameState: null,
        training_id: null,
        previous_caab_id_no: null,
        caab_id_no: null,
        certificate_number: null,

        header: ["Other Training"],
        selected_bmn_no: null,
        select_participant: null,
        select_status: null,
        start_date: new Date().toISOString().slice(0, 10),
        end_date: new Date().toISOString().slice(0, 10),
        fields: [
            {
                key: "member",
                label: "Organization",
                sortable: true,
            },
            {
                key: "other_training_name",
                label: "Training Name",
            },
            {key: "submission_year", label: 'Year'},
            {key: "participant_name", label: "Name"},
            {key: "participant_mobile", label: "Phone"},
            "status",
            "created_at",
            "actions",
        ],
        json_fields: {
            YEAR: {
                field: "applicantion_date",
                callback: (value) => {
                    return value.substr(-4); //moment(value).format('YYYY');
                },
            },
            DATE: "applicantion_date",
            "Training Name": "other_training_name",
            "Name of the Participant": "participant_name",
            Designation: "participant_designation",
            "Name of the Organization": "member",
            "Mobile No.": "participant_mobile",
            "Participant email": "participant_email",
            "Money Receipt No.": "money_collection_no",
            "Money Receipt Date": "money_collection_date",
            Amount: "money_collection_amount",
            "Created By": "created_by",
            "Last Updated By": "updated_by",
            "Last update Date": "updated_at",
            // 'PHOTO':"voter_image"
        },
        warning_message: null,
        validationErrors: null,
        currentPage: 1,
        perPage: 10,
        isBusy: false,
        pageOptions: [10, 15, {value: 100, text: "Show a lot"}],
        totalRows: 1,
        filter: null,

        loading: false,
        company_owners: [],
        countries: [],
        formData: {},
        initFromData: {
            id: null,
            name: null,
            election_session: null,
            election_date: new Date().toISOString().slice(0, 10),
            nomination_from_submission_deadline: new Date().toISOString().slice(0, 10),
        },
        organizations: [],
        customTraining: [],
    }),
    // computed:{
    // firmName: function (){
    //     return 'company_owner['+this.firmTypes+'][attach_signature]'
    // }
    // },
    created() {
        if (window.Laravel.isLoggedin) {
            this.isLoggedIn = true;
            this.user = window.Laravel.user;
            this.updated_user_id = this.user.id;
            this.role = this.user.role_id;

            if (!this.is_member)
                this.getOrganizations();
            this.getCompanyOwners();
            // this.member_name = window.Laravel.user.email
        } else {
            console.log("Member Not Log In");
        }
    },
    methods: {
        sendInfo(id, previous_caab_id_no) {
            this.training_id = id;
            this.previous_caab_id_no = previous_caab_id_no;
            this.comment = id;
            console.log("Training ID: ", id);
            console.log("CAAB ID: ", previous_caab_id_no);
            // this.selectedUser = item;
        },
        verifyMember(id) {
            if (confirm("Do you really want to Approve ?")) {
                axios
                    .put("/api/training/" + id)
                    .then((res) => {
                        // this.showMessage = true;
                        this.success = res.data;
                        this.getCompanyOwners();
                    })
                    .catch((error) => {
                        console.error(error);
                    });
            }
        },
        deleteMember(id) {
            if (confirm("Do you really want to Delete?")) {
                axios
                    .delete('/api/training/' + id)
                    .then(res => {
                        // this.showMessage = true;
                        this.success = res.data;
                        this.getCompanyOwners();
                    }).catch(error => {
                    console.error(error)
                })
            }
        },
        doFilterByDate() {
            let start_date = this.customFormatter(this.start_date);
            let end_date = this.customFormatter(this.end_date);
            console.log(start_date, end_date, this.selected_bmn_no);
            if (end_date >= start_date) {
                this.loading = true;
                axios
                    .get(
                        "/api/training?" +
                        "training_name=other" +
                        "&start_date=" +
                        start_date +
                        "&end_date=" +
                        end_date +
                        "&member_id=" +
                        this.selected_bmn_no +
                        "&submission_year=" +
                        this.submission_year +
                        "&participant_name=" +
                        this.select_participant +
                        "&status=" +
                        this.select_status
                    )
                    .then((res) => {
                        this.company_owners = res.data.data;
                        this.totalRows = this.company_owners.length;
                    })
                    .catch((error) => {
                        console.error(error);
                    })
                    .finally(() => {
                        this.loading = false;
                    });
            } else {
                alert("End Date is greater than start date");
            }
        },
        customFormatter(date) {
            return moment(date).format("YYYY-MM-DD");
        },
        beforeExcelGenerate() {
            this.loading = true;
        },
        getOrganizations() {
            axios
                .get("/api/members/organizations")
                .then((res) => {
                    this.organizations = res.data;
                })
                .catch((error) => {
                    console.error(error);
                });
        },
        getCompanyOwners() {
            let url = '/api/training?training_name=other';
            if (this.is_member && this.user)
                url = '/api/training?training_name=other&member_id=' + this.user.id
            axios
                .get(url)
                .then((res) => {
                    this.company_owners = res.data.data;
                    this.totalRows = this.company_owners.length;
                })
                .catch((error) => {
                    console.error(error.response);
                });
        },
    },
};
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
